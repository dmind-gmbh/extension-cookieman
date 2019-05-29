// requires: cookieman.js, Bootstrap-JS, jQuery
cookieman.bootstrap3banner = (function () {
    "use strict";
    var $modal = jQuery('#cookieman-modal')
    var showBackdrop = true

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
// jQuery(function () {
//     cookieman.bootstrap3banner.init()
// })
