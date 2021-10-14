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
