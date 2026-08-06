.. include:: ../../../Includes.txt

.. toctree::

.. _typoscript-constants:

====================
TypoScript constants
====================

Adjust the TypoScript constants (again, either in a sys_template record or in a file in your site package).

All constants are prepended with `plugin.tx_cookieman.settings`.


.. _resourcesBasePath:

resourcesBasePath
^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

resourcesBasePath
   :sep:`|` :aspect:`Data type:` :ref:`data-type-path`
   :sep:`|` :aspect:`Default:` EXT:cookieman/Resources
   :sep:`|` :aspect:`Example:` EXT:mysitepackage/Resources
   :sep:`|`

   Path to directory that holds the themes. Default enables the shipped demo themes. See :ref:`customization` how to create a new theme.

.. _theme:

theme
^^^^^
.. rst-class:: dl-parameters

theme
   :sep:`|` :aspect:`Data type:` :ref:`data-type-string`
   :sep:`|` :aspect:`Default:` bootstrap4-modal
   :sep:`|` :aspect:`Example:` my-theme
   :sep:`|`

   Name of the theme. It is used to extend the :ref:`resourcesBasePath` to create the full path to templates and assets.

   The shipped default themes are these: `Themes directory on Github <https://github.com/dmind-gmbh/extension-cookieman/tree/master/Resources/Private/Themes>`__

   You can check them out on our :ref:`demo` page.

   Of course you can use your own custom theme (see :ref:`customization`).

.. _links.dataProtectionDeclarationPid:

links.dataProtectionDeclarationPid
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

links.dataProtectionDeclarationPid
   :sep:`|` :aspect:`Data type:` :ref:`data-type-page-id`
   :sep:`|` :aspect:`Example:` 123
   :sep:`|`

   page UID of data privacy statement page - the *Cookieman* modal will not be automatically opened on this page
   (see :ref:`when-is-it-shown`).

.. _links.dataProtectionDeclarationAnchor:

links.dataProtectionDeclarationAnchor
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

links.dataProtectionDeclarationAnchor
   :sep:`|` :aspect:`Data type:` :ref:`data-type-string`
   :sep:`|` :aspect:`Example:` c456
   :sep:`|`

   You can set an (optional) anchor (TYPO3-lingua "section") on the data privacy statement page.

.. _links.imprintPid:

links.imprintPid
^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

links.imprintPid
   :sep:`|` :aspect:`Data type:` :ref:`data-type-page-id`
   :sep:`|` :aspect:`Example:` 123
   :sep:`|`

   page UID of imprint page - the *cookieman* modal will not be automatically opened on this page
   (see :ref:`when-is-it-shown`).

.. _links.imprintAnchor:

links.imprintAnchor
^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

links.imprintAnchor
   :sep:`|` :aspect:`Data type:` :ref:`data-type-string`
   :sep:`|` :aspect:`Example:` c456
   :sep:`|`

   You can set an (optional) anchor (TYPO3-lingua "section") on the imprint page.

.. _cookie.cookieLifetimeDays:

cookie.cookieLifetimeDays
^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

cookie.cookieLifetimeDays
   :sep:`|` :aspect:`Data type:` :ref:`data-type-string`
   :sep:`|` :aspect:`Default:` 365
   :sep:`|` :aspect:`Example:` 90
   :sep:`|`

   Number of days after which the consent cookie expires.

.. _cookie.domain:

cookie.domain
^^^^^^^^^^^^^
.. rst-class:: dl-parameters

cookie.domain
   :sep:`|` :aspect:`Data type:` :ref:`data-type-string`
   :sep:`|` :aspect:`Default:` the domain of the TYPO3 site
   :sep:`|` :aspect:`Example:` .example.com
   :sep:`|`

   Domain of the consent cookie, without the protocol. Start it with a dot to share the
   cookie between subdomains (see :ref:`extension-cookie-settings`).

.. _cookie.sameSite:

cookie.sameSite
^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

cookie.sameSite
   :sep:`|` :aspect:`Data type:` :ref:`data-type-string`
   :sep:`|` :aspect:`Default:` Strict
   :sep:`|` :aspect:`Example:` Lax
   :sep:`|`

   `SameSite attribute <https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers/Set-Cookie#samesitesamesite-value>`__
   of the consent cookie. Use `Strict`, `Lax` or `None`.

   Before cookieman 5.0.0 the default was `Lax`.

.. _cookie.secure:

cookie.secure
^^^^^^^^^^^^^
.. rst-class:: dl-parameters

cookie.secure
   :sep:`|` :aspect:`Data type:` :ref:`data-type-string`
   :sep:`|` :aspect:`Default:` empty (= on)
   :sep:`|` :aspect:`Example:` 0
   :sep:`|`

   Makes the consent cookie
   `secure <https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers/Set-Cookie#secure>`__.
   Cookieman sets the attribute only when the page is served via https, so it is safe
   to leave this on.

   Set it to `0` only if you have http/https subdomains that must be covered by the cookie
   (see :ref:`extension-cookie-settings`).

.. _consentConfigurationVersion:

consentConfigurationVersion
^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

consentConfigurationVersion
   :sep:`|` :aspect:`Data type:` :ref:`data-type-string`
   :sep:`|` :aspect:`Default:` 1
   :sep:`|` :aspect:`Example:` 2
   :sep:`|`

   Version of your cookie configuration. Cookieman writes it into the consent cookie.
   You can use any value, for example a date or the number of your release.

   Change it every time you change your cookie configuration. Cookieman then shows the
   consent popup again to all users whose cookie holds a different version. Until such a
   user saves again, the old consent does not count and cookieman injects no tracking
   objects (see :ref:`show-the-popup-again`).

   Consent that cookieman before 5.0.0 saved holds no version. Such a cookie gets the
   current version without a change for the user ("silent upgrade"). Thus the upgrade to
   5.0.0 does not ask anybody again.

.. _minify:

minify
^^^^^^
.. rst-class:: dl-parameters

minify
   :sep:`|` :aspect:`Data type:` :ref:`t3tsref:data-type-boolean`
   :sep:`|` :aspect:`Default:` 1
   :sep:`|`

   Cookieman comes with both minified and regular stylesheets and JavaScripts for the demo themes.

   It set to `1`, the minified versions of the .css and .js files are used.
   You can set it to `0` for debugging purposes.
