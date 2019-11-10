// requires: js.cookie
var cookieman = (function () {
    "use strict";
    // remember: write IE11-compatible JavaScript
    var cookieName = 'CookieConsent',
        cookieDurationDays = 365,
        form = document.querySelector('[data-cookieman-form]'),
        settingsEl = document.querySelector('[data-cookieman-settings]'),
        settings = JSON.parse(settingsEl.dataset.cookiemanSettings),
        checkboxes = form.querySelectorAll('[type=checkbox][name]'),
        saveButtons = document.querySelectorAll('[data-cookieman-save]'),
        acceptAllButtons = document.querySelectorAll('[data-cookieman-accept-all]'),
        injectedTrackingObjects = []

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
        injectNewTrackingObjects()
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

    /**
     * inject the HTML for a given tracking object
     * @param trackingObjectId string e.g. 'Matomo'
     * @param trackingObjectSettings array (e.g. the array plugin.tx_cookieman.settings.trackingObjects.Matomo
     * from TypoScript)
     */
    function injectTrackingObject(trackingObjectId, trackingObjectSettings) {
        if (typeof trackingObjectSettings.inject !== "undefined") {
            // <script>s inserted via innerHTML won't be executed
            // https://developer.mozilla.org/en-US/docs/Web/API/Element/innerHTML

            // Let the DOM parse our inject-HTML...
            var pseudo = document.createElement('div')
            pseudo.innerHTML = trackingObjectSettings.inject

            // ...and insert <script>s manually
            var pseudoScripts = pseudo.querySelectorAll('script'),
                _script
            for (var _i = 0; _i < pseudoScripts.length; _i++) {
                _script = document.createElement('script')
                _script.textContent = pseudoScripts[_i].textContent
                document.body.appendChild(_script)
                pseudo.removeChild(pseudoScripts[_i]) // remove from pseudo
            }

            // append the rest of pseudo
            document.body.innerHTML += pseudo.innerHTML // only the content of our pseudo-div

            // keep track what we injected
            injectedTrackingObjects.push(trackingObjectId)
            console.log('injected ' + trackingObjectId, trackingObjectSettings.inject)
        }
    }

    /**
     * inject not-yet-injected tracking objects if consented
     */
    function injectNewTrackingObjects() {
        var consenteds = consentedSelections()
        for (var _i = 0; _i < consenteds.length; _i++) {
            var consented = consenteds[_i]
            for (var _j = 0; _j < settings.groups[consented].trackingObjects.length; _j++) {
                var trackingObjectId = settings.groups[consented].trackingObjects[_j]
                if (injectedTrackingObjects.indexOf(trackingObjectId) === -1) {
                    injectTrackingObject(trackingObjectId, settings.trackingObjects[trackingObjectId])
                }
            }
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
        injectNewTrackingObjects()
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
