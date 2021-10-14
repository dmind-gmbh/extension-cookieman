.. include:: ../../../Includes.txt

.. toctree::

.. _typoscript-setup:

================
TypoScript setup
================

See a full TypoScript :ref:`configuration-example`.

All configuration is prepended with `plugin.tx_cookieman.settings`.

.. _groups:

groups
^^^^^^
.. rst-class:: dl-parameters

groups
   :sep:`|` :aspect:`Data type:` array
   :sep:`|` :aspect:`Default:` mandatory
   :sep:`|`

   Holds the group configurations. A group contains several tracking objects.

   By default, it only contains the 'mandatory' group, which includes the `CookieConsent` settings cookie.
   See a full TypoScript :ref:`configuration-example`.

.. _groups.<group-key>:

groups.<group-key>
^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

groups.<group-key>
   :sep:`|` :aspect:`Data type:` array
   :sep:`|` :aspect:`Default:` mandatory
   :sep:`|`

   A single group. The group's key (name) should not contain spaces and non-ASCII characters.

   It will be saved in the settings cookie and can be checked with JavaScript: :js:`hasConsented('‹group-key›')`

.. _groups.‹group-key›.preselected:

groups.‹group-key›.preselected
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

groups.<group-key>.preselected
   :sep:`|` :aspect:`Data type:` :ref:`t3tsref:data-type-boolean`
   :sep:`|` :aspect:`Default:` 0 (not set)
   :sep:`|`

   If enabled (`1`), the group's consent checkbox will be already checked when the popup opens.

   The default group 'mandatory' has this set to `1`.

.. _groups.‹group-key›.disabled:

groups.‹group-key›.disabled
^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

groups.<group-key>.disabled
   :sep:`|` :aspect:`Data type:` :ref:`t3tsref:data-type-boolean`
   :sep:`|` :aspect:`Default:` 0 (not set)
   :sep:`|`

   If enabled (`1`), the group's consent checkbox will be disabled (cannot be changed).

   The default group 'mandatory' has this set to `1`.

.. _groups.‹group-key›.trackingObjects:

groups.‹group-key›.trackingObjects
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

groups.<group-key>.trackingObjects
   :sep:`|` :aspect:`Data type:`  array with numeric indices
   :sep:`|`

   Holds a list of tracking object keys (numbered).

   Example:

   .. code-block:: typoscript

      trackingObjects {
        0 = CookieConsent
        1 = fe_typo_user
      }

.. _groups.‹group-key›.respectDnt:

groups.‹group-key›.respectDnt
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

groups.<group-key>.respectDnt
   :sep:`|` :aspect:`Data type:` :ref:`t3tsref:data-type-boolean`
   :sep:`|` :aspect:`Default:` 0 (not set)
   :sep:`|`

   If set to `1`, this group respects to the `"Do-not-track" setting of your browser <https://en.wikipedia.org/wiki/Do_Not_Track>`__.

.. _groups.‹group-key›.showDntMessage:

groups.‹group-key›.showDntMessage
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

groups.<group-key>.showDntMessage
   :sep:`|` :aspect:`Data type:` :ref:`t3tsref:data-type-boolean`
   :sep:`|` :aspect:`Default:` 0 (not set)
   :sep:`|`

   If set to `1` **and** the `"Do-not-track" setting of your browser <https://en.wikipedia.org/wiki/Do_Not_Track>`__ is enabled, an additional message about that is shown inside the group.

.. _trackingObjects:

trackingObjects
^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

trackingObjects
   :sep:`|` :aspect:`Data type:` array
   :sep:`|`

   This array holds the tracking object configurations.

   The Cookieman extension already provides several **preconfigured** tracking objects
   in the folder `./Configuration/TypoScript/TrackingObjects/ <https://github.com/dmind-gmbh/extension-cookieman/tree/master/Configuration/TypoScript/TrackingObjects>`__
   (link to the Github repository).

   .. important::
      If you add a preconfigured tracking object, you must at least **adapt** the `inject` code to your needs!

   The default group 'mandatory' only contains the tracking object `CookieConsent` settings cookie.

.. _trackingObjects.‹tracking-object-key›:

trackingObjects.‹tracking-object-key›
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

trackingObjects.‹tracking-object-key›
   :sep:`|` :aspect:`Data type:` array
   :sep:`|` :aspect:`Example:` fe_typo_user
   :sep:`|`

   A single tracking object configuration.

   Example:

   .. code-block:: typoscript

      plugin.tx_cookieman.settings.trackingObjects {
          // 'Matomo' is the ‹tracking-object-key›:
          Matomo {
              // injected code, if consent is given:
              inject (
                  <script data-what="Matomo" src="/typo3conf/ext/cookieman/Resources/Public/Js/Injects/example-inject.js"></script>
              )

              show {
                  // set cookies, if consent is given:
                  _pk_id {
                      duration = 13
                      durationUnit = months
                      type = cookie_http+html
                      provider = Matomo
                  }

                  // etc.
              }
          }
      }

.. _trackingObjects.‹tracking-object-key›.inject:

trackingObjects.‹tracking-object-key›.inject
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

trackingObjects.‹tracking-object-key›.inject
   :sep:`|` :aspect:`Data type:` :ref:`data-type-html-code`
   :sep:`|` :aspect:`Example:`  <script src="/path/to/tracking-code.js"></script>
   :sep:`|`

   Each HTML tag in here will be appended to the page when the respective group is consented.
   This can be `<script>`, `<img>` or anything else.

   You can either use inline script or link to an external file (useful if a HTTP header `Content-Security-Policy` is set).

.. _trackingObjects.‹tracking-object-key›.show:

trackingObjects.‹tracking-object-key›.show
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

trackingObjects.‹tracking-object-key›.show
   :sep:`|` :aspect:`Data type:` array
   :sep:`|`

   The actual rows of the table, each representing one "tracking item" (usually a cookie).

.. _trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›:

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›
   :sep:`|` :aspect:`Data type:` array
   :sep:`|` :aspect:`Example:`  _pk_id
   :sep:`|`

   A single "tracking item" (e.g. the name of a cookie).
   A cookie that matches this name will be removed when consent for the group in which this tracking object is included
   is revoked. (see also :ref:`trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.htmlCookieRemovalPattern`)

.. _trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.duration:

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.duration
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.duration
   :sep:`|` :aspect:`Data type:` :ref:`data-type-positive-integer`
   :sep:`|` :aspect:`Example:`  12
   :sep:`|`

   The lifetime of the tracking object (only the "number" part).

.. _trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.durationUnit:

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.durationUnit
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.durationUnit
   :sep:`|` :aspect:`Data type:` :ref:`data-type-string`
   :sep:`|` :aspect:`Example:`  months
   :sep:`|`

   The lifetime of the tracking object (only the "unit" part).

.. _trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.type:

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.type
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.type
   :sep:`|` :aspect:`Data type:` :ref:`data-type-string`
   :sep:`|` :aspect:`Example:`  cookie_http+html
   :sep:`|`

   The type of tracking.

   Possible (default) keywords:

   * `cookie_http+html`: an HTML (=HTTP+HTML) cookie, which is also readable from JavaScript.
     This is the only type that can be removed after consent has been revoked.
   * `cookie_http`: an HTTP cookie
   * `pixel`: a tracking pixel

   .. note::
      You can add your own types by adding a localization string `type.‹your-type-key›`.

.. _trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.provider:

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.provider
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.provider
   :sep:`|` :aspect:`Data type:` :ref:`data-type-string`
   :sep:`|` :aspect:`Example:` Google
   :sep:`|`

   The provider of the cookie or tracking object.

.. _trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.htmlCookieRemovalPattern:

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.htmlCookieRemovalPattern
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. rst-class:: dl-parameters

trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.htmlCookieRemovalPattern
   :sep:`|` :aspect:`Data type:` :ref:`data-type-string`
   :sep:`|` :aspect:`Example:`  ^_gat(?:_UA\-\d+\-\d+)?$
   :sep:`|`

   You can (optionally) set a regex pattern for cookie names here. It will be used during cookie removal.
   If would remove all matched cookies when consent for the group in which this tracking object is included is revoked.
   If this is empty, the tracking object key is used for deletion (see :ref:`trackingObjects.‹tracking-object-key›`).

   .. note::
      Cookie removal will only work for tracking object type `cookie_http+html`.
      See :ref:`trackingObjects.‹tracking-object-key›.show.‹tracking-item-key›.type`.
