// requires: cookieman.js, Bootstrap-JS, jQuery
cookieman.theme = (function () {
    "use strict";
    var $modal = jQuery('#cookieman-modal'),
        showBackdrop = true

    cookieman.show = function () {
        $modal.modal({show: true, backdrop: showBackdrop})
    }
    cookieman.hide = function () {
        $modal.modal('hide')
    }

    // example if you need to initialize
    // return {
    //     init: function () {
    //     }
    // }
}())

// example if you need to initialize
// jQuery(function () { // if you need jQuery
//     cookieman.theme.init()
// })
