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

#. **Integration:** Choose one of the two equivalent approaches:

   **Option A – Site set (recommended for TYPO3 ≥ 13)**

   Add the site set ``dmind/cookieman`` to your site configuration
   (``config/sites/<your-site>/config.yaml``):

   .. code-block:: yaml

      sets:
        - dmind/cookieman

   For evaluation purposes, also add the example set:

   .. code-block:: yaml

      sets:
        - dmind/cookieman
        - dmind/cookieman-example

   **Option B – @import in your own TypoScript**

   Import the extension's TypoScript files directly from your site package's
   setup file:

   .. code-block:: typoscript

      @import 'EXT:cookieman/Configuration/TypoScript/constants.typoscript'
      @import 'EXT:cookieman/Configuration/TypoScript/setup.typoscript'

   For evaluation purposes, also import the example configuration:

   .. code-block:: typoscript

      @import 'EXT:cookieman/Configuration/TypoScript/Example/setup.typoscript'

   **Option C – Static TypoScript (classic approach)**

   .. note::

      We do not recommend this approach. TypoScript stored in ``sys_template`` database records
      is not on the file system and therefore not under version control, which makes updates and
      refactoring significantly harder to manage. Prefer Option A or B instead.

   Include the static TypoScript "Cookieman" in your root template
   or reference the necessary files in your site package.

   For evaluation purposes, also include
   "Cookieman (Example configuration of groups and tracking objects)".

   All three options give you a group ``mandatory`` with the tracking object ``CookieConsent``.

#. **Configure the extension** with TypoScript constants and setup (see :ref:`configuration`).
