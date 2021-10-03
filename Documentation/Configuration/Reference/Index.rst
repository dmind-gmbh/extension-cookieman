.. include:: ../../Includes.txt


.. _typoscript-reference:

====================
TypoScript Reference
====================


.. _typoscript-constants:

TypoScript constants
====================

Adjust the TypoScript constants (again, either in a sys_template record or in a file in your site package).

All constants are prepended with `plugin.tx_cookieman.settings`.


.. _resourcesBasePath:

resourcesBasePath
^^^^^^^^^^^^^^^^^

:aspect:`Property`
   resourcesBasePath

:aspect:`Data type`
   :ref:`data-type-path`

:aspect:`Default`
   EXT:cookieman/Resources

:aspect:`Example`
   EXT:mysitepackage/Resources

:aspect:`Description`
   Path to directory that holds the themes. Default enables the shipped demo themes. See :ref:`customization` how to create a new theme.


.. _theme:

theme
^^^^^

:aspect:`Property`
   theme

:aspect:`Data type`
   :ref:`data-type-string`

:aspect:`Default`
   bootstrap4-modal

:aspect:`Example`
   my-theme

:aspect:`Description`
   Name of the theme. It is used to extend the :ref:`resourcesBasePath` to create the full path to templates and assets.

   The shipped default themes are (each showcase the functionality a bit differently):

   * `bootstrap3-banner`: needs Bootstrap 3; uses a text link "settings" instead of a button; shows "Accept all cookies" only after opening the settings; uses custom accordion CSS to show opened/closed state (+/x) and enhanced checkboxes
   * `bootstrap3-modal`: needs Bootstrap 3, uses custom CSS on the "settings" button and the accordion to show opened/closed state (⯈/⯆), shows the checkboxes inside left of the accordion header
   * `bootstrap4-modal`: needs Bootstrap 4, uses custom CSS on the "settings" button and the accordion to show opened/closed state (+/x), shows the checkboxes inside right of the accordion header

   You can check out the :ref:`demo` or see the :ref:`screenshots` to get an idea.

   Of course you can use your own custom theme (see :ref:`customization`).


.. _links.dataProtectionDeclarationPid:

links.dataProtectionDeclarationPid
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   links.dataProtectionDeclarationPid

:aspect:`Data type`
   :ref:`data-type-page-id`

:aspect:`Example`
   123

:aspect:`Description`
   page UID of data privacy statement page - the *Cookieman* modal will not be automatically opened on this page
   (see :ref:`when-is-it-shown`).


.. _links.dataProtectionDeclarationAnchor:

links.dataProtectionDeclarationAnchor
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   links.dataProtectionDeclarationAnchor

:aspect:`Data type`
   :ref:`data-type-string`

:aspect:`Example`
   c456

:aspect:`Description`
   You can set an (optional) anchor (TYPO3-lingua "section") on the data privacy statement page.


.. _links.imprintPid:

links.imprintPid
^^^^^^^^^^^^^^^^

:aspect:`Property`
   links.imprintPid

:aspect:`Data type`
   :ref:`data-type-page-id`

:aspect:`Example`
   123

:aspect:`Description`
   page UID of imprint page - the *cookieman* modal will not be automatically opened on this page
   (see :ref:`when-is-it-shown`).


.. _links.imprintAnchor:

links.imprintAnchor
^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   links.imprintAnchor

:aspect:`Data type`
   :ref:`data-type-string`

:aspect:`Example`
   c456

:aspect:`Description`
   You can set an (optional) anchor (TYPO3-lingua "section") on the imprint page.


.. _minify:

minify
^^^^^^
:aspect:`Property`
   minify

:aspect:`Data type`
   :ref:`t3tsref:data-type-boolean`

:aspect:`Default`
   1

:aspect:`Description`
   Cookieman comes with both minified and regular stylesheets and JavaScripts for the demo themes.

   It set to `1`, the minified versions of the .css and .js files are used.
   You can set it to `0` for debugging purposes.


.. _typoscript-setup:

TypoScript setup
================

See a full TypoScript :ref:`configuration-example`.

All configuration is prepended with `plugin.tx_cookieman.settings`.


.. _groups:

groups
^^^^^^

:aspect:`Property`
   groups

:aspect:`Data type`
   array

:aspect:`Default`
   mandatory

:aspect:`Description`
   Holds the group configurations. A group contains several tracking objects.

   By default, it only contains the 'mandatory' group, which includes the `CookieConsent` settings cookie.
   See a full TypoScript :ref:`configuration-example`.


.. _groups.<group-key>:

groups.<group-key>
^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   groups.<group-key>

:aspect:`Data type`
   array

:aspect:`Example`
   mandatory

:aspect:`Description`
   A single group. The group's key (name) should not contain spaces and non-ASCII characters.

   It will be saved in the settings cookie and can be checked with JavaScript: :js:`hasConsented('‹group-key›')`


.. _groups.‹group-key›.preselected:

groups.‹group-key›.preselected
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   groups.‹group-key›.preselected

:aspect:`Data type`
   :ref:`t3tsref:data-type-boolean`

:aspect:`Default`
   0 (not set)

:aspect:`Description`
   If enabled (`1`), the group's consent checkbox will be already checked when the popup opens.

   The default group 'mandatory' has this set to `1`.


.. _groups.‹group-key›.disabled:

groups.‹group-key›.disabled
^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   groups.‹group-key›.disabled

:aspect:`Data type`
   :ref:`t3tsref:data-type-boolean`

:aspect:`Default`
   0 (not set)

:aspect:`Description`
   If enabled (`1`), the group's consent checkbox will be disabled (cannot be changed).

   The default group 'mandatory' has this set to `1`.


.. _groups.‹group-key›.trackingObjects:

groups.‹group-key›.trackingObjects
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   groups.‹group-key›.trackingObjects

:aspect:`Data type`
   array with numeric indices

:aspect:`Description`
   Holds a list of tracking object keys (numbered).

   Example:

   .. code-block:: ts

      trackingObjects {
        0 = CookieConsent
        1 = fe_typo_user
      }


.. _groups.‹group-key›.respectDnt:

groups.‹group-key›.respectDnt
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   groups.‹group-key›.respectDnt

:aspect:`Data type`
   :ref:`t3tsref:data-type-boolean`

:aspect:`Default`
   0 (not set)

:aspect:`Description`
   If set to `1`, this group respects to the `"Do-not-track" setting of your browser <https://en.wikipedia.org/wiki/Do_Not_Track>`__.


.. _groups.‹group-key›.showDntMessage:

groups.‹group-key›.showDntMessage
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   groups.‹group-key›.showDntMessage

:aspect:`Data type`
   :ref:`t3tsref:data-type-boolean`

:aspect:`Default`
   0 (not set)

:aspect:`Description`
   If set to `1` **and** the `"Do-not-track" setting of your browser <https://en.wikipedia.org/wiki/Do_Not_Track>`__ is enabled,
   an additional message about that is shown inside the group.


.. _trackingObjects:

trackingObjects
^^^^^^^^^^^^^^^

:aspect:`Property`
   trackingObjects

:aspect:`Data type`
   array

:aspect:`Description`
   This array holds the tracking object configurations.
   The Cookieman extension already provides several **preconfigured** tracking objects:

   *  Cookie Consent (Cookieman's settings cookie)
   *  fe_typo_user
   *  Google Analytics
   *  Google Tag Manager
   *  Matomo
   *  Bing

   .. important::
      If you add a preconfigured tracking object, you must at least **adapt** the `inject` code to your needs!

   The default group 'mandatory' only contains the tracking object `CookieConsent` settings cookie.


.. _trackingObjects.‹tracking-object-key›:

trackingObjects.‹tracking-object-key›
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   trackingObjects.‹tracking-object-key›

:aspect:`Data type`
   array

:aspect:`Example`
   fe_typo_user

:aspect:`Description`
   A single tracking object configuration.

   Example:

   .. code-block:: ts

      plugin.tx_cookieman.settings.trackingObjects {
          // 'Matomo' is the ‹tracking-object-key›:
          Matomo {
              // injected code, if consent is given:
              inject (
                  <script data-what="Matomo" src="/typo3conf/ext/cookieman/Resources/Public/Js/Injects/example-inject.js"></script>
              )

              show {
                  // set cookies, if consent is given:
                  _pk_id {
                      duration = 13
                      durationUnit = months
                      type = cookie_http+html
                      provider = Matomo
                  }

                  // etc.
              }
          }
      }


.. _trackingObjects.‹tracking-object-key›.inject:

trackingObjects.‹tracking-object-key›.inject
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   trackingObjects.‹tracking-object-key›.inject

:aspect:`Data type`
   :ref:`data-type-html-code`

:aspect:`Example`
   <script src="/path/to/tracking-code.js"></script>

:aspect:`Description`
   Each HTML tag in here will be appended to the page when the respective group is consented.
   This can be `<script>`, `<img>` or anything else.

   You can either use inline script or link to an external file (useful if a HTTP header `Content-Security-Policy` is set).


.. _trackingObjects.‹tracking-object-key›.show:

trackingObjects.‹tracking-object-key›.show
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   trackingObjects.‹tracking-object-key›.show

:aspect:`Data type`
   array

:aspect:`Description`
   The actual rows of the table, each representing one "tracking item" (usually a cookie).


.. _trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›:

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›

:aspect:`Data type`
   array

:aspect:`Example`
   _pk_id

:aspect:`Description`
   A single "tracking item" (e.g. the name of a cookie).
   A cookie that matches this name will be removed when consent for the group in which this tracking object is included
   is revoked. (see also :ref:`trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.htmlCookieRemovalPattern`)


.. _trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.duration:

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.duration
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.duration

:aspect:`Data type`
   :ref:`data-type-positive-integer`

:aspect:`Example`
   12

:aspect:`Description`
   The lifetime of the tracking object (only the "number" part).


.. _trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.durationUnit:

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.durationUnit
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.durationUnit

:aspect:`Data type`
   :ref:`data-type-string`

:aspect:`Example`
   months

:aspect:`Description`
   The lifetime of the tracking object (only the "unit" part).


.. _trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.type:

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.type
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.type

:aspect:`Data type`
   :ref:`data-type-string`

:aspect:`Example`
   cookie_http+html

:aspect:`Description`
   The type of tracking.

   Possible (default) keywords:

   * `cookie_http+html`: an HTML (=HTTP+HTML) cookie, which is also readable from JavaScript.
     This is the only type that can be removed after consent has been revoked.
   * `cookie_http`: an HTTP cookie
   * `pixel`: a tracking pixel

   .. note::
      You can add your own types by adding a localization string `type.‹your-type-key›`.


.. _trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.provider:

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.provider
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.provider

:aspect:`Data type`
   :ref:`data-type-string`

:aspect:`Example`
   Google

:aspect:`Description`
   The provider of the cookie or tracking object.


.. _trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.htmlCookieRemovalPattern:

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.htmlCookieRemovalPattern
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:aspect:`Property`
   trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.htmlCookieRemovalPattern

:aspect:`Data type`
   :ref:`data-type-string`

:aspect:`Example`
   ^_gat(?:_UA\-\d+\-\d+)?$

:aspect:`Description`
   You can (optionally) set a regex pattern for cookie names here. It will be used during cookie removal.
   If would remove all matched cookies when consent for the group in which this tracking object is included is revoked.
   If this is empty, the tracking object key is used for deletion (see :ref:`trackingObjects.‹tracking-object-key›`).

   .. note::
      Cookie removal will only work for tracking object type `cookie_http+html`.
      See :ref:`trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.type`.
