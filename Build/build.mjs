// Builds the JS/CSS assets shipped in ../Resources/Public.
//
// Why this isn't a plain `vite build`: none of these files import one another
// (verified: zero `import`/`export` anywhere in the sources) and several rely on a
// bare top-level `var cookieman = ...` becoming a real global that *other*,
// separately-loaded <script> tags read (cookieman-init.js, every theme's
// cookieman-theme.js). Rollup/Rolldown's bundler — which any `iife`/`umd`/`es`
// `vite build` goes through — removes that unused-within-its-own-module binding
// even with `treeshake: false`, silently breaking every theme. Per-file transform
// (no module graph) sidesteps that class of bug entirely, and matches what the old
// webpack.mix.js actually did: transform/minify each file, don't bundle.
//
// Mapping (mirrors webpack.mix.js's `.minify()` calls, extended for .ts/.scss):
//   *.js   -> *.min.js            (source is the readable output, untouched)
//   *.css  -> *.min.css           (source is the readable output, untouched)
//   *.ts   -> *.js  + *.min.js    (both generated)
//   *.scss -> *.css + *.min.css   (both generated)

import { readFileSync, writeFileSync, readdirSync, statSync, copyFileSync, mkdirSync } from 'node:fs'
import path from 'node:path'
import { fileURLToPath } from 'node:url'
import { minifySync, transformWithOxc } from 'vite'
import * as sass from 'sass'
import { transform as lightningcssTransform, browserslistToTargets } from 'lightningcss'
import browserslist from 'browserslist'
import browserslistToEsbuild from 'browserslist-to-esbuild'

const rootDir = path.dirname(fileURLToPath(import.meta.url))
const resourcesPublicDir = path.resolve(rootDir, '../Resources/Public')
const jsDir = path.join(resourcesPublicDir, 'Js')
const themesDir = path.join(resourcesPublicDir, 'Themes')

const browsers = browserslist(undefined, { path: rootDir })
const cssTargets = browserslistToTargets(browsers)
const jsTargets = browserslistToEsbuild(browsers)

function isSourceFile(name) {
    if (/\.min\.(js|css)$/.test(name)) return false
    return /\.(js|ts|css|scss)$/.test(name)
}

function collectEntries() {
    const dirs = [jsDir]
    for (const name of readdirSync(themesDir)) {
        const dir = path.join(themesDir, name)
        if (statSync(dir).isDirectory()) dirs.push(dir)
    }

    const entries = []
    for (const dir of dirs) {
        const files = readdirSync(dir).filter((name) => {
            const full = path.join(dir, name)
            return statSync(full).isFile() && isSourceFile(name)
        })

        const seenBase = new Map()
        for (const name of files) {
            const ext = path.extname(name)
            const base = name.slice(0, -ext.length)
            const kind = ext === '.ts' || ext === '.js' ? 'js' : 'css'
            const key = `${kind}:${base}`
            if (seenBase.has(key)) {
                throw new Error(
                    `Both "${seenBase.get(key)}" and "${name}" exist in ${dir} — remove one, only one source per output is supported.`
                )
            }
            seenBase.set(key, name)
            entries.push({ dir, file: path.join(dir, name), name, ext, base, kind })
        }
    }
    return entries
}

async function buildJsEntry(entry) {
    const src = readFileSync(entry.file, 'utf8')
    const outBase = path.join(entry.dir, entry.base)

    let readableCode
    if (entry.ext === '.ts') {
        const result = await transformWithOxc(src, entry.file, { lang: 'ts', target: jsTargets })
        readableCode = result.code
        writeFileSync(`${outBase}.js`, readableCode)
    } else {
        readableCode = src
    }

    const minified = minifySync(`${entry.base}.js`, readableCode, {})
    writeFileSync(`${outBase}.min.js`, minified.code)
}

function buildCssEntry(entry) {
    const outBase = path.join(entry.dir, entry.base)

    let readableCss
    if (entry.ext === '.scss') {
        const compiled = sass.compile(entry.file, { style: 'expanded' }).css
        readableCss = lightningcssTransform({
            filename: `${entry.base}.css`,
            code: Buffer.from(compiled),
            targets: cssTargets,
            minify: false,
        }).code.toString()
        writeFileSync(`${outBase}.css`, readableCss)
    } else {
        readableCss = readFileSync(entry.file, 'utf8')
    }

    // minify from the readable output (not the raw sass/source) so *.css and *.min.css
    // can never diverge — same input feeds both, which matters for `minify=0` fallback.
    const minified = lightningcssTransform({
        filename: `${entry.base}.css`,
        code: Buffer.from(readableCss),
        targets: cssTargets,
        minify: true,
    })
    writeFileSync(`${outBase}.min.css`, minified.code.toString())
}

async function buildEntry(entry) {
    if (entry.kind === 'js') {
        await buildJsEntry(entry)
    } else {
        buildCssEntry(entry)
    }
}

function copyJsCookie() {
    mkdirSync(jsDir, { recursive: true })
    copyFileSync(
        path.join(rootDir, 'node_modules/js-cookie/dist/js.cookie.min.js'),
        path.join(jsDir, 'js.cookie.min.js')
    )
}

async function buildAll() {
    const entries = collectEntries()
    for (const entry of entries) {
        await buildEntry(entry)
    }
    copyJsCookie()
    console.log(`built ${entries.length} entries + copied js-cookie`)
    return entries
}

async function main() {
    const watch = process.argv.includes('--watch')
    const entries = await buildAll()

    if (!watch) return

    const { watch: chokidarWatch } = await import('chokidar')
    const watcher = chokidarWatch(entries.map((e) => e.file), { ignoreInitial: true })
    watcher.on('change', async (file) => {
        const entry = entries.find((e) => e.file === file)
        if (!entry) return
        try {
            await buildEntry(entry)
            console.log(`rebuilt ${path.relative(resourcesPublicDir, entry.file)}`)
        } catch (err) {
            console.error(err)
        }
    })
    console.log('watching for changes... (new files require restarting watch)')
}

main().catch((err) => {
    console.error(err)
    process.exitCode = 1
})
