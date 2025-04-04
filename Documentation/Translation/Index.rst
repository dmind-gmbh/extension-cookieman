.. include:: ../Includes.txt


.. _translation:

===========
Translation
===========

Target group: **Developers, Integrators**

All strings are translatable. Translations are managed on `Crowdin <https://crowdin.com/project/typo3-extension-cookieman>`__. Click the button to help translating!

.. image:: https://badges.crowdin.net/typo3-extension-cookieman/localized.svg
   :alt: Crowdin localization status
   :target: https://crowdin.com/project/typo3-extension-cookieman
   :class: with-shadow

Override translations
=====================

You can override translations by registering your .xlf-file as override in your `ext_localconf.php` (this example uses a configure_cookieman extension that we recommend to hold all your cookieman configuration):

.. code-block:: php

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:cookieman/Resources/Private/Language/locallang.xlf'][]
        = 'EXT:configure_cookieman/Resources/Private/Language/locallang_cookieman.xlf';


Add translations for new groups and tracking objects
====================================================

If you have added groups or tracking objects, you will have to add these translation strings:

:aspect:`group.‹group-key›`
   Shown as group title.

:aspect:`group.‹group-key›.desc`
   Shown as introductory text block above the table (optional).

:aspect:`trackingobject.‹tracking-object-key›.desc`
   Shown in the table column "Purpose".

:aspect:`type.‹your-custom-type-key›`
   Shown in the table column "Type".
