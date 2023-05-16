// requires: cookieman.js,
// Foundation Reveal JS
// Foundation Accordion JS
// Foundation Motion-UI JS
// jQuery
// maybe some more default JS libraries from Foundation
/** global: cookieman */
(function () {
  "use strict";
  var showSettingsBtn = document.querySelector('[aria-controls="cookieman-settings"]'),
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
        $('#cookieman-settings').foundation('toggle',$('.accordion-content-settings'));
    });
  }

  cookieman.show = function () {
    modal = new Foundation.Reveal(
        $('#cookieman-modal'),
        {
            // options: https://get.foundation/sites/docs/reveal.html#js-options
            'closeOnClick': false,
            'animationIn': 'fade-in',
            'animationOut': 'fade-out'
        });
      modal.open();
  }
  cookieman.hide = function () {
    modal && modal.close()
  }
})()
