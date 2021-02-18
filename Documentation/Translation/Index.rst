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

You can override translations by the usual means (.xlf-files or TypoScript :typoscript:`_LOCAL_LANG`).
If you use the TypoScript approach please keep in mind that the default language is english and additional languages can be added via the language ISO-639-1 code (de, fr, ...).

Example:
--------

.. code-block:: typoscript

   plugin.tx_cookieman._LOCAL_LANG {
     default {
       group.mandatory = Technically necessary
     }
     de {
       group.marketing = Technisch notwendig
     }
   }


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


Example:
--------

.. code-block:: typoscript

   plugin.tx_cookieman._LOCAL_LANG {
     default {
       trackingobject.pixelphp = You can translate the name, but you do not have to.
       trackingobject.pixelphp.desc = My own tracking pixel does not really track you. It's just here to cheer you up.
       group.mygroup = My group is my castle.
     }
     de {
       trackingobject.pixelphp = Du kannst den Namen übersetzen, musst es aber nicht machen.
       trackingobject.pixelphp.desc = Mein eigener Tracking Pixel trackt dich nicht wirklich. Er ist nur hier, um dich aufzumuntern.
       group.mygroup = In meiner Gruppe bin ich König.
     }
   }
