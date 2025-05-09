const mix = require('laravel-mix')

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
  .setPublicPath('../Resources/Public/Js/')

mix
  .copy('node_modules/js-cookie/dist/js.cookie.min.js', '../Resources/Public/Js/')
