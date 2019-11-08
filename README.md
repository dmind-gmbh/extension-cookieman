# Cookieman

##  How it works

It includes the HTML for a cookie confirmation modal on every page.

It shows the modal when the cookie *CookieConsent* is not set yet. In the example templates it is not shown on the configured imprintPid and dataProtectionDeclarationPid (see TypoScript constants) - this is to follow the GDPR's expectation that those pages shall be easily and directly accessible and should not interfere with a cookie consent banner. 

It is recommended to include a snippet like that on your data protection page to allow your users to adjust their cookie preferences: 
<pre>
&lt;a href="" onclick="cookieman.show(); return false"&gt;
  Adjust your cookie preferences
&lt;/a&gt;
</pre>

It saves the user's choices as a comma-separated list of groups in the HTML cookie *CookieConsent*, e.g. "marketing,preferences".

Your tracking solutions shall then adhere to this setting by checking if their repective string (e.g. "marketing") is contained in the cookie *CookieConsent*. You should also pay respect to the "Do-not-track" setting of your users which is sent as HTTP-Header `DNT: 1` and accessible in JavaScript via `navigator.doNotTrack`. The example templates include a dynamic text block that show this browser setting.

This can be done in Google Tagmanager or by dynamically including &lt;script&gt;s with JavaScript.

<pre>
(function() {
    if (
      !(navigator.doNotTrack && navigator.doNotTrack === '1') 
      && cookieman.hasConsented('marketing')
    ) {
        // if you need a &lt;script src=""&gt; tag
        var _tagSrc = document.createElement('script')
        _tagSrc.src = 'https://mytrackingthingie.com/anal.js'
        document.head.appendChild(_tagSrc)

        // if you need &lt;script&gt; tag content
        var _tagContent = document.createElement('script')
        _tagContent.textContent = 'alert("some content")'
        document.head.appendChild(_tagContent)
    }
})()
</pre>

You could of course let your server handle that, too (in PHP, TypoScript, e.g.) but this is IMHO overkill and should only be necessary for edge cases.

## Requirements

* If you reimplement your own theme, it has no requirements at all
* for the example HTML templates
  * Bootstrap 3 CSS
  * Bootstrap 3 JavaScript for *collapse*s and *modal*s
  * jQuery

## Installation

### composer
Get it from packagist https://packagist.org/packages/dmind/cookieman

Run <code>composer req dmind/cookieman</code>

## Integration

Include the TypoScript and adjust the constants.

It should get loaded automatically on every (except imprint and data protection declaration) page. If it does not, check for errors in a JavaScript console when calling `cookieman.show()` manually.

### Create a new theme
Copy the EXT:cookieman/Resources/ folder to your site package extension and set the `plugin.tx_cookieman.settings.resourcesBasePath` TypoScript constant. Choose a theme name, set it in the constant `plugin.tx_cookieman.settings.theme` and rename the example folders (e.g. bootstrap3-banner) to your name.

Adapt the HTML/CSS/JS as needed. These elements control the functionality:
* <code>&lt;\* data-cookieman-save&gt;</code> - save and close
* <code>&lt;\* data-cookieman-accept-all&gt;</code> - accept all
* <code>&lt;form data-cookieman-form&gt;</code> - the form that contains all checkboxes
* change the checkboxes' <code>name="..."</code> to a value that you expect to find in the CookieConsent when the user consented (in the examples only one group called "marketing" is included)

If you are working a non-Bootstrap environment, you will have to reimplement the methods cookieman.show() and cookieman.hide() (see the example code in `JavaScript/cookieman-theme.js`).

## API

### JavaScript

cookieman.js exposes these methods:

#### *cookieman.showOnce()*: void

> Shows the confirmation modal only when the user preferences in the cookie *CookieConsent* are not yet present. 

#### *cookieman.show()*: void

> Shows the confirmation modal. You can call that from anywhere you need it (e.g. with a link from your data protection declaration page). 
> <pre>
> &lt;a href="" onclick="cookieman.show(); return false"&gt;
>   Cookie settings
> &lt;/a&gt;
> </pre>

#### *cookieman.hide()*: void

> Hides the confirmation modal. 

#### *cookieman.hasConsented(selection)*: Boolean

> Returns true if the user has consented to the given selection, else false. A selection is any name of a checkbox in the popup, e.g. 'marketing'
 
Cookieman also includes the (1kB) cookie library [JavaScript Cookie](https://github.com/js-cookie/js-cookie) that also exposes its API and makes it easier to work with cookies.

# TODO
## Document
### ddev install-git-hooks
