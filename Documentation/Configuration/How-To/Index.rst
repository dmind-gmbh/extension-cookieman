.. include:: ../../Includes.txt


.. _configuration-howto:

======
How-To
======

Target group: **Developers, Integrators**


.. _howto-trackingobjects:

TrackingObjects
===============


.. _what-are-trackingobjects:

What are TrackingObjects?
-------------------------

A TrackingObject is an array which includes one or more tracking items (usually cookies).
For example, the TrackingObject `GoogleAnalytics` contains five cookies which are used
by this service. They are listed inside the `show` array.

Depending on the purpose a TrackingObject has, you need to inject HTML code after the user
has given his consent (see :ref:`next section <load-tracking-code-after-consent>`).


.. _load-tracking-code-after-consent:

How to load tracking code only after user consent?
--------------------------------------------------

A web analytics service like Matomo or Google Analytics **needs the user's active consent**
before the website starts with tracking. Therefore, you'll need to ensure that the tracking code
is not executed automatically at page load.

You need to remove all existing tracking codes from your website and let Cookieman manage them.
Cookieman will inject the tracking codes after user consent with the
:ref:`inject <trackingObjects.‹tracking-object-key›.inject>` configuration.

**Example:**

.. code-block:: typoscript

   plugin.tx_cookieman.settings.trackingObjects {
       Matomo {
           inject (
               <script type="text/javascript">
                 var _paq = window._paq || [];
                 _paq.push(['trackPageView']);
                 _paq.push(['enableLinkTracking']);
                 (function() {
                   var u="//{$PIWIK_URL}/";
                   _paq.push(['setTrackerUrl', u+'matomo.php']);
                   _paq.push(['setSiteId', {$IDSITE}]);
                   var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                   g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
                 })();
               </script>
           )
       }
   }


.. _add-preconfigured-trackingobject:

Adding a preconfigured TrackingObject
-------------------------------------

Cookieman already provides some preconfigured TrackingObjects.

You can add selected TrackingObjects with two (or three) steps in TypoScript:

1. Import the provided definitions.
2. Add the key (name) of the TrackingObject.

.. code-block:: typoscript

   # 1. Include provided definitions of TrackingObjects:
   @import 'EXT:cookieman/Configuration/TypoScript/TrackingObjects/*.typoscript'

   # 2. Add the TrackingObject key to a group:
   plugin.tx_cookieman.settings.groups {
       mandatory {
           trackingObjects {
               10 = fe_typo_user
           }
       }
   }

3. If a TrackingObject needs to inject HTML code, you'll have to add this in a third step:

.. code-block:: typoscript

   # 1. Include provided definitions of TrackingObjects:
   @import 'EXT:cookieman/Configuration/TypoScript/TrackingObjects/*.typoscript'

   # 2. Add the TrackingObject key to a group (see below how to configure a new group):
   plugin.tx_cookieman.settings.groups {
       analytics {
           trackingObjects {
               10 = GoogleAnalytics
           }
       }
   }

   # 3. Add the tracking code to the TrackingObject:
   plugin.tx_cookieman.settings.trackingObjects {
       GoogleAnalytics {
           inject (
           <script>
               (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
               (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
               m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
               })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

               ga('create', 'UA-XXXXX-Y', 'auto');
               ga('send', 'pageview');
           </script>
           )
       }
   }

.. attention::

   If your website sets the HTTP header `Content-Security-Policy`, you'll need to use <script> with external sources (:ref:`see below <content-security-policy>`).


.. _only-add-used-tracking-items:

Only add the used tracking items (cookies)
------------------------------------------

The provided TrackingObject definitions contain **commonly used** cookies of a service. **You'll need to check it your website really
uses all these cookies!**

For example, Matomo will only use the `_pk_hsr` cookie if the *Heatmap & Session recording* plugin is enabled!

You can remove any default tracking item like this:

.. code-block:: typoscript

   plugin.tx_cookieman.settings.trackingObjects.Matomo.show._pk_hsr >

.. important::

   It's important that you only list cookies in the consent popup which your website really sets.


.. _add-new-trackingobject:

Adding a new custom TrackingObject
----------------------------------

A new TrackingObject of course needs some additional configuration:

#. Configure the new TrackingObject.
#. Add the new TrackingObject to a group.
#. Provide necessary localization labels which are shown in the consent popup.

.. code-block:: typoscript

   plugin.tx_cookieman {
       settings {
           # 1. Configure the new TrackingObject:
           trackingObjects {
               PHPsession {
                   # 1a. Configure the table row information:
                   show {
                       PHPSESSID {
                           duration =
                           durationUnit = session
                           type = cookie_http+html
                           provider = Website
                           # 1b. Set a Regular Expression pattern that matches the name of the cookie,
                           #     if the cookie name or parts of it are dynamic, so the cookie can be automatically
                           #     removed in case the user revokes the consent. (optional)
                           #     Please note that you must not provide regex delimiters and can not set options
                           # htmlCookieRemovalPattern = ^regex\.\d+\.[a-fA-F0-9]+$
                       }
                   }

                   # 1c. Add the tracking code (optional):
                   #inject (
                   #    <!-- optional HTML tracking code -->
                   #)
               }
           }

           # 2. Add the new TrackingObject to a group:
           groups.mandatory.trackingObjects {
               20 = PHPsession
           }
       }

       # 3. Provide necessary localization labels:
       _LOCAL_LANG {
           default {
               trackingobject.PHPSESSID.desc = This temporary cookie is set by PHP to store current session data (e.g. form data).
           }

           de {
               trackingobject.PHPSESSID.desc = Dieser temporäre Cookie wird von PHP gesetzt, um aktuelle Sitzungsdaten zu speichern (z.B. Formulardaten).
           }
       }
   }


.. important::

   If you provide a Regular Expression in the `htmlCookieRemovalPattern` option, please be aware of `Catastrophic Backtracking <https://www.rexegg.com/regex-explosive-quantifiers.html>`__ and make sure that your pattern is safe. Otherwise your page might slow down or even crash the users browser.

.. _howto-groups:

Groups
======


.. _what-are-groups:

What are Groups?
----------------

TrackingObjects can be arranged in groups that fit their purpose (technically necessary, statistics, marketing, …).

You can configure that a group is *mandatory* (and therefore :ref:`preselected <groups.‹group-key›.preselected>`
and :ref:`disabled <groups.‹group-key›.disabled>`) or that the `"Do-not-track" setting of your browser <https://en.wikipedia.org/wiki/Do_Not_Track>`__
is :ref:`respected <groups.‹group-key›.respectDnt>`.


.. _add-new-group:

Adding a new custom group
-------------------------

A new group needs the following configuration:

#. Add the new group.
#. Add the desired TrackingObjects to the group.
#. Add settings to the group (optional).
#. Provide necessary localization labels.

.. code-block:: typoscript

   plugin.tx_cookieman {
       settings {
           groups {
               # 1. Add the new group:
               statistics {
                   # 2. Add TrackingObjects to this group:
                   trackingObjects {
                       10 = Matomo
                       20 = GoogleAnalytics
                   }

                   # 3. Optional settings: respect the 'Do Not Track' browser setting:
                   respectDnt = 1
                   showDntMessage = 1
               }
           }
       }

       # 4. Provide necessary localization labels:
       _LOCAL_LANG {
           default {
               group.statistics = Statistics
               group.statistics.desc = Explain the general purpose of the cookies here.
           }

           de {
               group.statistics = Statistiken
               group.statistics.desc = Beschreibe hier den allgemeinen Einsatzzweck der Cookies.
           }
       }
   }

.. tip::

   Whether Google Analytics can be considered a *statistics* or *marketing* TrackingObject depends on its individual configuration.

   In case of doubt, ask your Data Security Officer.


.. _other-topics:

Other topics
============


.. _content-security-policy:

Content Security Policy
-----------------------

If your website sets the HTTP header **Content-Security-Policy** (without the unrecommended option `'unsafe-inline'`),
it will block all inline code – including your tracking codes.

In order to use tracking within such an environment, you have to **move your tracking codes to external files** and load them from there.

.. important::

   Some tracking codes have to be adjusted to work from within external files, e.g. `Matomo <https://matomo.org/faq/general/faq_20904/>`__.

Cookieman allows to add external sources with the :ref:`inject <trackingObjects.‹tracking-object-key›.inject>` configuration:

.. code-block:: typoscript

   plugin.tx_cookieman.settings.trackingObjects {
       Matomo {
           inject (
               <script src="https://your-domain.com/typo3conf/ext/your_sitepackage/Resources/Public/JavaScript/matomo-trackingcode.js"></script>
               <script src="https://your-matomo-server.com/path/to/matomo.js" async defer></script>
           )
       }
   }

.. tip::

   Read more about the Content Security Policy on the `Mozilla Developer Network <https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP>`__.
