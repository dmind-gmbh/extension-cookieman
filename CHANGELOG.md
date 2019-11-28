# 2.3.5

## MISC
- New Crowdin translations (#46) 76511ac
- remove unnecessary catch {} bb2a91c
- New Crowdin translations (#42) e2c3d6f
- update docs 34fd884
- fix whitespace b5e07d2
- Add reStructuredText documentation (#40) f0e0c92
- use constants in acceptance tests (PHP 7.0 and introduction-package 3 compatible) 39ce3ce
- ignore .lock 320e221
- use constants in acceptance tests 99c6e86
- update docs (type translation) bda492c
- update docs 8e0585b
- update selenium, add selenium-hub and prepare firefox afc44fb
- fix acceptance-tests.yml 7423f73
- use reusable github-action-setup-ddev 3d3c56c

# 2.3.2

## MISC
- fix cgl 4e6cf6a
- closes #35 add API call onScriptLoaded() to register script onload callbacks. (#28) fab9bc1
- fix #37 DNT message is only rendered once 74edceb
- add API to get all consented groups (3) fa28b0a
- add API to get all consented groups (2) 5a5e473
- add API to get all consented groups d71fbcd
- #31 add configuration of CookieConsent to base TypoScript 49d9635

# 2.2.5

## MISC
- fix #31 split TypoScript into Base + Examples a0da8b6
- fix #33 sort group.trackingsObjects by key and prevent JSON-object-cast dae2d40
- remove outdated reference to test extension 3f67c60
- run composer-normalize 15e9473
- add composer-normalize 527e3f9
- add composer-normalize 1c48139
- speed-up startup 52b4d6e
- depend on the test setup (--dev) 4a91ad6
- docs 3d81f41
- fix #32 make examples CSP-ready 837280d
- copy all nodes from injects() - get rid of container 47656ef
- configure bootstrap-package to not use inline WebFontLoader (breaks CSP) 6034c0a
- remove dependencies from test extension cafaf0b
- minify 0187a6c
- include Content-Security-Policy in our test extensions & use our Crowdin Widget as test case 6558b48
- fix #28 s attributes not properly inserted b595ae1
- customize TypoScript in test extension 571e405
- fix typo 3de85c5
- make JS more error-tolerant (here: arbitrary cookie values) 550ae1e
- fix all test extensions being active c414194

# 2.2.2

## MISC
- give animations more time 08139c9
- use PHP 7.3 locally 667cc3f
- use typo3-console for v8/v9 e7ef835
- cleanup 97918f7
- add v9-link-without-site-package d140322
- adapt for 9lts 98c2fbe
- update README badges 0a479cd
- split Github actions into ‹CGL & unit› and ‹acceptance› tests. Use ddev with a patch to run acceptance tests in Github actions. 4b5256b
- align pre-commit with new composer {scripts} b44b984
- add composer typo3:flush command de7cd1a
- refactor composer {scripts} 998f598
- bump PHP version for TYPO3v9 634213e
- fix bootstrap3-banner a9cd45f
- use codeception to run acceptance tests e9de1be
- manual 3-way merge to align translations (#26) e36a563
- New Crowdin translations (#22) a861367
- New translations locallang.xlf (French) (#19) 904b68b
- fix 9lts bootstrapping of test extensions 1322841
- New translations locallang.xlf (Romanian) 96bc972
- New translations locallang.xlf (Italian) b858838
- New translations locallang.xlf (Romanian) 9f18cac
- New translations locallang.xlf (Italian) daeab8c
- New Crowdin translations (#13) 85246dc
- New translations locallang.xlf (Italian) 47c3561
- New translations locallang.xlf (Romanian) e0c41ac
- New translations locallang.xlf (Romanian) fcbe141
- New translations locallang.xlf (Italian) dc6f5c0
- New Crowdin translations (#8) 5003bd1
- remove unused .crowdin.yml 0fe0ffa
- New translations locallang.xlf (Danish) 882e754
- New translations locallang.xlf (Romanian) 53a1855
- Update Crowdin configuration file b3c1989
- add links 2c281ea
- fix typo 34fcf3c
- fix test badge a351329
- remove workflow dependency 1874a89
- revert last idea 1fe799e
- run composer and coveralls only one in workflow 99b88db
- add unit test badge 8c59f9b
- revert broken version f5af939
- use deprecated method to stay compatible with PHPUnit 6.5 700f251
- run unit tests with PHP 7.2 + 7.3 acfd2fb
- add code coverage checking ac8b1a2
- add composer 09566e3
- add docker test container 109f45d
- add DataProcessor test 8142a07
- use relative symlink to make it work host- and ddev-wise 89cd5fe
- shorten local startup time 0eeba3e
- add .gitconfig for local dev f98dbc0
- remove .crowdin.yaml from export 233641c

# 2.1.13

## MISC
- remove  from templates (small is really small...) 98aa8e6
- fix xdebug (again...) c529354
- fix docker-env 5866624
- backport master 69c7f1c
- ignore yarn error logs 8d9f99d
- add notice about CDNs 942df3f
- document defaults 32eb05e
- document showOnce() 1488574
- format docs abcc58a
- document minify 7b79824
- explain extensing types bed8cf9
- add notice about weird versioning 7629f35
- New translations locallang.xlf (Romanian) dbaaa25
- New translations locallang.xlf (Spanish) a70baff
- New translations locallang.xlf (Romanian) 0a555b6
- New translations locallang.xlf (French) 523fc15
- New translations locallang.xlf (Romanian) 10d58ff
- New translations locallang.xlf (German) 14934fc
- New translations locallang.xlf (Danish) 6899712
- New translations locallang.xlf (Danish) 6379697
- format documentation 44731f3
- add TER link 4a9e0cd
- remove title branding... 348c010
- more documentation a227a03
- more documentation 2b0c797

# 2.1.7

## MISC
- showcase theme customizing 7548266
- cleanup a5e9cd7
- describe theme customizing 9511182
- change description b0ef7ba

# 2.1.4

## MISC
- adapt release script 5fb0661

# 2.1.1

## MISC
- README (2) 6869018
- README ce08b7c
- New translations locallang.xlf (Vietnamese) 75c15a9
- New translations locallang.xlf (Catalan) c55c74c
- New translations locallang.xlf (Chinese Simplified) c010875
- New translations locallang.xlf (Czech) ab14218
- New translations locallang.xlf (Danish) 8b1a606
- New translations locallang.xlf (Dutch) 4a7eb5a
- New translations locallang.xlf (Finnish) 84cafea
- New translations locallang.xlf (French) b76d2ca
- New translations locallang.xlf (German) 458fddd
- New translations locallang.xlf (Greek) b686120
- New translations locallang.xlf (Hebrew) ef525f1
- New translations locallang.xlf (Hungarian) 026d588
- New translations locallang.xlf (Arabic) adbafc4
- New translations locallang.xlf (Italian) 0d098cd
- New translations locallang.xlf (Korean) 3b9c67e
- New translations locallang.xlf (Norwegian) b881e29
- New translations locallang.xlf (Polish) bc53940
- New translations locallang.xlf (Portuguese) 93531f8
- New translations locallang.xlf (Romanian) 223f682
- New translations locallang.xlf (Russian) d604785
- New translations locallang.xlf (Serbian (Cyrillic)) e6786af
- New translations locallang.xlf (Spanish) fe214a5
- New translations locallang.xlf (Swedish) 383c4b2
- New translations locallang.xlf (Turkish) 2a474f5
- New translations locallang.xlf (Ukrainian) b130533
- New translations locallang.xlf (Japanese) c186c86
- New translations locallang.xlf (Afrikaans) 7b65107
- use SEL for Typo3v9+ f01a71c
- make minify configurable 51e892d

# 2.0.11

## MISC
- compile JS 8ed5fa7
- fix HTML reflow 61dba25

# 2.0.8

## MISC
- edit example - finally had the idea how to fix the translation-via-TypoScript issue. 25300fe
- add example 193ebc9

# 2.0.7

## MISC
- use DataProcessor to enable settings overwritability ebf1e03
- fix duplicate key f93ced9

# 2.0.6

## MISC
- add release process to composer 7f5fe5a
- compile JS 4a330b8
- add minify config ca0e42b
- add screenshots 71cade7
- add Matomo cookie descriptions 99f8a54
- Update Crowdin configuration file 37ebfad
- New translations locallang.xlf (German) 6b6321d
- New translations locallang.xlf (German) f3387a3
- New translations locallang.xlf (Vietnamese) 10787dd
- New translations locallang.xlf (Afrikaans) 9de0d26
- New translations locallang.xlf (Arabic) d26dfa6
- New translations locallang.xlf (Catalan) e1db675
- New translations locallang.xlf (Chinese Simplified) 371c483
- New translations locallang.xlf (Chinese Traditional) bd4cbda
- New translations locallang.xlf (Czech) 053b7f9
- New translations locallang.xlf (Danish) b7805b1
- New translations locallang.xlf (Dutch) 56641c7
- New translations locallang.xlf (Finnish) 6dd5c28
- New translations locallang.xlf (Greek) 261dd4d
- New translations locallang.xlf (Hebrew) ee08107
- New translations locallang.xlf (Hungarian) d1674a9
- New translations locallang.xlf (Italian) 93b3209
- New translations locallang.xlf (Korean) 54fbb06
- New translations locallang.xlf (Norwegian) ab16b22
- New translations locallang.xlf (Polish) df4c3f7
- New translations locallang.xlf (Portuguese, Brazilian) ebd0e06
- New translations locallang.xlf (Romanian) fe03b66
- New translations locallang.xlf (Russian) 8e34ac9
- New translations locallang.xlf (Serbian (Cyrillic)) 20feb06
- New translations locallang.xlf (Spanish) 451daa2
- New translations locallang.xlf (Swedish) b1253f8
- New translations locallang.xlf (Turkish) e23eca6
- New translations locallang.xlf (Ukrainian) 16af679
- New translations locallang.xlf (Japanese) a343b83
- New translations locallang.xlf (French) 9bc12af
- add more bs4-accordion fixes 4df87ec
- fix dependencies 557fbc0
- add group description 4ec5ce8
- gear bootstrap4-modal towards conservative example 23cc1d5
- dynamify bootstrap3-modal 776275f
- add TypoScript docs and starter kit, rename, clean up b3632f1
- add TODO 446d432
- add test extensions for each theme and crowdin link; enable bootstrap4-modal by default ff7df9d
- dynamify bootstrap3-banner 4492034
- use partial for table rows 7f9bba1
- factor common variables out of template 872e137
- add some more translations 69e88c1
- toggle tags instead of ::after (make it translatable) 11a9131
- beautify bootstrap4-modal 7b4b664
- fix HTML reflow, refactor db2dbfb
- use bootstrap_package ^11 for 9lts 98ae158
- ddev 9lts 9e93225
- fix typo a7df3b1
- beautify xlf 08c0bd7
- test crowdin - changing source language string 4e0cca3
- New translations locallang.xlf (Vietnamese) f4421f3
- New translations locallang.xlf (Afrikaans) 5c3ef11
- New translations locallang.xlf (Arabic) 91f8129
- New translations locallang.xlf (Catalan) e7c0d79
- New translations locallang.xlf (Chinese Simplified) 749d100
- New translations locallang.xlf (Chinese Traditional) 7c80f97
- New translations locallang.xlf (Czech) 0999195
- New translations locallang.xlf (Danish) cce2d00
- New translations locallang.xlf (Dutch) 2b36f44
- New translations locallang.xlf (Finnish) 6c8abe4
- New translations locallang.xlf (Greek) c5c66d8
- New translations locallang.xlf (Hebrew) 0663ae9
- New translations locallang.xlf (Hungarian) f856bf6
- New translations locallang.xlf (Italian) 697ccd3
- New translations locallang.xlf (Korean) 322a15a
- New translations locallang.xlf (Norwegian) 1453034
- New translations locallang.xlf (Polish) d163fc7
- New translations locallang.xlf (Portuguese) 77e9322
- New translations locallang.xlf (Portuguese, Brazilian) fc7adcf
- New translations locallang.xlf (Romanian) cf53ab7
- New translations locallang.xlf (Russian) 26aa0f1
- New translations locallang.xlf (Serbian (Cyrillic)) 1059dc2
- New translations locallang.xlf (Spanish) 5726212
- New translations locallang.xlf (Swedish) 864a598
- New translations locallang.xlf (Turkish) d427887
- New translations locallang.xlf (Ukrainian) 03dddbf
- New translations locallang.xlf (Japanese) 8db392d
- New translations locallang.xlf (French) 7e6ce2b
- New translations locallang.xlf (Vietnamese) 81bc8d9
- New translations locallang.xlf (German) 52ea1fb
- New translations locallang.xlf (Afrikaans) db7aca5
- New translations locallang.xlf (Arabic) bd583ca
- New translations locallang.xlf (Catalan) ca8dc83
- New translations locallang.xlf (Chinese Simplified) 4e16b3c
- New translations locallang.xlf (Chinese Traditional) cbc853b
- New translations locallang.xlf (Czech) 3249047
- New translations locallang.xlf (Danish) fe82db0
- New translations locallang.xlf (Dutch) 4442dda
- New translations locallang.xlf (Finnish) b83eacf
- New translations locallang.xlf (Greek) 4a8b61e
- New translations locallang.xlf (Hebrew) b766e90
- New translations locallang.xlf (Hungarian) 20a0a77
- New translations locallang.xlf (Italian) 7b9b0a8
- New translations locallang.xlf (Korean) cca7f50
- New translations locallang.xlf (Norwegian) 5add6fc
- New translations locallang.xlf (Polish) a8f2234
- New translations locallang.xlf (Portuguese) b399d8d
- New translations locallang.xlf (Portuguese, Brazilian) 3769077
- New translations locallang.xlf (Romanian) 3da090a
- New translations locallang.xlf (Russian) bcdc700
- New translations locallang.xlf (Serbian (Cyrillic)) 7900a92
- New translations locallang.xlf (Spanish) 6f7385e
- New translations locallang.xlf (Swedish) 316cc49
- New translations locallang.xlf (Turkish) 31b2124
- New translations locallang.xlf (Ukrainian) f756882
- New translations locallang.xlf (Japanese) 9f9a2fe
- New translations locallang.xlf (German) c20d20c
- New translations locallang.xlf (French) b92a530
- New translations locallang.xlf (English) de499ac
- New translations locallang.xlf (German) 006ff4e
- New translations locallang.xlf (French) 508c1f2
- New translations locallang.xlf (English) 7cacbeb
- New translations locallang.xlf (German) 299fd90
- New translations locallang.xlf (French) 9ac33dc
- New translations locallang.xlf (English) 8db13a2
- New translations locallang.xlf (German) 76aedf1
- New translations locallang.xlf (French) c06de87
- New translations locallang.xlf (English) 76b9c21
- New translations locallang.xlf (German) a402f13
- New translations locallang.xlf (French) 385e99e
- New translations locallang.xlf (English) 231cb3f
- New translations locallang.xlf (German) 8a47b9b
- New translations locallang.xlf (German) 0eac0f5
- New translations locallang.xlf (German) 3d5150c
- New translations locallang.xlf (French) d046e51
- New translations locallang.xlf (English) 60cd66c
- New translations locallang.xlf (German) f6dff60
- New translations locallang.xlf (French) 0d342bc
- Update Crowdin configuration file 3af9b85
- refactor TypoScript, add TypoScript examples b16b1a6
- config via TypoScript; translation cf28bd2
- cleanup a237945
- add TODO 7f34d6e

# 2.0.4

## MISC
- mention w.i.p. in README 30eb235
- remove debug 0773bc5
- inject HTML, take special care of  13ddaac
- add TODOs 0eb5102
- fix exportToHtml 43db0cb
- add translations (w.i.p.) e6e7d3f
- adapt to new TypoScript structure a3dc1ee
- export some settings to HTML c62fa51
- refactor TypoScript, add TypoScript examples 1a87776
- use partial across default themes 29b60cc
- add rootPaths sequence resourceBasePath › default themes › default f1dbecf

# 2.0.1

## MISC
- use release:create 5202f8a
- add release:publish script 7291b89
- enable bootstrap_package compatiblity 95c599e
- config via TypoScript; translation 0907105
- modernize TypoScript include e2b8c38
- style card-body 8ffe8cd
- amend TODO f0c8bc5
- amend TODO 59027eb
- cleanup 2a807bd

# 1.3.3

## MISC
- add TODO section 438eb60
- add extension-helper c9946c9
- use composer update ec5f372
- Bootstrap 4 theme 2f0a6c4
- alias branches to 2.x-dev 477aef9
- remove private Satis 56888ef
- fix .md syntax 04028be
- fix homepage 4436c26
- clarify versions 24e7413
- set new default template 520f2fd
- remove private Satis ecfb3a6
- use typo3-console for v9 setup 43cb5e5
- add cookieman test config 8f4331d
- adapt to missing Configuration/TypoScript 3ec05db
- add v9 templates 17b2ec5
- fix extension nomenclature babe7c2
- set TYPO3 v9 c9705b4
- reorder extension installation b35fa68
- export data from ddev dump-db into writable fs b1488a5
- clean up ddev config 0c82b86
- composer.json dependencies and scripts ecff94a
- add GPLv2 0c1e3c2
- prevent php-cs exporting 676a8ee
- fix PHP d95f80e
- setup TypoScript in cookieman_test 303e255
- add pre-commit CGL hook 84ac154
- add unit tests skeleton fc28183
- emconf f93b49f
- .gitignore fcefdb9
- github issue templates 88c7e7c
- php-cs-fixer 3a00558
- basic JS/CSS build config 5f0674b
- configure git eol and export aeef693
- .editorconfig 1a95786
- beautify 68196ca
- ddev config aa42aca
- add testing extension b3a7f4c
- change default theme e736baa
- use default bootstrap colors // justify text b5a8e8b
- justify text 383f07e
- vertically center collapse indicators 2a8cbd8
- translate common texts 4dfb1a5
- use more usual colors for default theme dec4286
- lint 96f9d9f
- refactor initialisation and JS theme integration e666a7e
- add .gitignore a53d38f

# 1.3.1

## MISC
- drop double e.preventDefault() 6b3afee

# 1.3.0

## MISC
- bump version f6357d3
- remove styling 68fc52a

# 1.2.2

## MISC
- Bump version afd1c16
- docs 74009aa
- docs 62a6e78
- docs f0f0d59
- remove client specific texts e3c20d3
- remove client specific texts 114bb6b

# 1.2.1

## MISC
- bump version 74e447a

# 1.2.0

## MISC
- docs 9c89b3d
- streamline examples (2) 4573e78
- streamline examples (1) 1d17bcc
- include fallback for Fluid paths 3de8f0f

# 1.1.1

## MISC
- bump version f906f2c
- bump version 712f71e

# 1.1.0

## MISC
- bump version 50c9c8f
- add imprint PID to constants; suppress showing popup on imprint/data declaration pages 683fc49
- docs a3cd1e5

# 1.0.0

## MISC
- version constraints 8c5c5e4
- v1.0.0 965dd21

# 0.1.0

## MISC
- pre-stable b89fc5e
- initial 165ae21

