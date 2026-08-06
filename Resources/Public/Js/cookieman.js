// requires: js.cookie
/** global: Cookies */
var cookieman = (function () {
    "use strict";
    var cookieName = 'CookieConsent',
        cookieLifetimeDays = 365,
        // divides the consented groups from the consentConfigurationVersion in the cookie
        versionSeparator = '#',
        defaultConfigurationVersion = '1',
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

    /**
     * Writes the consent cookie with the current consentConfigurationVersion.
     *
     * @param {string[]} consented group keys
     */
    function writeCookie(consented) {
        var expires = settings.cookie?.cookieLifetimeDays || cookieLifetimeDays,
            params = {
                expires: parseInt(expires, 10) ,
                domain: settings.cookie?.domain || undefined,
                sameSite: settings.cookie?.sameSite || 'Strict',
                // browsers discard a `secure` cookie that comes from an http page
                secure: settings.cookie?.secure !== '0' && window.location.protocol === 'https:'
            }

        Cookies.set(
            cookieName,
            consented.join('|') + versionSeparator + configurationVersion(),
			params
        )
    }

    function saveSelections() {
        var consented = []

        for (var _i = 0; _i < checkboxes.length; _i++) {
            if (checkboxes[_i].checked) {
                consented.push(checkboxes[_i].name)
            }
        }

        writeCookie(consented)

        emit(
            'consentChanged',
            {detail: {consenteds: consentedSelectionsRespectDnt()}}
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
     * Checks if consent was given for all groups in which a trackingObject
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

    /**
     * The version of the configuration that the integrator set.
     *
     * @return {string}
     */
    function configurationVersion() {
        return String(settings.consentConfigurationVersion || defaultConfigurationVersion)
    }

    /**
     * Splits the cookie into the consented group keys and the
     * consentConfigurationVersion that was current when the user saved.
     *
     * Format: 'group1|group2#version'. Without a version: 'group1|group2'.
     * A group key cannot contain the separator, so the first one divides the two parts.
     *
     * @return {{consented: string[], version: string}}
     */
    function parseCookie() {
        var cookie = Cookies.get(cookieName)
        if (typeof cookie === 'undefined') {
            return {consented: [], version: ''}
        }
        var separatorPos = cookie.indexOf(versionSeparator),
            consentedPart = separatorPos === -1 ? cookie : cookie.slice(0, separatorPos)
        return {
            consented: consentedPart ? consentedPart.split('|') : [],
            version: separatorPos === -1 ? '' : cookie.slice(separatorPos + 1)
        }
    }

    /**
     * @return {boolean}
     */
    function hasCookie() {
        return typeof Cookies.get(cookieName) !== 'undefined'
    }

    /**
     * The configuration changed after the user gave consent.
     *
     * A cookie without a version comes from cookieman < 5.0.0. It stays valid,
     * @see upgradeCookieVersion().
     *
     * @return {boolean}
     */
    function isConsentOutdated() {
        var cookieVersion = parseCookie().version
        return cookieVersion !== '' && cookieVersion !== configurationVersion()
    }

    /**
     * Writes the current version into a cookie that has none.
     *
     * Cookieman < 5.0.0 saved that consent. We keep it, but from now on the user gets the
     * popup again on the next change of the version.
     */
    function upgradeCookieVersion() {
        if (!hasCookie()) {
            return
        }
        var cookie = parseCookie()
        if (cookie.version !== '') {
            return
        }
        writeCookie(cookie.consented)
    }

    function consentedSelectionsAll() {
        // an outdated consent does not cover the current configuration
        if (isConsentOutdated()) {
            return []
        }
        return parseCookie().consented
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
        if (!hasCookie()) {
            return
        }
        // keep the selections of the user, also if the configuration changed
        var consented = parseCookie().consented
        selectNone()
        for (var _i = 0; _i < consented.length; _i++) {
            var _checkbox = form.querySelector('[name=' + consented[_i] + ']')
            if (_checkbox) {
                setChecked(_checkbox, true)
            }
        }
    }

    /**
     * Intercepts clicks on elements with `data-cookieman-show` attribute
     * even when they are not yet in the DOM.
     */
    function onBodyClick(e) {
        const target = e.target
        if (!target) {
            return
        }

        if (Object.prototype.hasOwnProperty.call(target.dataset, 'cookiemanShow')) {
            cookieman.show()
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
                    currentCookies = Cookies.get()

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

    function emit(typeArg, customEventInit) {
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

        // Intercepts clicks on elements with `data-cookieman-show` attribute
        // even when they are not yet in the DOM.
        document.body.addEventListener(
            'click',
            onBodyClick
        )

        upgradeCookieVersion()
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
            if (!hasCookie() || isConsentOutdated()) {
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
         * Calls `callback` once consent for `groupKey` is given: immediately if it
         * already is, or the next time it newly becomes so (e.g. accept-all, save,
         * or `cookieman.consent()`). Revoking and re-granting consent later fires it
         * again, since that's a new consent event.
         *
         * @api
         * @param {string} groupKey
         * @param {function} callback
         */
        onConsented: function (groupKey, callback) {
            if (hasConsented(groupKey)) {
                callback(groupKey)
                return
            }
            var onConsentChangedOnce = function () {
                if (hasConsented(groupKey)) {
                    eventsEl.removeEventListener('consentChanged', onConsentChangedOnce)
                    callback(groupKey)
                }
            }
            eventsEl.addEventListener('consentChanged', onConsentChangedOnce)
        },
        /**
         * Calls `callback` every time consent selections are saved (accept-all,
         * accept-none, save, or `cookieman.consent()`), with the list of currently
         * consented group keys (respecting Do Not Track).
         *
         * @api
         * @param {function} callback
         */
        onConsentChanged: function (callback) {
            eventsEl.addEventListener(
                'consentChanged',
                function (ev) {
                    callback(ev.detail.consenteds)
                }
            )
        },
        /**
         * not part of the API
         */
        eventsEl: eventsEl
    }
}());
