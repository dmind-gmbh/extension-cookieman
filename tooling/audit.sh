#!/bin/sh
# Audits the lock files of one ecosystem and fails on an advisory that
# extra.ci.allow-failure-parts.<ecosystem>.advisories of composer.json does
# not list. An entry matches any ID of an advisory (for example PKSA, CVE or
# GHSA).
#
# It also fails on an abandoned package that
# extra.ci.allow-failure-parts.<ecosystem>.abandoned does not list by name.
# composer audit reports abandoned packages. For npm, the deprecated packages
# of package-lock.json count as abandoned, and this script names those that
# fail. yarn.lock has no such data.
#
# composer audit can ignore advisories only in the root composer.json, not in
# vendor-bin/*. yarn 1 and npm audit cannot ignore them at all. So this script
# shows the normal report, and decides from a second, JSON report.
#
# Usage: tooling/audit.sh composer|nodejs [<lock file> ...]
# Without a lock file, it audits each lock file of the ecosystem that git
# tracks: composer.lock and vendor-bin/*/composer.lock, or each yarn.lock and
# package-lock.json.
set -eu

ecosystem=${1:-}
case $ecosystem in
    composer|nodejs) shift ;;
    *) echo "Usage: tooling/audit.sh composer|nodejs [<lock file> ...]"; exit 2 ;;
esac
if [ $# -eq 0 ]; then
    # shellcheck disable=SC2046 # The paths of the lock files contain no spaces.
    case $ecosystem in
        composer) set -- $(git ls-files -- composer.lock 'vendor-bin/*/composer.lock') ;;
        nodejs) set -- $(git ls-files -- ':(glob)**/yarn.lock' ':(glob)**/package-lock.json') ;;
    esac
fi

allowed=$(jq --compact-output --arg ecosystem "$ecosystem" \
    '.extra.ci."allow-failure-parts"[$ecosystem] // {} | {advisories: (.advisories // []), abandoned: (.abandoned // [])}' composer.json)

# A yarn 1 lock file needs yarn 1. Under corepack, "yarn" can be a later major without "yarn audit".
yarn1() {
    if yarn --version 2>/dev/null | grep --quiet '^1\.'; then
        yarn "$@"
    elif command -v npx > /dev/null 2>&1; then
        npx --yes yarn@1 "$@"
    else
        echo "ERROR: yarn 1 is not installed, and npx is not there to get it" >&2
        return 127
    fi
}

# Prints the audit report of one lock file as JSON.
auditJson() {
    case $1 in
        composer) composer --working-dir="$2" audit --locked --abandoned=report --format=json ;;
        yarn) (cd "$2" && yarn1 audit --json --non-interactive) ;;
        npm) (cd "$2" && npm audit --json) ;;
    esac
}

status=0
for lockFile in "$@"; do
    directory=$(dirname "$lockFile")
    # Each report becomes {complete, advisories: [{ids, module, severity, url}], abandoned: [<name>]}.
    # A report that is not complete means that the audit did not run.
    deprecated='[]'
    case $ecosystem/$(basename "$lockFile") in
        composer/composer.lock)
            tool=composer
            echo "composer audit in $directory"
            composer --working-dir="$directory" audit --locked --abandoned=report || true
            normalize='input | {
                complete: has("advisories"),
                advisories: ([.advisories // {} | .[][]
                    | {ids: ([.advisoryId, .cve, (.link // "" | scan("GHSA(?:-[0-9a-z]{4}){3}")), .sources[]?.remoteId] | map(select(. != null))),
                       module: .packageName, severity: (.severity // "unknown"), url: .link}] | unique),
                abandoned: (.abandoned // {} | keys)
            }'
            ;;
        nodejs/yarn.lock)
            tool=yarn
            echo "yarn audit in $directory"
            if grep --quiet '^__metadata:' "$lockFile"; then
                echo "ERROR: $lockFile is a lock file of yarn 2 or later; this script audits yarn 1 lock files only"
                status=1
                continue
            fi
            if ! yarn --version 2>/dev/null | grep --quiet '^1\.' && ! command -v npx > /dev/null 2>&1; then
                echo "ERROR: yarn 1 is not installed, and npx is not there to get it"
                status=1
                continue
            fi
            (cd "$directory" && yarn1 audit --non-interactive) || true
            normalize='[inputs] | {
                complete: any(.[]; .type == "auditSummary"),
                advisories: ([.[] | select(.type == "auditAdvisory") | .data.advisory
                    | {ids: [.github_advisory_id], module: .module_name, severity, url}] | unique),
                abandoned: []
            }'
            ;;
        nodejs/package-lock.json)
            tool=npm
            echo "npm audit in $directory"
            if ! command -v npm > /dev/null 2>&1; then
                echo "ERROR: npm is not installed"
                status=1
                continue
            fi
            (cd "$directory" && npm audit) || true
            deprecated=$(jq --compact-output \
                '[.packages // {} | to_entries[] | select(.value.deprecated) | .key | sub("^.*node_modules/"; "")] | unique' \
                "$lockFile") || deprecated='[]'
            # An entry whose "via" is a package name only repeats an advisory of that package.
            normalize='input | {
                complete: has("metadata"),
                advisories: ([.vulnerabilities // {} | .[] | .via[] | objects
                    | {ids: [.url | sub("^.*/"; "")], module: .name, severity, url}] | unique),
                abandoned: $deprecated
            }'
            ;;
        *)
            echo "ERROR: $lockFile is not a lock file of $ecosystem"
            status=1
            continue
            ;;
    esac
    # The audit services sometimes refuse a request (for example HTTP 429). Retry before giving up.
    for wait in 10 30 60 none; do
        report=$(auditJson "$tool" "$directory") || true
        result=$(printf '%s\n' "$report" | jq --null-input --compact-output --argjson deprecated "$deprecated" "$normalize") \
            || result='{"complete": false, "advisories": [], "abandoned": []}'
        if [ "$wait" = none ] || printf '%s\n' "$result" | jq --exit-status '.complete' > /dev/null; then
            break
        fi
        echo "The audit gave no complete report. Next try in $wait seconds."
        sleep "$wait"
    done
    # composer audit shows abandoned packages, npm audit does not.
    printf '%s\n' "$result" | jq --raw-output --argjson allowed "$allowed" --arg ecosystem "$ecosystem" '
        (.advisories[] | "\(if any(.ids[]; IN($allowed.advisories[])) then "ignored" else "not ignored" end): \(.module) \(.severity) \(.ids[0]) \(.url)"),
        (if $ecosystem == "nodejs" then .abandoned[] | select(IN($allowed.abandoned[]) | not) | "not ignored: \(.) is deprecated" else empty end),
        (if .complete then empty else "ERROR: the audit gave no complete report" end)
    '
    if ! printf '%s\n' "$result" | jq --exit-status --argjson allowed "$allowed" \
        '.complete and all(.advisories[]; any(.ids[]; IN($allowed.advisories[])))
            and all(.abandoned[]; IN($allowed.abandoned[]))' > /dev/null; then
        status=1
    fi
done
exit $status
