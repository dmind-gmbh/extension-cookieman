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
