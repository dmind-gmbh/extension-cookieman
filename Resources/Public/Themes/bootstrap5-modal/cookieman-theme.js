// requires: cookieman.js, Bootstrap-JS for modals as bootstrap.Modal()
/** global: cookieman */
(function () {
  "use strict";
  var showBackdrop = true,
    modal = null

  // show "save" after opening settings.
  // delegated: cookieman puts the popup into the page later
  document.addEventListener('click', function (ev) {
    if (!ev.target || !ev.target.closest('[aria-controls="cookieman-settings"]')) {
      return
    }
    var saveBtn = document.querySelector(
      '[data-cookieman-save]:not([data-cookieman-accept-all]):not([data-cookieman-accept-none])'
    )
    if (saveBtn) {
      saveBtn.hidden = false
    }
  })

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
