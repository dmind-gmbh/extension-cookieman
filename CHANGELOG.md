# 2.9.11

## FEATURE

- [FEATURE] Enable Do-Not-Track in all examples, beautify DNT-message (#244) f140ea6

## TASK

- [TASK] prevent creating release commits from ddev 45af3d9

## BUGFIX

- [BUGFIX] fix bootstrap3-banner compatibility with bootstrap_package d29dd0b

# 2.9.6

## FEATURE

- [FEATURE] Document reasoning for closable modals 6e5c47c

## TASK

- [TASK] Adapt package description b6ee558
- [TASK] update npm dependencies caafb20
- [TASK] Output sphinx warnings after build:docs 6ceb400
- [TASK] add new extension icon 301d532
- [TASK] Improve English TrackingObject texts (thanks to @t3webman) 4f19032

## MISC

- [DOCS] Split TypoScript setup and constants, add tocmenus and Developer/JavaScript 325c3b1
- [DOCS] Link to Github instead of listing pre-configured tracking objects 412a2e7
- [DOCS] Clarify requirements for cookie removal and introduction text d918305
- [DOCS] add CONTRIBUTING.rst 77f786c
- [DOCS] Fix formatting problems in docs (#230) 54df573

# 2.9.2

## FEATURE

- [FEATURE] use WebDriver acceptInsecureCertificates, enable Firefox acceptance tests in CI 33246a8

## TASK

- [TASK] cleanup Selenium container configs bc092ae
- [TASK] use WebDriver's clickWithLeftButton() since it includes moveMouseOver() 31a6fe1
- [TASK] update php_cs config (remove deprecations) cf3865b
- [TASK] use phpspec/prophecy-phpunit 58fe3b4
- [TASK] upgrade and cleanup npm dependencies 21d7789
- [TASK] upgrade dependencies b4f207d
- [TASK] upgrade npm-dependencies 4bf6c1c
- [TASK] cleanup 5cbfb4a
- [TASK] use strict locators and clickWithLeftButton() 3f33f54
- [TASK] reuse existing browser instance 1b9ae0a
- [TASK] cleanup selenium docker-compose.yaml 53eb2ac
- [TASK] use JavaScript's scrollIntoView() instead of CodeCeption's scrollTo() 8640ae6

## BUGFIX

- [BUGFIX] remove justified text for improved readability 207f2a3
- [BUGFIX] fix Firefox acceptance tests d9cba06
- [BUGFIX] fix Firefox acceptance tests (reason unknown...) 782f5d4
- [BUGFIX] fix Firefox acceptance tests (reason unknown...) 724925b
- [BUGFIX] fix strict locator 3875ac9

## MISC

- [DOCS] add supported versions information 9d038ef
- Bump postcss from 8.2.8 to 8.2.10 in /Build (#217) 4671d30

# 2.8.2

## FEATURE

- [FEATURE] use TYPO3 tailor to publish to TER 81fd75a

## TASK

- [TASK] backport to 10LTS 762bdc1
- [TASK] Adapt TYPO3 compatibility statements a88e4a9
- [TASK] add typo3-ter replace 8db893d
- [TASK] minify theme CSS 4ccc67d
- [TASK] adapt acceptance test button selector bd0957b
- [TASK] remove local translation files for TYPO3v10 5288fff
- [TASK] use codeception's clickWithLeftButton since it seems to imply scrolling the page there 7050dcf
- [TASK] use distributed js.cookie.min.js 6f47155
- [TASK] use composer shortcut for typo3cms 151b466
- [TASK] remove finicky acceptance test; wait for cookieman.js to be loaded 19322b7
- [TASK] install TYPO3 if DB empty but LocalConfiguration.php present (ddev) 60bcfc1
- [TASK] set XDEBUG_MODE=coverage 8286ab1
- [TASK] allow unit-tests-lowest to fail 434fcb2
- [TASK] use lowest PHP version for TYPO3v10 1bd5c23
- [TASK] upgrade yarn dependencies 7597b0e
- [TASK] upgrade ddev config 6cac700
- [TASK] use master branch coverage 32960f4
- [TASK] try to fix coveralls "detached head" (2) 9d21543
- [TASK] try to get fix coveralls "detached head" adfcf47
- [TASK] upgrade phpunit 1bebc6c
- [TASK] add codeception modules for acceptance tests 7c5fac3
- [TASK] show package versions in CI 8271131
- [TASK] remove deprecated composer --no-suggest 226ccb4

## BUGFIX

- [BUGFIX] make example templates accessible (#195) (#196) 72e3321
- [BUGFIX] adapt non-supported :not() selector chain 4b07f23
- [BUGFIX] use strict selector for "Save" button (acceptance) 46f079e
- [BUGFIX] use selector for clickWithLeftButton ee657df
- [BUGFIX] fix typo; marketing group used non-existent "SlideShare" example config; harden against undefined trackingObjects (examples) ca203bd
- [BUGFIX] add ViewHelper test c1524dd
- [BUGFIX] fix DataProcessor test c84f28c
- [BUGFIX] Remove deprecated Github actions env for coveralls 34180d3
- [BUGFIX] fix version php-cs incompatibility 4a7dfa9
- [BUGFIX] sanitize composer.json 8aa8b70
- [BUGFIX] remove composer-normalize (package installation unstable in composer 2) 96f3976

## MISC

- [DOCS] Add section how to adapt existing theme (#202) a0dcc66
- New Crowdin updates (#189) 6f6c052
- Add tracking objects for Microsoft Forms/-Stream/Slideshare/Youtube/Maps (#158) (#167) c15c216
- Bump ini from 1.3.5 to 1.3.8 in /Build (#183) cc826c3
- Update Index.rst (#186) 0833a53
- New translations locallang.xlf (TYPO3 In-Context Localization) (#176) 6b0d5b5
- use selenium+mkcert automated docker hub builds (2) 45d9861
- use selenium+mkcert automated docker hub builds 9a40e58
- New translations locallang.xlf (TYPO3 In-Context Localization) (#165) 9eb1b93

# 2.7.2

## MISC

- yarn upgrade 3533474
- yarn update c1aee28
- update actions/upload-artifact 819bb23
- New translations locallang.xlf (TYPO3 In-Context Localization) (#161) d6ac866
- fix missing js.cookie.js f0784a9
- add API for consenting #158 b65c800
- composer normalize d07443c
- add composer config sort-packages b66e2c4
- New translations locallang.xlf (TYPO3 In-Context Localization) (#154) bc5570d
- Update Crowdin configuration file 086f531

# 2.6.2

## MISC

- remove typo3-console from --dev 05cb557
- branch off 10lts 3bdad16
- upgrade npm packages 18108ba
- lint 9642f38
- Try multiple cookie domains and paths during HTML cookie deletion. Fixes #137 708f0ed
- Bump elliptic from 6.5.2 to 6.5.3 in /Build (#152) 62118da
- New Crowdin updates (#144) b4d0c9b
- Bump lodash from 4.17.15 to 4.17.19 in /Build (#148) ee99dcc
- get ready for ddev 1.15 dec0154

# 2.5.2

## MISC

- add ViewHelper namespace c: to Partial as well ad0a9a7
- New Crowdin translations (#141) 346bbec
- New Crowdin translations (#139) 6a3f7e6
- Move example-inject.js to Js/Injects/ d34908c
- Wait longer for modal to cater for the delay we added 1c859e5
- Provide "Deny all cookies" button #132 c888674
- Set SameSite: lax for the CookieConsent cookie #135 a8420b5
- Inhibit init() to get out of the main rendering thread and prevent early page reflow #138 fed21b7
- Bump websocket-extensions from 0.1.3 to 0.1.4 in /Build 0ede112
- New translations locallang.xlf (Danish) [Crowdin pull request] 2bd97e4
- upgrade testing-framework, adapt unit tests ee1487a
- inject dependencies in DataProcessor (v10 only) 1a15c4a
- followup: add missing ViewHelper namespace 0573936
- Hide tables if no rows are to be output #118 e13c142
- New Crowdin translations (#126) b9ac4f5
- simplify TYPO3v10 setup as we now have typo3-console for v10 (yay!) 152e0d6
- update composer dependencies on start ad57780
- upgrade vulnerable js-cookie version to 2.2.1 use yarn package and webpack to build Fixes #124 2356c2b
- update all yarn packages 8a50402

# 2.4.5

## MISC

- improve docs 6574dbc
- add the "composer build:docs" command 03cfd86
- Add documentation for contributing to cookieman d5f56e1
- add htmlCookieRemovalPattern documentation Fixes #90 9d573d6
- New Crowdin translations (#120) 985a3c1
- re-adjust CI (acceptance was not run with normal pulls) 2442522
- fix the ConfigurationManager call cf2d328
- fix CGL 27add8e
- add strict_types CGL c73b110
- add docs rendering to Github actions f3ab254
- simplify composer command namespaces ab43328
- increase CodeCeption waitFor* timeout 8e8c25d
- add facebook Pixel example configuration 36d8aea
- use example TypoScript setup for testing c2e3769
- Add PHP 7.4 to unit tests 71d85a9
- New Crowdin translations (#111) 30e715a
- update description 9b4644a
- fix typo in locallang.xlf. Fixes #109 136e463
- upgrade yarn-lock 0236445
- Bump acorn from 6.4.0 to 6.4.1 in /Build (#110) 01185d9
- New translations locallang.xlf (Danish) (#104) f29945a
- update ddev config f90ea9d
- New Crowdin translations (#101) f37e112
- New Crowdin translations (#97) b237b5a
- re-enable unconditional Crowdin language export (fixes missing Dutch language) 44ecb21
- New Crowdin translations (#93) 37b4cde
- Codeception/Chrome/WebDriver (one of those?) is not setting cookies correctly. This implements a JS-function to take care of that. 3885ac3

# 2.4.0

## MISC

- minify 7c4f58b
- Delete cookies by regex pattern (#88) 7780dd0
- Create api endpoint to check user consent for a specific trackingobject (#89) 8d5b6f7
- allow stable TYPO3v10 releases 066f948
- Prevent changing checkbox states when there is no settings cookie yet. Fixes #85 0b804cd

# 2.3.9

## MISC

- add data-cookieman-accept-none option #83 2709859
- New Crowdin translations (#78) dda0365
- New translations locallang.xlf (German) (#75) 8901f3b
- New Crowdin translations (#72) e1640f9
- add eTracker example configuration and texts feaa0ef
- add CSP nonce to testing environment ce89a58
- remove cookies when consent is revoked #65 e1650d6
- improve extension icon PNG quality ddef031
- New translations locallang.xlf (Romanian) (#71) 883b0e0
- restrict acceptance tests to opening PRs bf7c189
- sppedup acceptance tests d7958e9
- enable browserstack Mac OS Safari ce39e0d
- cleanup 8d51125
- use title instead of alert due to browserstack not interacting with popups 77c9814
- force restart for browserstack 6dc75d3
- use reloadPage() after setting cookies b709aa5
- hint at firefox debugging 3fb051d
- use docker hub for the "mkcert-enhanced selenium-node" images 85bbbfe
- install and run `mkcert -install` on selenium nodes, run acceptance tests via https 6203d52
- remove unused variable, adjust docs 8c86917
- cleanup ddev-router template (now in external github action) 2c5f8bd
- use actions/checkout@v2 22f8473
- New Crowdin translations (#66) d1c3885
- update ddev config 3457ed9
- upgrade yarn packages 68d4c7d
- Add logo 5a3e138
- new translation (manual merge) 3d3ddb6
- speed up unit tests 1a277ba
- inhibit push to coveralls on composer-lowest stage 8111de1
- use  instead of  where applicable 5570acb
- New translations locallang.xlf (Danish) (#61) 3dd5169
- New Crowdin translations (#57) e2b4576
- bring in the other languages again d00c87e
- try actions/checkout@v2-beta... 29f9d6e
- use actions/checkout@v2 (2) c835007
- fix github action branch exclusion 7d0b792
- use actions/checkout@v2 c82a1f6
- inhibit tests on l10n_* branches (2) 682cd6d
- inhibit tests on l10n_* branches 4d2707d
- reduce crowdin export languages bcd078a
- set crowdin commit message 98172f4
- fixed source string f3943f0

# 2.3.6

## MISC

- retrigger docs rendering bf4b27e
- retrigger docs rendering 40009f9
- retrigger docs rendering d5e1385
- document the differences among the example themes 54668ac
- fix typo 99916c1
- remove button-group in bootstrap3-modal example theme 889fcce
- use  instead of  in example themes fa438c4
- remove button rel="nofollow" 94c73b7
- add warning to inline-JS 121e07a
- Merge remote-tracking branch 'origin/l10n_master' 5df8d86
- Add How-To section to documentation (#56) 748bb2f
- New translations locallang.xlf (German) 5a36dab
- New translations locallang.xlf (German) ab6dc80
- New translations locallang.xlf (Vietnamese) 963722b
- New translations locallang.xlf (Catalan) d576e61
- New translations locallang.xlf (Chinese Simplified) be9ecea
- New translations locallang.xlf (Czech) 6f08cad
- New translations locallang.xlf (Danish) 7ca59dd
- New translations locallang.xlf (Dutch) af70dea
- New translations locallang.xlf (Finnish) 1acb538
- New translations locallang.xlf (French) aebff6a
- New translations locallang.xlf (German) 4bc1f8d
- New translations locallang.xlf (Greek) 1d543cc
- New translations locallang.xlf (Hebrew) 5c15bef
- New translations locallang.xlf (Hungarian) 9403afa
- New translations locallang.xlf (Arabic) b7b7742
- New translations locallang.xlf (Italian) c48d67b
- New translations locallang.xlf (Korean) 9f8ca6e
- New translations locallang.xlf (Norwegian) 3b281f4
- New translations locallang.xlf (Polish) 80c45ef
- New translations locallang.xlf (Portuguese) d7a9aa9
- New translations locallang.xlf (Romanian) 3e74c2a
- New translations locallang.xlf (Russian) 748f1f6
- New translations locallang.xlf (Serbian (Cyrillic)) ad34d63
- New translations locallang.xlf (Spanish) 791a76e
- New translations locallang.xlf (Swedish) ba21431
- New translations locallang.xlf (Turkish) 7e0f787
- New translations locallang.xlf (Ukrainian) b0aaed7
- New translations locallang.xlf (Japanese) 484e182
- New translations locallang.xlf (Afrikaans) 7dbbd6b
- fix en source string 74d1afd
- help scrutinizer 3dd7ad8
- New translations locallang.xlf (German) a7f1845
- New translations locallang.xlf (Danish) f61fbfa
- New translations locallang.xlf (German) 29b0f3f
- New translations locallang.xlf (Danish) ad4b32f
- New translations locallang.xlf (Vietnamese) 4d8b20b
- New translations locallang.xlf (Catalan) e73447c
- New translations locallang.xlf (Chinese Simplified) e9c171f
- New translations locallang.xlf (Czech) 9ce3f6f
- New translations locallang.xlf (Danish) 66261a2
- New translations locallang.xlf (Dutch) cfcee86
- New translations locallang.xlf (Finnish) 26fe920
- New translations locallang.xlf (French) b4a9913
- New translations locallang.xlf (German) 5388eae
- New translations locallang.xlf (Greek) 8febb7b
- New translations locallang.xlf (Hebrew) c699d17
- New translations locallang.xlf (Hungarian) 1cf8a9d
- New translations locallang.xlf (Arabic) ba0e479
- New translations locallang.xlf (Italian) f1c0b9a
- New translations locallang.xlf (Korean) ed564a3
- New translations locallang.xlf (Norwegian) 0a0e7f3
- New translations locallang.xlf (Polish) f5106b1
- New translations locallang.xlf (Portuguese) b9df38e
- New translations locallang.xlf (Romanian) 285a86a
- New translations locallang.xlf (Russian) 0fe0674
- New translations locallang.xlf (Serbian (Cyrillic)) 67f3aa5
- New translations locallang.xlf (Spanish) e959973
- New translations locallang.xlf (Swedish) a1b27da
- New translations locallang.xlf (Turkish) 66c37ac
- New translations locallang.xlf (Ukrainian) c4722cd
- New translations locallang.xlf (Japanese) bbfddba
- New translations locallang.xlf (Afrikaans) e9b3e71
- add Google Tag Manager cookie _dc_gtm description d1c3e40
- New Crowdin translations (#50) c78cb49
- maybe again improve links display 27b0cd8
- maybe improve links display 2f2c377
- reduce README.md acad8ac
- give credit to an awesome person bf773a8
- fix ext_emconf category 6427d1a
- Revert "add PHP 7.4 to testing matrix for master" b5d288c
- add PHP 7.4 to testing matrix for master 3d4c36d
- gte more debugging from selenium drivers e634b00
- use browserstack for iPhone and Safari 32537c6
- use browserstack for iPhone and Safari f0a99b1
- use browserstack for iPhone and Safari cde3d35
- fix TYPO3v10 bootstrapping 015b420
- test sanitizedSettings() ac1c72a
- remove release:prepare from mandatory steps for release:create 58efd32

# 2.3.3

## MISC

- New translations locallang.xlf (German) (#44) 3e2069c
- remove unnecessary catch {} 75ed927
- New Crowdin translations (#43) bdcb83f
- update docs bba83d8
- trigger docs rendering 254cc94
- fix whitespace 80c51b4
- Add reStructuredText documentation (#40) c534d1d
- use constants in acceptance tests (PHP 7.0 and introduction-package 3 compatible) 617fc9c
- ignore .lock 43b479c
- use constants in acceptance tests f948dfc
- update docs (type translation) 58bb0ba
- update docs 6b131b1
- update selenium, add selenium-hub and prepare firefox 916701c
- fix acceptance-tests.yml 66a5889
- use reusable github-action-setup-ddev c7e76c9
- oops cb7096b

# 2.3.0

## MISC

- fix cgl c246b61
- closes #35 add API call onScriptLoaded() to register script onload callbacks. (#28) c55ee8f
- fix #37 DNT message is only rendered once d022c51
- add API to get all consented groups (3) 9d3c398
- add API to get all consented groups (2) d3a3690
- add API to get all consented groups 17b11a0
- #31 add configuration of CookieConsent to base TypoScript 1bd54eb

# 2.2.3

## MISC

- fix #31 split TypoScript into Base + Examples 449049f
- fix #33 sort group.trackingsObjects by key and prevent JSON-object-cast e6dae65
- remove outdated reference to test extension fa2cf1f
- run composer-normalize 57f32e4
- add composer-normalize 4457db0
- speed-up startup ff1b61f
- depend on the test setup (--dev) dc839cc
- docs b19231b
- fix #32 make examples CSP-ready dcbbed9
- copy all nodes from injects() - get rid of container 2651790
- configure bootstrap-package to not use inline WebFontLoader (breaks CSP) 41d8413
- remove dependencies from test extension 8f8fb64
- minify 4401c03
- include Content-Security-Policy in our test extensions & use our Crowdin Widget as test case e0e69df
- fix #28 s attributes not properly inserted 95ccb4d
- customize TypoScript in test extension 7cd65c3
- fix typo 1a0d155
- make JS more error-tolerant (here: arbitrary cookie values) 7df502d
- fix all test extensions being active 1df885a

# 2.2.0

## MISC

- give animations more time 409168f
- use PHP 7.3 locally ffa06de
- generalize URL for non-site package testing 718d666
- update README badges 56de0b0
- split Github actions into ‹CGL & unit› and ‹acceptance› tests. Use ddev with a patch to run acceptance tests in Github actions. ef44cc6
- align pre-commit with new composer {scripts} 04714de
- add composer typo3:flush command de4c6c2
- refactor composer {scripts} 0f5c552
- bump PHP version for TYPO3v10 f73d324
- fix bootstrap3-banner aa3d1ab
- use codeception to run acceptance tests 0313d3a
- manual 3-way merge to align translations (#25) c0bef29
- New translations locallang.xlf (French) (#20) 453cce9
- Revert "run coveralls only when secret is available" f5843e0
- run coveralls only when secret is available d5143d3
- New translations locallang.xlf (French) (#17) 9bdad89
- New Crowdin translations (#14) 083dccd
- New Crowdin translations (#11) b64f79d
- New Crowdin translations (#9) 2c95642
- remove unused .crowdin.yml 6141ccf
- Update Crowdin configuration file 9e319c5
- New Crowdin translations (#6) fc802c2
- add links 1270a32
- fix test badge 2848a18
- remove workflow dependency 9d0a210
- revert last idea 0fa6e8f
- run composer and coveralls only one in workflow a45385e
- add unit test badge 03f1e72
- use deprecated method to stay compatible with PHPUnit 6.5 1950d49
- run unit tests with PHP 7.2 + 7.3 69c3c32
- add code coverage checking 0b43503
- add composer 145cf66
- add docker test container 24358de
- add DataProcessor test 0108fbd
- use relative symlink to make it work host- and ddev-wise 50dbe04
- shorten local startup time 4657b4e
- add .gitconfig for local dev e466687
- remove .crowdin.yaml from export 2d6cf24

# 2.1.14

## MISC

- remove  from templates (small is really small...) addbc59
- fix xdebug (again...) 3d659dd
- fix docker-env e9c071d
- ignore yarn error logs bd544e3
- add notice about CDNs 675704e
- document defaults 578b423
- document showOnce() b78a527
- format docs 8d9ee59
- document minify b4a3d5a
- explain extensing types b2677d8
- add notice about weird versioning a5f7c7a
- New translations locallang.xlf (Romanian) ff8cc5f
- New translations locallang.xlf (Spanish) 5a4d06f
- New translations locallang.xlf (Romanian) 41add10
- New translations locallang.xlf (French) 73338a9
- New translations locallang.xlf (Romanian) 5a318b1
- New translations locallang.xlf (German) a5afdbe
- New translations locallang.xlf (Danish) 7c59cfd
- New translations locallang.xlf (Danish) 7b54170
- format documentation ab04282
- add TER link c4d7c0c
- remove title branding... 7eb84e1
- more documentation 1fc6af0
- more documentation 1c4e8a3

# 2.1.8

## MISC

- showcase theme customizing aa94202
- describe theme customizing 99ba259
- change description 493d648

# 2.1.5

## MISC

- adapt release script 56412c2
- add dependency to ext_emconf.php 505646e

# 2.1.2

## MISC

- README (2) 0ce5094
- README fb0bcf0
- use SEL for Typo3v9+ bc69c6e
- make minify configurable a1a2ec3
- New translations locallang.xlf (Vietnamese) 444c28b
- New translations locallang.xlf (Catalan) 6588ccf
- New translations locallang.xlf (Chinese Simplified) ce74d2d
- New translations locallang.xlf (Czech) 518c25a
- New translations locallang.xlf (Danish) 4dbfd16
- New translations locallang.xlf (Dutch) f9a016f
- New translations locallang.xlf (Finnish) 3695641
- New translations locallang.xlf (French) 875cbd6
- New translations locallang.xlf (German) 0fc76fb
- New translations locallang.xlf (Greek) c82ff54
- New translations locallang.xlf (Hebrew) b5d3e1c
- New translations locallang.xlf (Hungarian) efd5ee9
- New translations locallang.xlf (Arabic) 34a4298
- New translations locallang.xlf (Italian) b580adf
- New translations locallang.xlf (Korean) 10646e1
- New translations locallang.xlf (Norwegian) 9d881b8
- New translations locallang.xlf (Polish) 1a9d93d
- New translations locallang.xlf (Portuguese) 0ac80cb
- New translations locallang.xlf (Romanian) f87053c
- New translations locallang.xlf (Russian) 3bc1ed9
- New translations locallang.xlf (Serbian (Cyrillic)) 84f71ec
- New translations locallang.xlf (Spanish) fd38acc
- New translations locallang.xlf (Swedish) fd7e105
- New translations locallang.xlf (Turkish) 9b3b8c7
- New translations locallang.xlf (Ukrainian) 775a6ee
- New translations locallang.xlf (Japanese) c289424
- New translations locallang.xlf (Afrikaans) f10be1f
- New translations locallang.xlf (Vietnamese) 7d7d051
- New translations locallang.xlf (Catalan) ca8c80c
- New translations locallang.xlf (Chinese Simplified) 7ca2334
- New translations locallang.xlf (Czech) 55ee6b4
- New translations locallang.xlf (Danish) 07b15ef
- New translations locallang.xlf (Dutch) 4a92e7a
- New translations locallang.xlf (Finnish) 19a295e
- New translations locallang.xlf (French) a56e054
- New translations locallang.xlf (Greek) 7213773
- New translations locallang.xlf (Hebrew) 63b9b67
- New translations locallang.xlf (Hungarian) 69deef3
- New translations locallang.xlf (Arabic) 155e763
- New translations locallang.xlf (Italian) 9cf860d
- New translations locallang.xlf (Korean) abd9a51
- New translations locallang.xlf (Norwegian) 911fd2c
- New translations locallang.xlf (Polish) 9fef8cc
- New translations locallang.xlf (Portuguese) 004d836
- New translations locallang.xlf (Romanian) 75795da
- New translations locallang.xlf (Russian) b74481c
- New translations locallang.xlf (Serbian (Cyrillic)) 04cec38
- New translations locallang.xlf (Spanish) 864f251
- New translations locallang.xlf (Swedish) bca402a
- New translations locallang.xlf (Turkish) cd98d13
- New translations locallang.xlf (Ukrainian) 1d15275
- New translations locallang.xlf (Japanese) a6517f7
- New translations locallang.xlf (Afrikaans) bfe0388
- New translations locallang.xlf (Chinese Simplified) f17c75b
- New translations locallang.xlf (Chinese Traditional) 379a483
- New translations locallang.xlf (Portuguese) 0950247
- New translations locallang.xlf (Portuguese, Brazilian) 9703834
- cleanup 1cbe840

# 2.0.10

## MISC

- compile JS 3465b0d
- edit example - finally had the idea how to fix the translation-via-TypoScript issue. 4dedd42
- add example e5b2132
- use DataProcessor to enable settings overwritability 9b51e4e
- add release process to composer 6ca6741
- compile JS 1958bd2
- add minify config 28490d9
- add screenshots 01572ed
- add Matomo cookie descriptions 4e113ce
- Update Crowdin configuration file 8571085
- Merge remote-tracking branch 'origin/l10n_master' f8b9f27
- New translations locallang.xlf (German) b5eb839
- add more bs4-accordion fixes 8ef784b
- add group description 4051133
- New translations locallang.xlf (German) 81a28f8
- New translations locallang.xlf (Vietnamese) e7e7ce4
- New translations locallang.xlf (Afrikaans) 4c7eee1
- New translations locallang.xlf (Arabic) 922fc6c
- New translations locallang.xlf (Catalan) 40dd0f9
- New translations locallang.xlf (Chinese Simplified) f0562d7
- New translations locallang.xlf (Chinese Traditional) 377fd99
- New translations locallang.xlf (Czech) 8effa0b
- New translations locallang.xlf (Danish) c90afda
- New translations locallang.xlf (Dutch) ddc00a2
- New translations locallang.xlf (Finnish) e5b3b20
- New translations locallang.xlf (Greek) 460a55d
- New translations locallang.xlf (Hebrew) e09158a
- New translations locallang.xlf (Hungarian) ada5df8
- New translations locallang.xlf (Italian) a59d684
- New translations locallang.xlf (Korean) 37e7978
- New translations locallang.xlf (Norwegian) c35197f
- New translations locallang.xlf (Polish) 27e2ad1
- New translations locallang.xlf (Portuguese) 2545780
- New translations locallang.xlf (Portuguese, Brazilian) d46950b
- New translations locallang.xlf (Romanian) 22d3384
- New translations locallang.xlf (Russian) f067f35
- New translations locallang.xlf (Serbian (Cyrillic)) f99b987
- New translations locallang.xlf (Spanish) fbb73b3
- New translations locallang.xlf (Swedish) 8cdf2f6
- New translations locallang.xlf (Turkish) 62eeb61
- New translations locallang.xlf (Ukrainian) 44fb77f
- New translations locallang.xlf (Japanese) 331f6c2
- New translations locallang.xlf (French) 9bfe65b
- gear bootstrap4-modal towards conservative example 9bbb3e8
- dynamify bootstrap3-modal 3fa10ad
- add TypoScript docs and starter kit, rename, clean up 2939206
- add TODO 02e1b92
- add test extensions for each theme and crowdin link; enable bootstrap4-modal by default 4266153
- dynamify bootstrap3-banner b9b8ea0
- use partial for table rows 1844e5f
- factor common variables out of template 5881ab0
- add some more translations 0deebbd
- toggle tags instead of ::after (make it translatable) 8028a4a
- beautify bootstrap4-modal 02632f5
- fix HTML reflow, refactor 0ea02dc
- New translations locallang.xlf (Chinese Simplified) 896402f
- New translations locallang.xlf (Chinese Traditional) 16da56a
- New translations locallang.xlf (Portuguese) aa67f86
- New translations locallang.xlf (Portuguese, Brazilian) a9dea96
- New translations locallang.xlf (Vietnamese) fb97146
- New translations locallang.xlf (Afrikaans) 5d3bd39
- New translations locallang.xlf (Arabic) dbe9ace
- New translations locallang.xlf (Catalan) f5102c8
- New translations locallang.xlf (Chinese Simplified) aa9ecd3
- New translations locallang.xlf (Chinese Traditional) cdbecc7
- New translations locallang.xlf (Czech) 7dac91e
- New translations locallang.xlf (Danish) 880578f
- New translations locallang.xlf (Dutch) 79e1f27
- New translations locallang.xlf (Finnish) cbae3de
- New translations locallang.xlf (Greek) 232cd87
- New translations locallang.xlf (Hebrew) 3dc6fb1
- New translations locallang.xlf (Hungarian) 49586f3
- New translations locallang.xlf (Italian) 40030c2
- New translations locallang.xlf (Korean) 760ef53
- New translations locallang.xlf (Norwegian) 80ae153
- New translations locallang.xlf (Polish) a5c338a
- New translations locallang.xlf (Portuguese) ef83405
- New translations locallang.xlf (Portuguese, Brazilian) 8152b09
- New translations locallang.xlf (Romanian) a502727
- New translations locallang.xlf (Russian) 95be69f
- New translations locallang.xlf (Serbian (Cyrillic)) a7f7f0e
- New translations locallang.xlf (Spanish) 5b5ba4e
- New translations locallang.xlf (Swedish) 8cff360
- New translations locallang.xlf (Turkish) 0c4ff9f
- New translations locallang.xlf (Ukrainian) 502ec19
- New translations locallang.xlf (Japanese) 4ea8744
- New translations locallang.xlf (French) 25778ee
- New translations locallang.xlf (Vietnamese) 34c2140
- New translations locallang.xlf (German) fb3844e
- New translations locallang.xlf (Afrikaans) e0c51f5
- New translations locallang.xlf (Arabic) 547314a
- New translations locallang.xlf (Catalan) 97704d6
- New translations locallang.xlf (Chinese Simplified) 209c8e3
- New translations locallang.xlf (Chinese Traditional) 90d3506
- New translations locallang.xlf (Czech) 14b6fda
- New translations locallang.xlf (Danish) 165d898
- New translations locallang.xlf (Dutch) 636323b
- New translations locallang.xlf (Finnish) dda8e0f
- New translations locallang.xlf (Greek) def394c
- New translations locallang.xlf (Hebrew) 1b76e67
- New translations locallang.xlf (Hungarian) 2ab1f61
- New translations locallang.xlf (Italian) 1cde8f0
- New translations locallang.xlf (Korean) 6f49ef0
- New translations locallang.xlf (Norwegian) 4f5a106
- New translations locallang.xlf (Polish) 8fc9cbf
- New translations locallang.xlf (Portuguese) c9476a1
- New translations locallang.xlf (Portuguese, Brazilian) 4ba770b
- New translations locallang.xlf (Romanian) 1f3b2a3
- New translations locallang.xlf (Russian) 212954c
- New translations locallang.xlf (Serbian (Cyrillic)) aba6192
- New translations locallang.xlf (Spanish) 6063b57
- New translations locallang.xlf (Swedish) 8cfab84
- New translations locallang.xlf (Turkish) f7610c9
- New translations locallang.xlf (Ukrainian) 1af07b5
- New translations locallang.xlf (Japanese) 923ad58
- New translations locallang.xlf (German) 1ecb789
- New translations locallang.xlf (French) 6bee25b
- New translations locallang.xlf (English) 8215469
- fix typo e2368d9
- beautify xlf 847933e
- New translations locallang.xlf (German) 5e241a7
- New translations locallang.xlf (French) d2f8e74
- New translations locallang.xlf (English) e7e3f88
- add resname to xlf a31af0a
- New translations locallang.xlf (German) a69118e
- New translations locallang.xlf (French) f119560
- New translations locallang.xlf (English) 6d82f0e
- beautify xlf 1ec129c
- New translations locallang.xlf (German) 38ab661
- New translations locallang.xlf (French) c8f0c8c
- New translations locallang.xlf (English) 1c5b1b7
- fix typo f65605c
- New translations locallang.xlf (German) 33fec6d
- New translations locallang.xlf (French) a695bc3
- New translations locallang.xlf (English) 5e10f6c
- translate source (EN) 7b28fc2
- add new ddev command ‹launch› d2a90d7
- remove explicitly disabled DNT functionality abf2e9b
- New translations locallang.xlf (German) a52128f
- New translations locallang.xlf (German) 8b4a25c
- add TODO b2517f8
- add crowdin widget and badge 86ec10b
- New translations locallang.xlf (German) 5a0552c
- New translations locallang.xlf (French) 20d3c8d
- New translations locallang.xlf (English) 594e37d
- test crowdin - changing source language string 4a74820
- New translations locallang.xlf (German) 8930c36
- New translations locallang.xlf (French) 249e9f5
- Update Crowdin configuration file 16e51bf
- add TODO e9b495d

# 2.0.5

## MISC

- use bootstrap4-modal as default theme b78fdd1
- mention w.i.p. in README 6d33124
- remove debug da9ba6d
- inject HTML, take special care of  67fbf07
- add TODOs 71cb2cc
- fix exportToHtml abeaacd
- add translations (w.i.p.) ee33a35
- adapt to new TypoScript structure 0e5ba77
- export some settings to HTML 5bc4697
- refactor TypoScript, add TypoScript examples 58577b7
- use partial across default themes b9df4e4
- add rootPaths sequence resourceBasePath › default themes › default a8c7985
- set bootstrap 4 as default 3f41550

# 2.0.2-dev

## MISC

- use release:create d3fb2a2
- add release:publish script f208fb5
- enable bootstrap_package compatiblity e94aece
- config via TypoScript; translation 26233b3
- modernize TypoScript include f3a430d
- style card-body e5e48b0
- use bootstrap4 in master/v10 7975b88
- amend TODO c2305df
- amend TODO e93cedf
- cleanup c6913c7

# 1.3.4

## MISC

- add TODO section 19d353c
- add extension-helper 95471be
- use composer update e591a94
- Bootstrap 4 theme b37e9fb
- alias branches to 2.x-dev 46c105f
- remove private Satis e89af7b
- fix .md syntax 880b003
- fix homepage 9cadb56
- remove private Satis c22b03e
- document typo3-console (not!) usage 8b657da
- add cookieman test config 77591eb
- adapt to missing Configuration/TypoScript 5e69179
- fix extension nomenclature 605d1c6
- reorder extension installation 8e8ac1c
- export data from ddev dump-db into writable fs e8a571b
- clean up ddev config 4ac1910
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

