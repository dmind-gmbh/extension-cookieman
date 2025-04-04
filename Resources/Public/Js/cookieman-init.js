// show consent popup (once) if we find a data-cookieman-showonce="1" tag somewhere (used e.g. to suppress on specific
// pages)
/** global: cookieman */

if (null !== document.querySelector('[data-cookieman-showonce="1"]')) {
    // get out out of the main rendering thread
    setTimeout(
        cookieman.showOnce,
        100
    )
}
