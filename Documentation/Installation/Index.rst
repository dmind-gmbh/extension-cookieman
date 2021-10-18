.. include:: ../Includes.txt



.. _installation:

============
Installation
============

Target group: **Administrators**


Requirements
============

*  If you reimplement your own theme, it has no requirements at all
*  for the example themes:

   *  Bootstrap 3/4/5 CSS
   *  Bootstrap 3/4/5 JavaScript for *collapse* and *modal*
   *  jQuery

* we also apreciate new and creative custom themes

.. _installation-steps:

Installation
============

.. important::

   **Pay attention to the extension's version number!**

   Each version of Cookieman **only supports a single LTS version of TYPO3** (TYPO3 `v8-*`).
   This might be a bit confusing but makes development and testing easier.

#. **Get the extension:**

   #. **From the Extension Manager:**
      Open the Extension Manager module in the TYPO3 backend and choose 'Get extensions'.
      Search for the extension key *cookieman*. Click on the extension title to get a list
      of all available versions. Import and install the version which is compatible to your TYPO3 version.

   #. **From the TYPO3 Extension Repository (TER):**
      You can download ZIP archives of different versions from
      `https://extensions.typo3.org/extension/cookieman
      <https://extensions.typo3.org/extension/cookieman>`_.
      Upload the file afterwards in the Extension Manager.

   #. **With composer**: Use `composer req dmind/cookieman`.
      This will load a compatible version available from `Packagist <https://packagist.org/packages/dmind/cookieman>`__.

#. **Integration:** Include the static TypoScript "Cookieman" in your root template
   or reference the necessary files in your site package.
   This will get you a group `mandatory` with the tracking object `CookieConsent`.

   **For evaluation purposes:** Include the static TypoScript "Cookieman (Example configuration of groups and tracking objects)"
   to see a full example with multiple groups and tracking objects.

#. **Configure the extension** with TypoScript constants and setup (see :ref:`configuration`).
