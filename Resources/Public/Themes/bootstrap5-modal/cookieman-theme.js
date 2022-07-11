// requires: cookieman.js, Bootstrap-JS
/** global: cookieman */
(function () {
  "use strict";
  var showBackdrop = true,
    showSettingsBtn = document.querySelector('[aria-controls="cookieman-settings"]'),
    modal = null

  // show "save" after opening settings
  if (showSettingsBtn) {
    showSettingsBtn.addEventListener('click', function (ev) {
      var saveBtn = document.querySelector(
        '[data-cookieman-save]:not([data-cookieman-accept-all]):not([data-cookieman-accept-none])'
      )
      if (saveBtn) {
        saveBtn.hidden = false
      }
    })
  }

  cookieman.show = function () {
    modal = new bootstrap.Modal(
      document.getElementById('cookieman-modal'),
      {
        backdrop: showBackdrop
      }
    )
    modal.show()
  }
  cookieman.hide = function () {
    modal && modal.hide()
  }
})()
