// Runs `tsc --noEmit` only if there's at least one .ts source to check — tsc errors
// out on an empty match set, and there are no .ts files in this repo yet.
import { execSync } from 'node:child_process'
import { readdirSync, statSync } from 'node:fs'
import path from 'node:path'
import { fileURLToPath } from 'node:url'

const rootDir = path.dirname(fileURLToPath(import.meta.url))
const resourcesPublicDir = path.resolve(rootDir, '../Resources/Public')

function hasTsFile(dir) {
    for (const name of readdirSync(dir)) {
        const full = path.join(dir, name)
        const stats = statSync(full)
        if (stats.isDirectory()) {
            if (hasTsFile(full)) return true
        } else if (name.endsWith('.ts')) {
            return true
        }
    }
    return false
}

if (hasTsFile(resourcesPublicDir)) {
    execSync('npx tsc --noEmit', { cwd: rootDir, stdio: 'inherit' })
} else {
    console.log('no .ts files yet, skipping type-check')
}
