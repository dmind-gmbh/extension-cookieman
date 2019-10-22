// requires: js.cookie
var cookieman = (function () {
    "use strict";
    var cookieName = 'CookieConsent',
        cookieDurationDays = 365,
        form = document.querySelector('[data-cookieman-form]'),
        checkboxes = form.querySelectorAll('[type=checkbox][name]'),
        saveButtons = document.querySelectorAll('[data-cookieman-save]'),
        acceptAllButtons = document.querySelectorAll('[data-cookieman-accept-all]')

    function saveSelections() {
        var consented = []
        for (var _i = 0; _i < checkboxes.length; _i++) {
            if (checkboxes[_i].checked) {
                consented.push(checkboxes[_i].name)
            }
        }

        Cookies.set(
            cookieName,
            consented.join(','),
            {expires: cookieDurationDays}
        )
    }

    function setChecked(checkbox, state) {
        checkbox.checked = state
    }

    function selectNone() {
        for (var _i = 0; _i < checkboxes.length; _i++) {
            setChecked(checkboxes[_i], false)
        }
    }

    function selectAll() {
        for (var _i = 0; _i < checkboxes.length; _i++) {
            setChecked(checkboxes[_i], true)
        }
    }
    
    function consentedSelections() {
        var cookie = Cookies.get(cookieName)
        return cookie ? cookie.split(',') : []
    }

    function loadSelections() {
        var consented = consentedSelections()
        selectNone()
        for (var _i = 0; _i < consented.length; _i++) {
            var _checkbox = form.querySelector('[name=' + consented[_i] + ']')
            if (_checkbox) {
                setChecked(_checkbox, true)
            }
        }
    }

    function onSaveClick(e) {
        e.preventDefault()
        saveSelections()
        cookieman.hide()
    }

    function onAcceptAllClick(e) {
        e.preventDefault()
        selectAll()
    }

    function init() {
        loadSelections()
        for (var i = 0; i < acceptAllButtons.length; i++) {
            acceptAllButtons[i].addEventListener(
                'click',
                onAcceptAllClick
            )
        }
        for (i = 0; i < saveButtons.length; i++) {
            saveButtons[i].addEventListener(
                'click',
                onSaveClick
            )
        }
    }

    init()

    return {
        show: function () {
            console.error('Your theme should implement function cookieman.show()')
        },
        hide: function () {
            console.error('Your theme should implement function cookieman.hide()')
        },
        showOnce: function () {
            if (typeof Cookies.get(cookieName) === 'undefined') {
                cookieman.show()
            }
        },
        hasConsented: function(selection) {
            var consented = consentedSelections()
            for (var i = 0; i < consented.length; i++) {
                if (consented[i] === selection) {
                    return true
                }
            }
            return false
        }
    }
}())
