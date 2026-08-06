.. include:: ../Includes.txt

.. _javascript-api:

JavaScript API
==============

:file:`cookieman.js` exposes these methods:


cookieman.showOnce()
^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

cookieman.showOnce()
   :sep:`|` :aspect:`Data type:` void
   :sep:`|`

   Shows the confirmation modal when consent has not been saved yet.

   It is automatically called on each page from :file:`cookieman-init.js` (with an aditional condition, see :ref:`when-is-it-shown`)

cookieman.show()
^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

cookieman.show()
   :sep:`|` :aspect:`Data type:` Promise
   :sep:`|`

   Shows the confirmation modal.

   The page only holds a small stub of cookieman. Thus this function first loads the
   modal, and it gives a Promise that resolves when the modal is there. Since cookieman
   5.0.0 it does not give `void` any more.

   .. code-block:: javascript

      cookieman.show().then(function () {
          // the modal is in the page now
      })

   A theme assigns its own function to `cookieman.show`. Cookieman calls it after it
   loaded the modal, so a theme does not need a change.

   You can also use the attribute `data-cookieman-show` on any element to show the modal when clicked.

   .. code-block:: HTML

      <button data-cookieman-show>
        Adjust your cookie preferences
      </button>

cookieman.hide()
^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

cookieman.hide()
   :sep:`|` :aspect:`Data type:` void
   :sep:`|`

   Hides the confirmation modal.

cookieman.consent(groupKey)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

cookieman.consent(groupKey)
   :sep:`|`
   Adds the given group (e.g. 'marketing') to the consented groups, updates the CookieConsent cookie
   and injects all items given each corresponding trackingObject's `inject` section.

   This is meant as a programmatic way to implement banners before showing content from external sources such as YouTube
   videos, Google Maps, facebook posts, ... – clicking the "yes, show the content"-button would call this function and a
   `<script>` in trackingObject's `inject` section would take care of actually loading the content.

   .. note::

      If the consent of the user is outdated (see :ref:`consentConfigurationVersion`),
      this function also makes the consent current again. It keeps the groups that the user
      selected before and adds the given one, without showing the popup.

cookieman.consenteds()
^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

cookieman.consenteds()
   :sep:`|` :aspect:`Data type:` array
   :sep:`|` :aspect:`Example:` ["mandatory", "ads"]
   :sep:`|`

   Returns all group keys the user has consented to.

cookieman.hasConsented(groupKey)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

cookieman.hasConsented(groupKey)
   :sep:`|` :aspect:`Data type:` boolean
   :sep:`|`

   Returns `true` if the user has consented to the given group (e.g. 'marketing'), else false.

cookieman.hasConsentedTrackingObject(trackingObjectKey)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

cookieman.hasConsentedTrackingObject(trackingObjectKey)
   :sep:`|` :aspect:`Data type:` boolean
   :sep:`|`

   Returns `true` if the user has consented to all groups that contain the given trackingObject, else false.

   `trackingObjectKey` is the trackingObjects.‹tracking object key› from TypoScript, e.g. 'Matomo'.

cookieman.onScriptLoaded(String trackingObjectKey, int scriptId, function callback)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

cookieman.onScriptLoaded(String trackingObjectKey, int scriptId, function callback)
   :sep:`|` :aspect:`Data type:` void
   :sep:`|`

   This is a hook to do things after an external script has been loaded.
   This is useful if you are interacting with external scripts that are loaded by Cookieman.

   * `trackingObjectKey` is the trackingObjects.‹tracking object key› from TypoScript, e.g. 'Matomo'.

   * `scriptId` is the number of the <script> inside your trackingObjects.‹tracking object key›.inject
     (starting from 0 with the first).

   * `callback` is a function reference. It receives trackingObjectKey and scriptId (see example below).
     The callback is called immediately if the referred to <script> has already finished loading.

   Example:

   .. code-block:: js

      cookieman.onScriptLoaded(
          'Matomo',
          0, // first script in 'inject'
          function (trackingObjectKey, scriptId) {
              _paq.push(['trackConversion'])
          }
      )


cookieman.onConsented(String groupKey, function callback)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

cookieman.onConsented(String groupKey, function callback)
   :sep:`|` :aspect:`Data type:` void
   :sep:`|`

   This is a hook to do things once consent for a given group has been given – an alternative to using a
   trackingObject's :ref:`inject <trackingObjects.‹tracking-object-key›.inject>` section.

   * `groupKey` is the settings.groups.‹group key› from TypoScript, e.g. 'marketing'.

   * `callback` is a function reference. It receives `groupKey` (see example below).
     The callback is called immediately if the group is already consented to. Otherwise, it is called the next
     time consent is given (accept-all, save, or :js:`cookieman.consent()`). If consent is later revoked and given
     again, the callback fires again.

   Example:

   .. code-block:: js

      cookieman.onConsented(
          'marketing',
          function (groupKey) {
              loadMyVideoEmbeds()
          }
      )

cookieman.onConsentChanged(function callback)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

cookieman.onConsentChanged(function callback)
   :sep:`|` :aspect:`Data type:` void
   :sep:`|`

   This is a hook to react whenever the user's consent selections are saved (accept-all, accept-none, save, or
   :js:`cookieman.consent()`) – useful if you'd rather listen for changes than poll `cookieman.hasConsented()`.

   * `callback` is a function reference. It receives the array of currently consented group keys (same shape as
     `cookieman.consenteds()`).

   Example:

   .. code-block:: js

      cookieman.onConsentChanged(
          function (consenteds) {
              console.log('consent is now:', consenteds)
          }
      )

.. tip::

   Cookieman also includes the (1kB) cookie library `JavaScript Cookie <https://github.com/js-cookie/js-cookie>`__
   that also exposes its API and makes it easier to work with cookies.
