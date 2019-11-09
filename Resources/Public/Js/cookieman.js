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
            var _checkbox = checkboxes[_i]
            if (!_checkbox.disabled) { // exclude disabled (problably preselected) ones
                setChecked(_checkbox, false)
            }
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

    function loadCheckboxStates() {
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

    function setDnt() {
        var dnt = document.querySelector('[data-cookieman-dnt]')
        if (dnt) {
            if (navigator.doNotTrack === '1') {
                dnt.innerHTML = form.dataset.cookiemanDntEnabled
            } else if (navigator.doNotTrack === '0') {
                dnt.innerHTML = form.dataset.cookiemanDntDisabled
            }
        }
    }

    function injectTrackingObjects() {
        var consented = consentedSelections()
        for (var _i = 0; _i < consented.length; _i++) {

        }
    }

    function init() {
        // load form state
        loadCheckboxStates()
        setDnt()
        // register handlers
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

        // inject tracking objects when consented
        injectTrackingObjects()
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
        hasConsented: function (selection) {
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
