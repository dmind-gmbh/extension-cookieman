.. include:: ../../Includes.txt


.. _configuration-example:

=====================
Configuration example
=====================

Target group: **Developers, Integrators**


Example
=======

This example configuration is based on the base TypoScript configuration
(see :ref:`installation-steps`) without the example template.

.. code-block:: typoscript

   temp.tx_cookieman.settings.groups.mandatory < plugin.tx_cookieman.settings.groups.mandatory

   plugin.tx_cookieman.settings {
       trackingObjects {
           # extend the existing configuration for 'Matomo'
           Matomo {
               inject (
               <script type="text/javascript">
                 var _paq = window._paq || [];
                 _paq.push(['trackPageView']);
                 _paq.push(['enableLinkTracking']);
                 (function() {
                   var u="//my-piwik-server.my-domain.com/";
                   _paq.push(['setTrackerUrl', u+'matomo.php']);
                   _paq.push(['setSiteId', 'my site ID']);
                   var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                   g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
                 })();
               </script>
               )
           }

           # add my own custom tracking solution
           # if you have a useful configuration and want to share, we would be happy if you did a pull request!
           MyOwnTrackingPixel {
               inject (
                   <div>Here be dragons <img src="https://via.placeholder.com/200x200?text=Tracking pixel..."></div>
                   <script>alert('oh la la!')</script>
               )
               show {
                   # each element here represents one line of information in the consent popup
                   pixelphp {
                       duration = 1
                       durationUnit = months
                       type = pixel
                       provider = My Website Inc.
                   }
               }
           }
       }

       # reset existing groups
       groups >
       groups {
           # copy of default group 'mandatory'
           mandatory < temp.tx_cookieman.settings.groups.mandatory

           # my new group
           mygroup {
               trackingObjects {
                   0 = Matomo
                   1 = MyOwnTrackingPixel
               }
           }
       }
   }

   plugin.tx_cookieman._LOCAL_LANG {
       en {
           trackingobject.pixelphp = You can translate the name, but you do not have to.
           trackingobject.pixelphp.desc = My own tracking pixel does not really track you. It's just here to cheer you up.
           group.mygroup = My group is my castle.
           type.pixel = Tracking pixel
       }
       default < .en
   }


Make the consent revokable
==========================

It is recommended to include a snippet like the following on your data privacy statement page
to allow your users to adjust their cookie preferences:

.. code-block:: HTML

   <button onclick="cookieman.show(); return false">
     Adjust your cookie preferences
   </button>
