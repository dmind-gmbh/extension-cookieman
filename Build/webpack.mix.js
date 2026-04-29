const mix = require('laravel-mix')

mix.options({
    progress: false,
    manifest: false,
    legacyNodePolyfills: false
})

// Remove WebpackBarPlugin to avoid compatibility issues with recent Webpack 5 versions
mix.override((config) => {
    config.plugins = config.plugins.filter(plugin => plugin.constructor.name !== 'WebpackBarPlugin')
})

mix.setPublicPath('../Resources/Public/Js/')

mix
    .minify('../Resources/Public/Js/cookieman.js')
    .minify('../Resources/Public/Js/cookieman-init.js')
    .minify('../Resources/Public/Themes/bootstrap3-banner/cookieman-theme.css')
    .minify('../Resources/Public/Themes/bootstrap3-banner/cookieman-theme.js')
    .minify('../Resources/Public/Themes/bootstrap3-modal/cookieman-theme.css')
    .minify('../Resources/Public/Themes/bootstrap3-modal/cookieman-theme.js')
    .minify('../Resources/Public/Themes/bootstrap4-modal/cookieman-theme.css')
    .minify('../Resources/Public/Themes/bootstrap4-modal/cookieman-theme.js')
    .minify('../Resources/Public/Themes/bootstrap5-modal/cookieman-theme.css')
    .minify('../Resources/Public/Themes/bootstrap5-modal/cookieman-theme.js')

mix.copy('node_modules/js-cookie/dist/js.cookie.min.js', '../Resources/Public/Js/')
