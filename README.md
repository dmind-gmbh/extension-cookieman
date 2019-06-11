# Cookieman

##  How it works

It includes the HTML for a cookie confirmation modal on every page.

It shows the modal when the cookie *CookieConsent* is not set yet. In the example templates it is not shown on the configured imprintPid and dataProtectionDeclarationPid (see TypoScript constants) - this is to follow the GDPR's expectation that those pages shall be easily and directly accessible and should not interfere with a cookie consent banner. 

It saves user's choices as a comma-separated list in the HTML cookie *CookieConsent*, e.g. "marketing,preferences".

All cookie groups are simply defined in HTML by setting the name= of a checkbox.

Your tracking solutions shall then adhere to this setting by checking if their repective string (e.g. "marketing") is contained in the cookie *CookieConsent*. 

This can be done in Google Tagmanager or by dynamically including &lt;script&gt;s with JavaScript.

This is an example using the convenience function hasConsented('...') provided by this extension:
<pre>
(function() {
    if (cookieman.hasConsented('marketing')) {
        var _ = document.createElement('script')
        _.src = 'https://mytrackingthingie.com/anal.js'
        document.head.appendChild(_)
    }
})()
</pre>

You could of course let your server handle that, too (in PHP, TypoScript, e.g.) but this is IMHO overkill.

## Requirements

* If you reimplement your own theme, it has no requirements at all
* the example HTML templates are based on Bootstrap 3 
* they use Bootstrap 3 JavaScript for *collapse*s and *modal*s
* jQuery

### Using with another framework

Apart from adapting the HTML and CSS you should reimplement the opening and closing of modals in cookieman.js.

## Integration

Include the TypoScript and adjust the constants.

It should get loaded on every page. If it does not pop up although expected check for errors in a JavaScript console with `cookieman.show()`.

Copy the Themes/ folder to your site package and adapt the HTML/CSS/JS. These elements control the functionality:
* *&lt;\* data-cookieman-save&gt;* - save and close
* *&lt;\* data-cookieman-accept-all&gt;* - accept all
* *&lt;form data-cookieman-form&gt;* - the form that contains all checkboxes
* change the checkboxes' name="" to a value that you expect to find in the CookieConsent when the user consented

Reimplement the methods cookieman.show() and cookieman.hide() (see examples).

## API

### JavaScript

cookieman.js exposes these methods:

#### *cookieman.showOnce()*

> Shows the confirmation modal only when the user preferences in the cookie *CookieConsent* are not yet present. 

#### *cookieman.show()*

> Shows the confirmation modal. You can call that from anywhere you need it (e.g. with a link from your data protection declaration page). 
> <pre>
> &lt;a href="" onclick="cookieman.show(); return false"&gt;
>   Cookie settings
> &lt;/a&gt;
> </pre>

#### *cookieman.hide()*

> Hides the confirmation modal. 

#### *cookieman.hasConsented(selection)*

> Returns true if the user has consented to the given selection, else false. A selection is any name of a checkbox in the popup, e.g. 'marketing'
 
Cookieman also includes the (1kB) cookie library [JavaScript Cookie](https://github.com/js-cookie/js-cookie) that also exposes its API.