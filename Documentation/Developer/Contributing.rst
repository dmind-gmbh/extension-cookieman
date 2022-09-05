.. include:: ../Includes.txt


.. _contributing:

.. Helps Github discover the contributors page:
.. _contributors:

============
Contributing
============

Target group: **Contributors**

Thank you for considering contributions! You can contact us with any questions.

.. _contribute_docs:

Documentation
=============

You are welcome to help improve this guide. Just click on "Edit me on GitHub"
on the top right to submit your improvement via a Pull Request.

.. _contribute_feedback:

Translations
============

Translations are managed on the official TYPO3 translation platform.
See :ref:`Translation <translation>`.


Feedback
========

Any problems? You miss a feature? There is an incompatibility? You have strategic input?

Please open an issue
`at our Github repository <https://github.com/dmind-gmbh/extension-cookieman/issues>`__
after you have read the documentation.

.. _contribute_code:

Code (Templates, JavaScript, PHP)
=================================

We are happy to receive pull requests.

Branches
--------

We use one branch for each stable TYPO3 API version. This model is not followed by many extensions.
It allows us to
focus on that API only and not worry about compatibility constructs or inabilities to incorporate any new
TYPO3 feature. So absolutely no `if (TYPO3_VERSION ...)` in cookieman.

Also it simplifies testing, as each version might need a different setup.

After switching branches, you might need a `git clean -fdX` to remove any ignored files which were
created by another version's build (append `-e '!.idea'` to exclude .idea).

Supported TYPO3 versions
~~~~~~~~~~~~~~~~~~~~~~~~

* all LTS versions: features, bugfixes, security
* ELTS versions: security

Exceptions can be made if Pull Requests are provided.

We strive to support the latest version, too (but no promises).


Releases
--------

Releases follow `semver <https://semver.org/>`__. Including with composer via `dmind/cookieman: ^2.0` shall never
break any documented feature or the input or output of any function marked with @api in the code.
Be sure to shoot us an angry message if we messed up!

We usually release for all maintained TYPO3 APIs at the same time and use consecutive patch versions (e.g.
2.2.3, 2.2.4, 2.2.5), each supporting one.


Create a new release
~~~~~~~~~~~~~~~~~~~~

Before creating a release you should merge the automatic Crowdin PRs until TYPO3v9 (in v10+ translations are 
Crowdin-only, for earlier versions we distribute them because we were not on the older "poodle" server).

:command:`composer release:create <version, e.g. 2.5.7>` will create a release commit and an annotated Git tag.
Pushing it with :command:`git push --tags` makes the new release available for composer (packagist).
It also triggers the Github Actions workflow "publish-ter" which uses the TER API via "tailor" to publish the new
release to TER.


Run locally
-----------

:command:`ddev start && ddev launch` will install a TYPO3 with example content and cookieman.
This installs helper extensions that automatically enable a certain theme and some TypoScript setup to facilitate
development.
The admin user is "admin", password "adminadmin".

The ddev custom command :command:`ddev install-git-hooks` installs CGL checkers as pre-commit hooks (only tested on Linux
so far - the script runs under the container environment so good chances that this would work for other OSs as
well).

To throw away the database and restart cleanly, run :command:`ddev rm -ORU && git clean -fdX -e '!.idea' && ddev start`


Run in Gitpod
-------------

Thanks to https://drud.github.io/ddev-gitpod-launcher/, we are able to develop DDEV project in the cloud.

`This link <https://gitpod.io/#DDEV_REPO=https%3A%2F%2Fgithub.com%2Fdmind-gmbh%2Fextension-cookieman,DDEV_ARTIFACTS=/https://github.com/drud/ddev-gitpod-launcher/>`__
opens the cookieman development environment in Gitpod.


Composer scripts
----------------

Have a look at the `composer.json`'s `script` section. This is the main entry point for any commands needed
during development. Use :command:`ddev composer` from outside the container or just :command:`composer` from inside.

- :command:`ddev composer cookieman:...` enables an official cookieman theme. The "customtheme" shall resemble an integrator
  following our documentation.
- :command:`ddev composer build` generates minified JS/CSS.
- :command:`ddev composer test` runs all important tests. You do not strictly have to run tests before opening a
  pull request - they are also run post-commit on
  `Github actions <https://github.com/dmind-gmbh/extension-cookieman/actions>`__.
- :command:`ddev composer fix:cgl` tries to fix linting problems.
