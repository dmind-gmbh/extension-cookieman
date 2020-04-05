.. include:: ../Includes.txt


.. _developer:

================
Developer Corner
================

Target group: **Developers**

.. _javascript-api:

JavaScript API
==============

cookieman.js exposes these methods:


cookieman.showOnce()
^^^^^^^^^^^^^^^^^^^^

:aspect:`Data type`
   void

:aspect:`Description`
   Shows the confirmation modal when consent has not been saved yet.

   It is automatically called on each page from `cookieman-init.js` (with an aditional condition, see :ref:`when-is-it-shown`


cookieman.show()
^^^^^^^^^^^^^^^^

:aspect:`Data type`
   void

:aspect:`Description`
   Shows the confirmation modal. You can call that from anywhere you need it (e.g. with a link from your data protection declaration page).

   .. code-block:: HTML

      <button onclick="cookieman.show()">
        Adjust your cookie preferences
      </button>

   .. attention::

      If your website uses a strict `Content-Security-Policy` (see `Mozilla Developer Network <https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP>`__) the onclick= needs to be replaced with registering a click-handler from an external <script> (also see :ref:`how cookieman supports Content-Security-Policy <content-security-policy>`).


cookieman.hide()
^^^^^^^^^^^^^^^^

:aspect:`Data type`
   void

:aspect:`Description`
   Hides the confirmation modal.


cookieman.consenteds()
^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Data type`
   array

:aspect:`Example`
   ["mandatory", "ads"]

:aspect:`Description`
   Returns all groups keys the user has consented to.


cookieman.hasConsented(selection)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Data type`
   boolean

:aspect:`Description`
   Returns `true` if the user has consented to the given selection, else false.

   A selection is any name of a checkbox in the popup, e.g. 'marketing'.


cookieman.hasConsentedTrackingObject(trackingObjectKey)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Data type`
   boolean

:aspect:`Description`
   Returns `true` if the user has consented to all groups (A group is any name of a checkbox in the popup, e.g.
   'marketing') that contain the given trackingObject, else false.

   `trackingObjectKey` is the trackingObjects.‹tracking object key› from TypoScript, e.g. 'Matomo'.


cookieman.onScriptLoaded(String trackingObjectKey, int scriptId, function callback)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Data type`
   void

:aspect:`Description`
   Do things after an external script has been loaded. This is useful if you are interacting with external scripts
   that are loaded by Cookieman.

   * `trackingObjectKey` is the trackingObjects.‹tracking object key› from TypoScript, e.g. 'Matomo'.

   * `scriptId` is the number of the <script> inside your trackingObjects.‹tracking object key›.inject
     (starting from 0 with the first).

   * `callback` is a function reference. It receives trackingObjectKey and scriptId (see example below).
     callback is called immediately if the referred to <script> has already finished loading.

   Example:

   .. code-block:: js

      cookieman.onScriptLoaded(
          'Matomo',
          0, // first script in 'inject'
          function (trackingObjectKey, scriptId) {
              _paq.push(['trackConversion'])
          }
      )


.. tip::

   Cookieman also includes the (1kB) cookie library `JavaScript Cookie <https://github.com/js-cookie/js-cookie>`__
   that also exposes its API and makes it easier to work with cookies.
