// requires: cookieman.js, Bootstrap-JS, jQuery
cookieman.theme = (function () {
    "use strict";
    var showBackdrop = true

    // show "accept all" after opening settings
    document.querySelector('[href="#cookieman-settings"]')
        .addEventListener('click', function () {
            document.querySelector('[data-cookieman-accept-all]').style.display = 'inline-block'
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
