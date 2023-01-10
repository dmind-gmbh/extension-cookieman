// requires: js.cookie
/** global: Cookies */
var cookieman = (function () {
    "use strict";
    // remember: write IE11-compatible JavaScript
    var cookieName = 'CookieConsent',
        cookieLifetimeDays = 365,
        form = document.querySelector('[data-cookieman-form]'),
        settingsEl = document.querySelector('[data-cookieman-settings]'),
        eventsEl = settingsEl,
        settings = JSON.parse(settingsEl.dataset.cookiemanSettings),
        checkboxes = form.querySelectorAll('[type=checkbox][name]'),
        saveButtons = document.querySelectorAll('[data-cookieman-save]'),
        acceptAllButtons = document.querySelectorAll('[data-cookieman-accept-all]'),
        acceptNoneButtons = document.querySelectorAll('[data-cookieman-accept-none]'),
        injectedTrackingObjects = [],
        loadedTrackingObjectScripts = {}

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
            {expires: cookieLifetimeDays, sameSite: 'lax'}
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

    function hasConsented(groupKey) {
        var consented = consentedSelectionsRespectDnt()
        for (var i = 0; i < consented.length; i++) {
            if (consented[i] === groupKey) {
                return true
            }
        }
        return false
    }

    /**
     * Checks if consent was given for all groups, in which a trackingObject
     * with the given key is defined. Normally each trackingObject should only
     * be present in one group.
     *
     * @param trackingObjectKey string e.g. 'Matomo'
     * @return boolean consent given for all groups. If the trackingObject is
     * not defined in any group, this function will return false
     */
    function hasConsentedTrackingObject(trackingObjectKey) {
        var groups = findGroupsByTrackingObjectKey(trackingObjectKey)

        return groups.reduce(
            function (consentGiven, groupKey) {
                return consentGiven && hasConsented(groupKey)
            },
            groups.length > 0
        )
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
                return !aGroup.respectDnt || (window.navigator.doNotTrack !== '1')
            }
        )
    }

    function loadCheckboxStates() {
        // do not change checkbox states if there are no saved settings yet
        if (typeof Cookies.get(cookieName) === 'undefined') {
            return
        }
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
        removeDisabledTrackingObjects()
        injectNewTrackingObjects()
    }

    function onAcceptAllClick(e) {
        e.preventDefault()
        selectAll()
    }

    function onAcceptNoneClick(e) {
        e.preventDefault()
        selectNone()
    }

    function setDntTextIfEnabled() {
        if (window.navigator.doNotTrack === '1') {
            var dnts = document.querySelectorAll('[data-cookieman-dnt]')
            for (var _i = 0; _i < dnts.length; _i++) {
                dnts[_i].innerHTML = form.dataset.cookiemanDntEnabled
            }
        }
    }

    /**
     * Returns all groups, in which a trackingObject with the given key is defined.
     *
     * @param trackingObjectKey string e.g. 'Matomo'
     * @return array
     */
    function findGroupsByTrackingObjectKey(trackingObjectKey) {
        return Object.keys(settings.groups).filter(
            function (groupKey) {
                return Object.prototype.hasOwnProperty.call(settings.groups[groupKey], 'trackingObjects')
                    && settings.groups[groupKey].trackingObjects.indexOf(trackingObjectKey) > -1
            }
        )
    }

    /**
     * inject the HTML for a given tracking object
     * @param trackingObjectKey string e.g. 'Matomo'
     * @param trackingObjectSettings object (e.g. the array plugin.tx_cookieman.settings.trackingObjects.Matomo
     * from TypoScript)
     */
    function injectTrackingObject(trackingObjectKey, trackingObjectSettings) {
        if (typeof trackingObjectSettings === 'undefined') {
            console.error('Used trackingObject ‹' + trackingObjectKey + '› is undefined.')
            return
        }
        if (typeof trackingObjectSettings.inject !== "undefined") {
            // <script>s inserted via innerHTML won't be executed
            // https://developer.mozilla.org/en-US/docs/Web/API/Element/innerHTML

            // Let the DOM parse our inject-HTML...
            var pseudo = document.createElement('div'),
                _script
            pseudo.innerHTML = trackingObjectSettings.inject
            // ... insert each node ...
            var iScript = 0
            for (var iChild = 0; iChild < pseudo.children.length; iChild++) {
                var node = pseudo.children[iChild]
                // ... and give special treatment to <script>s
                if (node.tagName === 'SCRIPT') {
                    _script = document.createElement('script')
                    _script.textContent = node.textContent
                    for (var _iAttr = 0; _iAttr < node.attributes.length; _iAttr++) {
                        var _attr = node.attributes[_iAttr]
                        _script.setAttribute(_attr.name, _attr.value)
                    }
                    _script.addEventListener(
                        'load',
                        (
                            function (_script, iScript, trackingObjectKey, trackingObjectSettings) {
                                return function (ev) {
                                    if (typeof loadedTrackingObjectScripts[trackingObjectKey] === 'undefined') {
                                        loadedTrackingObjectScripts[trackingObjectKey] = []
                                    }
                                    loadedTrackingObjectScripts[trackingObjectKey].push(iScript)
                                    emit(
                                        'scriptLoaded',
                                        {
                                            detail: {
                                                trackingObjectKey: trackingObjectKey,
                                                trackingObjectSettings: trackingObjectSettings,
                                                scriptId: iScript,
                                                node: _script
                                            }
                                        }
                                    )
                                }
                            }
                        )(_script, iScript++, trackingObjectKey, trackingObjectSettings)
                    )
                    node = _script
                } else {
                    // we will be removing this child
                    iChild--
                }
                document.body.appendChild(node)
            }

            // keep track what we injected
            injectedTrackingObjects.push(trackingObjectKey)
        }
    }

    /**
     * remove tracking objects that are not consented.
     * See removeTrackingObjectItem() for supported types.
     */
    function removeDisabledTrackingObjects() {
        for (var groupKey in settings.groups) {
            if (!Object.prototype.hasOwnProperty.call(settings.groups, groupKey)) {
                continue
            }

            if (!hasConsented(groupKey)) {
                var oGroup = settings.groups[groupKey]
                for (var _j = 0; _j < oGroup.trackingObjects.length; _j++) {
                    var trackingObjectKey = oGroup.trackingObjects[_j]
                    removeTrackingObject(trackingObjectKey, settings.trackingObjects[trackingObjectKey])
                }
            }
        }
    }

    /**
     * remove a given tracking object
     * See removeTrackingObjectItem() for supported types.
     * @param trackingObjectKey string e.g. 'Matomo'
     * @param trackingObjectSettings object (e.g. the array plugin.tx_cookieman.settings.trackingObjects.Matomo
     * from TypoScript)
     */
    function removeTrackingObject(trackingObjectKey, trackingObjectSettings) {
        if (typeof trackingObjectSettings === 'undefined') {
            console.error('Used trackingObject ‹' + trackingObjectKey + '› is undefined.')
            return
        }
        for (var itemKey in trackingObjectSettings.show) {
            if (!Object.prototype.hasOwnProperty.call(trackingObjectSettings.show, itemKey)) {
                continue
            }
            var oItem = trackingObjectSettings.show[itemKey]

            removeTrackingObjectItem(itemKey, oItem)
        }
    }

    /**
     * remove a given single tracking object item
     * Supported types: cookie_http+html
     * @param itemKey string, e.g. '_ga'
     * @param oItem object the settings for a single item (e.g. the array
     * plugin.tx_cookieman.settings.trackingObjects.GoogleAnalytics.show._ga from TypoScript)
     * @return boolean successful?
     */
    function removeTrackingObjectItem(itemKey, oItem) {
        if (oItem.type === 'cookie_http+html') {
            if (Object.prototype.hasOwnProperty.call(oItem, 'htmlCookieRemovalPattern') && oItem['htmlCookieRemovalPattern'] !== '') {
                var regex,
                    currentCookies = Cookies.get(),
                    matches

                try {
                    //Put in try/catch in case user set malformed regex
                    regex = RegExp(oItem['htmlCookieRemovalPattern'])
                } catch (e) {
                    console.error('Malformed pattern for cookie deletion on trackingObjectItem "' + itemKey + '": ' + e.message)
                    //Do not try the malformed pattern on the other cookie names
                    return false
                }

                for (var cookieName in currentCookies) {
                    if (cookieName.match(regex) !== null) {
                        removeHtmlCookie(cookieName)
                    }
                }
            } else {
                removeHtmlCookie(itemKey)
            }
            return true
        }
        // unsupported type
        return false
    }

    /**
     * inject not-yet-injected tracking objects if consented and matching DNT constraints
     */
    function injectNewTrackingObjects() {
        var consenteds = consentedSelectionsRespectDnt()
        for (var _i = 0; _i < consenteds.length; _i++) {
            var oGroup = settings.groups[consenteds[_i]]
            for (var _j = 0; _j < oGroup.trackingObjects.length; _j++) {
                var trackingObjectKey = oGroup.trackingObjects[_j]
                if (injectedTrackingObjects.indexOf(trackingObjectKey) === -1) {
                    injectTrackingObject(trackingObjectKey, settings.trackingObjects[trackingObjectKey])
                }
            }
        }
    }

    // CustomEvents https://developer.mozilla.org/en-US/docs/Web/API/CustomEvent/CustomEvent
    // polyfill for IE9+
    function polyfillCustomEvent() {
        if (typeof window.CustomEvent !== "function") {
            window.CustomEvent = function (typeArg, customEventInit) {
                customEventInit = customEventInit || {bubbles: false, cancelable: false, detail: undefined}
                var event = document.createEvent('CustomEvent')
                event.initCustomEvent(typeArg, customEventInit.bubbles, customEventInit.cancelable, customEventInit.detail)
                return event
            }
            window.CustomEvent.prototype = window.Event.prototype
        }
    }

    function emit(typeArg, customEventInit) {
        polyfillCustomEvent()

        eventsEl.dispatchEvent(
            new window.CustomEvent(typeArg, customEventInit)
        )
    }

    /**
     * Remove HTML cookie.
     * In order to catch wildcard cookies like domain=.xxx.yy try different path and domains.
     * @link https://github.com/dmind-gmbh/extension-cookieman/issues/137
     * @param name
     */
    function removeHtmlCookie(name) {
        // www.xxx.yy
        var fullDomain = document.location.host
        // xxx.yy
        var secondLevelDomain = fullDomain.split('.').slice(-2).join('.')
        Cookies.remove(name)
        Cookies.remove(name, {path: '/'})
        Cookies.remove(name, {path: '', domain: fullDomain})
        Cookies.remove(name, {path: '/', domain: fullDomain})
        Cookies.remove(name, {path: '', domain: '.' + secondLevelDomain})
        Cookies.remove(name, {path: '/', domain: '.' + secondLevelDomain})
    }

    function init() {
        // register handlers
        for (var i = 0; i < acceptAllButtons.length; i++) {
            acceptAllButtons[i].addEventListener(
                'click',
                onAcceptAllClick
            )
        }
        for (i = 0; i < acceptNoneButtons.length; i++) {
            acceptNoneButtons[i].addEventListener(
                'click',
                onAcceptNoneClick
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
        /**
         * @api
         */
        show: function () {
            console.error('Your theme should implement function cookieman.show()')
        },
        /**
         * @api
         */
        hide: function () {
            console.error('Your theme should implement function cookieman.hide()')
        },
        /**
         * @api
         */
        showOnce: function () {
            if (typeof Cookies.get(cookieName) === 'undefined') {
                cookieman.show()
            }
        },
        /**
         * @api
         * @param {string} groupKey
         * @returns {boolean}
         */
        hasConsented: hasConsented,
        /**
         * @api
         * @param {string} trackingObjectKey
         * @returns {boolean}
         */
        hasConsentedTrackingObject: hasConsentedTrackingObject,
        /**
         * @api
         */
        consenteds: consentedSelectionsRespectDnt,
        /**
         * @api
         * @param {string} groupKey
         */
        consent: function (groupKey) {
            var checkbox = form.querySelector('[type=checkbox][name="' + groupKey + '"]')
            setChecked(checkbox, true)
            saveSelections()
            injectNewTrackingObjects()
        },
        /**
         * @api
         * @param {string} trackingObjectKey
         * @param {number} scriptId
         * @param {function} callback
         */
        onScriptLoaded: function (trackingObjectKey, scriptId, callback) {
            if (typeof loadedTrackingObjectScripts[trackingObjectKey] === 'undefined') {
                loadedTrackingObjectScripts[trackingObjectKey] = []
            }

            // not loaded yet
            if (loadedTrackingObjectScripts[trackingObjectKey].indexOf(scriptId) === -1) {
                // attach ourselves to the "scriptLoaded" event
                eventsEl.addEventListener(
                    'scriptLoaded',
                    function (ev) {
                        if (ev.detail.trackingObjectKey === trackingObjectKey && ev.detail.scriptId === scriptId) {
                            callback(ev.detail.trackingObjectKey, ev.detail.scriptId)
                        }
                    }
                )
            } else { // already loaded
                callback(trackingObjectKey, scriptId)
            }
        },
        /**
         * not part of the API
         */
        eventsEl: eventsEl
    }
}());
