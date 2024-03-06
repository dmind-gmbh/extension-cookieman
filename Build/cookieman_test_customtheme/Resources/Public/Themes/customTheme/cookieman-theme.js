// requires: cookieman.js, Bootstrap-JS, jQuery
/** global: cookieman */
/** global: jQuery */
cookieman.theme = (function () {
  "use strict";
  var showBackdrop = true

  // show "save" after opening settings
  jQuery(function () {
    jQuery('[aria-controls="cookieman-settings"]').on(
      'click',
      function () {
        jQuery('[data-cookieman-save]').show()
      }
    )
  })

  cookieman.show = function () {
    jQuery(function () {
      var $modal = jQuery('#cookieman-modal')
      $modal.modal({show: true, backdrop: showBackdrop})
    })
  }
  cookieman.hide = function () {
    jQuery(function () {
      var $modal = jQuery('#cookieman-modal')
      $modal.modal('hide')
    })
  }
}())
