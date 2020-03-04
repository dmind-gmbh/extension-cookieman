.. include:: ../../Includes.txt


.. _customization:

=============
Custom themes
=============

Target group: **Developers, Integrators**


Create a new theme or adapt an existing one
===========================================

.. note::

   We are happy to receive pull-requests for new themes!


This is a recommendation how to set up your template structure for a custom extension.

1. Set your base path in TypoScript constants:

.. code-block:: typoscript

   plugin.tx_cookieman.settings.resourcesBasePath = EXT:your_ext/Extensions/cookieman/Resources


2. Choose a new theme name:

.. code-block:: typoscript

   plugin.tx_cookieman.settings.theme = myTheme


3. Create folder `EXT:your_ext/Extensions/cookieman/Resources/Private/Themes/myTheme/`.
   Add 3 folders: `Templates`, `Partials`, `Layouts`.

4. These folders will have the highest priority when looking for templates, partials or layouts now.
   The fallback will be `EXT:cookieman/Resources/Private/*`.

5. Create folder `EXT:your_ext/Extensions/cookieman/Resources/Public/Themes/myTheme`. This will hold the files `cookieman-theme(.min).css` and `cookieman-theme(.min).js`. Reimplement the methods cookieman.show() and cookieman.hide() in `cookieman-theme(.min).js`.

6. Copy the .css, .js and .html files as needed from a default theme.

7. Adapt the HTML/CSS/JS as needed.


Storing user consent
====================

These **HTML element attributes** control the functionality:

<* data-cookieman-save>
^^^^^^^^^^^^^^^^^^^^^^^

   Save and close


<* data-cookieman-accept-all>
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

   Mark all checkboxes

<* data-cookieman-accept-none>
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

   Uncheck all checkboxes (will just leave the groups with the options preselected=1, disabled=1 checked)

They can appear multiple times and also together on the same element.

Example:

.. code-block:: HTML

   <button class="btn btn-primary"
           data-cookieman-accept-all
           data-cookieman-save>
               {f:translate(key: 'accept')}
   </button>
