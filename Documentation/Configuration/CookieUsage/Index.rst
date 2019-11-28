.. include:: ../../Includes.txt


.. _configuration:

================
Usage of cookies
================

Target group: **Developers, Integrators**


Find out which tracking objects are used
========================================

You can check your page with an empty cookie storage with your browser and see which cookies gets inserted in your browser.
Or you can use a service like `Cookieservice <https://www.cookieserve.com/>`__ to fetch a page or sign up for services that
crawl your whole site regularly for cookies.

There might be connections made to external servers to access tracking pixels or other content that warrant a user consent, too.
This applies to YouTube (use youtube-nocookie.com) and :abbr:`CDNs (Content Delivery Networks)` (Google Fonts, Bootstrap and
other frontend libraries - recommendation: do not use external connections at all if not necessary).

Also other means for tracking might be used, like HTML5 Web Storage (localStorage).
It is a task for the official Data Security Officer of the site to decide what needs to be consented.
If done correctly, you should be able to find a note about used tracking services in the Data Privacy Statement of the website.

If you have control over how the tracking object is inserted you can have *Cookieman* handle that for you.
Otherwise you can make the actual inclusion of the tracking object dependent on a *Cookieman*-API-call or a presence of a
certain string in *Cookieman*'s cookie "CookieConsent" - this is recommended if you are managing several tags with
Google Tag Manager (set its trigger to "cookie ‹CookieConsent› contains ‹group name, e.g. "marketing"›).
