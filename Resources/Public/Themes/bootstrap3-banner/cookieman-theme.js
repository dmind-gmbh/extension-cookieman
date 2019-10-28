// requires: cookieman.js, Bootstrap-JS, jQuery
cookieman.theme = (function () {
    "use strict";
    var showBackdrop = true

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
