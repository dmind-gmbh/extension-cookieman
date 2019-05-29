# Cookieman

##  How it works

It includes the HTML for a cookie confirmation modal on every page.

It shows the modal when the cookie *CookieConsent* is not set yet. 

It saves user's choices as a comma-separated list in the HTML cookie *CookieConsent*, e.g. "marketing,preferences".

All cookie groups are defined in HTML.

Your tracking solutions shall then adhere to this setting by checking if their repective string (e.g. "marketing") is contained in the cookie *CookieConsent*. 

This can be done in Google Tagmanager or by dynamically including &lt;script&gt;s with JavaScript.

## Requirements

* the current HTML template is based on Bootstrap 3
* it uses Bootstrap 3 JavaScript for *collapse*s and *modal*s
* the CSS uses the Bootstrap "Glyphicons" font
* jQuery

### Using with another framework

Apart from adapting the HTML and CSS you should reimplement the opening and closing of modals in cookieman.js.

## Integration

Include the TypoScript settings and overwrite as needed. Constants are not used but you can use them if you think it is a cool idea.

It should get loaded on every page. If it does not pop up although expected check with `cookieman.show()` in a JavaScript console.

Adapt the HTML. Take care to keep these elements:
* *&lt;\* data-cookieman-save&gt;* - save and close
* *&lt;\* data-cookieman-accept-all&gt;* - accept all
* *&lt;form data-cookieman-form&gt;* - the form that contains all checkboxes
* change the checkboxes' name="" to a value that you expect to find in the CookieConsent when the user consented

## API

### JavaScript

cookieman.js exposes these methods:

#### *cookieman.showOnce()*

> Shows the confirmation modal only when the user preferences in the cookie *CookieConsent* are not yet present. 

#### *cookieman.show()*

> Shows the confirmation modal. You can call that with a link from your data protection declaration page. 
> <pre>
> &lt;a href="" onclick="cookieman.show(); return false"&gt;
>   Cookie settings
> &lt;/a&gt;
> </pre>

Cookieman also includes the (1kB) cookie library [JavaScript Cookie](https://github.com/js-cookie/js-cookie) that also exposes its API.