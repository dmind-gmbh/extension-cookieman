// show consent popup (once) if we find a data-cookieman-showonce="1" tag somewhere (used e.g. to suppress on specific
// pages)
/** global: cookieman */

if (null !== document.querySelector('[data-cookieman-showonce="1"]')) {
    // wait a bit in order to a) be executed out of the main rendering thread b) give user first impression of page
    setTimeout(
        cookieman.showOnce,
        2000
    )
}
