.. include:: ../Includes.txt


.. _new-in-version-5:

==================
New in version 5
==================


.. _new-in-version-5-breaking:

Breaking changes
================


The consent cookie defaults to ``sameSite = Strict``
----------------------------------------------------

Before version 5.0.0 the default was ``Lax``. ``Strict`` improves the first-party
signals of the cookie.

To keep the previous behaviour, set :ref:`cookie.sameSite`:

.. code-block:: typoscript

   plugin.tx_cookieman.settings.cookie.sameSite = Lax


The consent cookie is ``secure`` on https
------------------------------------------

Cookieman reads the protocol of the page and sets the ``secure`` attribute on https
pages only. Browsers discard a ``secure`` cookie that an http page sets: the cookie is
then never stored and the popup comes back on every page.

Set :ref:`cookie.secure` to ``0`` if you share the cookie between subdomains and one
of them is still http:

.. code-block:: typoscript

   plugin.tx_cookieman.settings.cookie.secure = 0

See :ref:`extension-cookie-settings`.


.. _new-in-version-5-features:

Features
========


TypoScript constants for the cookie settings
---------------------------------------------

The ``cookie{}`` block in the setup now reads TypoScript constants, as the ``links{}``
block does. You can set the lifetime, the domain, ``sameSite`` and ``secure`` in the
constants editor: :ref:`cookie.cookieLifetimeDays`, :ref:`cookie.domain`,
:ref:`cookie.sameSite` and :ref:`cookie.secure`.

See :ref:`typoscript-constants`.


Show the popup again after a configuration change
--------------------------------------------------

Change :ref:`consentConfigurationVersion` every time you change your cookie
configuration:

.. code-block:: typoscript

   plugin.tx_cookieman.settings.consentConfigurationVersion = 2

Cookieman writes the version into the consent cookie and shows the popup again to all
users whose cookie holds a different version. Until such a user saves again, the old
consent does not count and cookieman injects no tracking objects. The selections of
the user stay in the checkboxes.

See :ref:`show-the-popup-again`.

.. note::

   Consent that cookieman before 5.0.0 saved holds no version. Cookieman adds the
   current version to such a cookie without a change for the user ("silent upgrade").
   Thus the upgrade to 5.0.0 asks nobody again.
