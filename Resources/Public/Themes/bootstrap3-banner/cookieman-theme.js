// requires: cookieman.js, Bootstrap-JS, jQuery
cookieman.bootstrap3Banner = (function () {
    "use strict";
    var $modal = jQuery('#cookieman-modal'),
        $accordion = jQuery('#cookieman-acco'),
        $checkboxWrappers = $accordion.find('.panel-title-checkbox'),
        showBackdrop = true

    cookieman.show = function () {
        $modal.modal({show: true, backdrop: showBackdrop})
    }
    cookieman.hide = function () {
        $modal.modal('hide')
    }

    return {
        // initJquery: function () {
        // }
    }
}())

// jQuery(function () {
//     cookieman.bootstrap3Banner.initJquery()
// })
