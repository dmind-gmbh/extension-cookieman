// requires: js.cookie
var cookieman = (function () {
    "use strict";
    // remember: write IE11-compatible JavaScript
    var cookieName = 'CookieConsent',
        cookieLifetimeDays = 365,
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
            consented.join('|'),
            {expires: cookieLifetimeDays}
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

    function consentedSelectionsAll() {
        var cookie = Cookies.get(cookieName)
        return cookie ? cookie.split('|') : []
    }

    function consentedSelectionsRespectDnt() {
        return consentedSelectionsAll().filter(
            function (consented) {
                var aGroup = settings.groups[consented]
                if (typeof aGroup === 'undefined') {
                    return false
                }
                return !aGroup.respectDnt || (navigator.doNotTrack !== '1')
            }
        )
    }

    function loadCheckboxStates() {
        var consented = consentedSelectionsAll()
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
        injectNewTrackingObjects()
    }

    function onAcceptAllClick(e) {
        e.preventDefault()
        selectAll()
    }

    function setDntTextIfEnabled() {
        if (navigator.doNotTrack === '1') {
            var dnts = document.querySelectorAll('[data-cookieman-dnt]')
            for (var _i = 0; _i < dnts.length; _i++) {
                dnts[_i].innerHTML = form.dataset.cookiemanDntEnabled
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
            var pseudo = document.createElement('div'),
                _script
            pseudo.innerHTML = trackingObjectSettings.inject

            // ... insert each node ...
            for (var _i = 0; _i < pseudo.children.length; _i++) {
                var node = pseudo.children[_i]
                // ... and give special treatment to <script>s
                if (node.tagName === 'SCRIPT') {
                    _script = document.createElement('script')
                    _script.textContent = node.textContent
                    for (var _iAttr = 0; _iAttr < node.attributes.length; _iAttr++) {
                        var _attr = node.attributes[_iAttr];
                        _script.setAttribute(_attr.name, _attr.value);
                    }
                    node = _script
                }
                document.body.appendChild(node)
            }

            // keep track what we injected
            injectedTrackingObjects.push(trackingObjectId)
        }
    }

    /**
     * inject not-yet-injected tracking objects if consented and matching DNT constraints
     */
    function injectNewTrackingObjects() {
        var consenteds = consentedSelectionsRespectDnt()
        for (var _i = 0; _i < consenteds.length; _i++) {
            var aGroup = settings.groups[consenteds[_i]]
            for (var _j = 0; _j < aGroup.trackingObjects.length; _j++) {
                var trackingObjectId = aGroup.trackingObjects[_j]
                if (injectedTrackingObjects.indexOf(trackingObjectId) === -1) {
                    injectTrackingObject(trackingObjectId, settings.trackingObjects[trackingObjectId])
                }
            }
        }
    }

    function init() {
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

        // load form state
        loadCheckboxStates()
        setDntTextIfEnabled()

        // inject tracking objects if consented
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
            var consented = consentedSelectionsRespectDnt()
            for (var i = 0; i < consented.length; i++) {
                if (consented[i] === selection) {
                    return true
                }
            }
            return false
        },
        consenteds: consentedSelectionsRespectDnt
    }
}())
