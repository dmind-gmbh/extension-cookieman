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

   .. code-block:: js

      <a href="" onclick="cookieman.show(); return false">
        Cookie settings
      </a>


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


.. _development:

Development
===========

Choose your branch:

* 8lts (TYPO3 8.7)
* 9lts (TYPO3 9.5)
* master (TYPO3 10.x).

To try it: just run `ddev start` which will install a TYPO3 with example content and `cookieman`.
This installs helper extensions that automatically enable a certain theme and some TypoScript setup to facilitate development.
The admin user is "admin", password "adminadmin".

After switching branches, you might need a `git clean -fdX -e '!.idea'`.

To throw away the database and restart cleanly, run `ddev rm -ORU && git clean -fdX -e '!.idea' && ddev start`

`ddev install-git-hooks` will install the CGL tools as a pre-commit hook.
