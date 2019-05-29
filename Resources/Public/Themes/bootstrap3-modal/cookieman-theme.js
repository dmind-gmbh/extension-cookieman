// requires: cookieman.js, Bootstrap-JS, jQuery
cookieman.bootstrap = (function () {
    "use strict";
    var $modal = jQuery('#cookieman-modal')

    cookieman.show = function () {
        $modal.modal('show')
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
//     cookieman.bootstrap.init()
// })
