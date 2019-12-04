/** global: cookieman */

// using cookieman API
console.log('cookieman_test: using onScriptLoaded() API')
cookieman.onScriptLoaded(
    'Crowdin',
    0,
    function (trackingObjectKey, scriptId) {
        console.log('cookieman_test: callback onScriptLoaded() API', trackingObjectKey, scriptId)
    }
)
cookieman.onScriptLoaded(
    'Crowdin',
    1,
    function (trackingObjectKey, scriptId) {
        console.log('cookieman_test: callback onScriptLoaded() API', trackingObjectKey, scriptId)
    }
)

// subscribing to our CustomEvent "scriptLoaded" directly
// console.log('cookieman_test: subscribing to "scriptLoaded" directly')
// cookieman.eventsEl.addEventListener(
//     'scriptLoaded',
//     function (ev) {
//         console.log('cookieman_test: scripLoaded event caught: ', ev, ev.detail)
//     }
// )

setTimeout(
    function () {
        console.log('cookieman_test: using onScriptLoaded() API (after 2s)')
        cookieman.onScriptLoaded(
            'Crowdin',
            1,
            function (trackingObjectKey, scriptId) {
                console.log('cookieman_test: callback onScriptLoaded() API (after 2s)', trackingObjectKey, scriptId)
            }
        )
    },
    2000
)
