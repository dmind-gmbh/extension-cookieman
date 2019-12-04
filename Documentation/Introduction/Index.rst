.. include:: ../Includes.txt


.. _introduction:

============
Introduction
============


What does it do?
================

A GDPR tracking consent popup. It asks for approval to include tracking objects (cookies, images or any HTML) and includes the objects when consented.
It enables tracking from the very first page (including referrer). Consents are shown in groups and saved to a cookie.
It provides a stable API to read out consents with JavaScript.


.. _when-is-it-shown:

When is the popup shown to users?
---------------------------------

By default, the popup is shown once on every page load until the user saves the consent status.
The user can close the popup by clicking the area outside in order to read the current page.

When the user saves the consent status, a new cookie `CookieConsent` will be set with the approved cookie groups.

Exceptions are imprint and data privacy statement pages - this is to follow the GDPR's expectation that
those pages shall be easily and directly accessible and should not interfere with a cookie consent banner.
The page UIDs can be set in TypoScript. This also allows to link to these pages directly in the popup.


.. _features:

Features
--------

* Cookies: **Render detailed information** about your cookies: Name, Purpose, Lifetime, Type, Provider
* Cookies: Commonly used cookies are **already supported** with configuration and information text
* Cookies: **Add, sort or remove cookies** as needed
* Groups: **Sort your cookies into groups** (e.g. "Mandatory", "Marketing", "Analytics")
* Groups: **Add or remove groups** as needed
* Groups: **Preselect and/or disable groups**, e.g. the group for mandatory technical cookies
* A note about the **"Do-not-track"** setting can be shown inside the popup

* The extension includes **3 ready-made themes** based on Bootstrap
* **Customization:** Fluid templates and all texts can be adjusted to your needs


.. _compatibility:

Compatibility
-------------

* Supports all modern browsers and Internet Explorer 11
* Can be configured to work with a strict `Content Security Policy <https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP>`__
  (which means: all inline scripts are blocked)


.. _demo:

Demo
====

You can click around the three included demo themes `here <http://cookieman.d-mind.de/>`__.
Have a look at the JavaScript console to see when tracking gets enabled.

You can also try out the `"Do-not-track" setting of your browser <https://en.wikipedia.org/wiki/Do_Not_Track>`__
which triggers a message inside the popup (in the "marketing" group) when enabled.


.. _screenshots:

Screenshots
===========

You can find some notes about the differences among the example themes here: :ref:`theme`.

(Click on the screenshots to open the full resolution.)

.. figure:: ../Images/bs4-modal-initial.png
   :class: with-shadow
   :alt: Bootstrap 4 Modal
   :width: 400px

   Bootstrap 4 Modal, status on page load. Groups can be opened for details.


.. figure:: ../Images/bs3-modal.png
   :class: with-shadow
   :alt: Bootstrap 3 Modal
   :width: 400px

   Bootstrap 4 Modal, opened. Shows details about the used cookies.


.. figure:: ../Images/bs4-modal-colors.png
   :class: with-shadow
   :alt: Bootstrap 4 Modal
   :width: 400px

   Bootstrap 4 Modal with customized colors.


.. figure:: ../Images/bs3-modal-initial.png
   :class: with-shadow
   :alt: Bootstrap 3 Modal
   :width: 400px

   Bootstrap 3 Modal, status on page load. Groups can be opened for details.


.. figure:: ../Images/bs3-banner-initial.png
   :class: with-shadow
   :alt: Bootstrap 3 Banner
   :width: 400px

   Bootstrap 3 Banner, status on page load.


.. figure:: ../Images/bs3-banner-opened.png
   :class: with-shadow
   :alt: Bootstrap 3 Banner
   :width: 400px

   Bootstrap 3 Banner, opened. Shows details about the used cookies.
