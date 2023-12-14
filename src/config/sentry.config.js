/**
 * Vue Sentry configuration
 */
const sentryConfig = {
  debug: false,
  dsn: process.env.VUE_APP_SENTRY_DSN,
  environment: process.env.NODE_ENV,
  ignoreErrors: [
    // Apollo Client Local Storage cache limit
    "QuotaExceededError",
    "Onvoldoende opslagruimte beschikbaar om deze bewerking te voltooien.",
    "Failed to execute 'setItem' on 'Storage': Setting the value of 'apollo-cache-persist' exceeded the quota.",
    "The quota has been exceeded.",
    // Misc. temp: these errors did get registered and should be solved. Remove the ignore rules after a fix is deployed.

    // Random plugins/extensions
    "top.GLOBALS",
    // See: http://blog.errorception.com/2012/03/tale-of-unfindable-js-error.html
    "originalCreateNotification",
    "canvas.contentDocument",
    "MyApp_RemoveAllHighlights",
    "http://tt.epicplay.com",
    "Can't find variable: ZiteReader",
    "jigsaw is not defined",
    "ComboSearch is not defined",
    "http://loading.retry.widdit.com/",
    "atomicFindClose",
    // Facebook borked
    "fb_xd_fragment",
    // ISP "optimizing" proxy - `Cache-Control: no-transform` seems to reduce this. (thanks @acdha)
    // See http://stackoverflow.com/questions/4113268/how-to-stop-javascript-injection-from-vodafone-proxy
    "bmi_SafeAddOnload",
    "EBCallBackMessageReceived",
    // See http://toolbar.conduit.com/Developer/HtmlAndGadget/Methods/JSInjection.aspx
    "conduitPage",
    // Generic error code from errors outside the security sandbox
    "Script error.",
    // See http://stackoverflow.com/questions/13140857/what-are-miscellaneous-bindings-and-why-are-they-giving-me-a-port-error
    "miscellaneous_bindings"
  ],
  ignoreUrls: [
    // Facebook flakiness
    /graph\.facebook\.com/i,
    // Facebook blocked
    /connect\.facebook\.net\/en_US\/all\.js/i,
    // Woopra flakiness
    /eatdifferent\.com\.woopra-ns\.com/i,
    /static\.woopra\.com\/js\/woopra\.js/i,
    // Chrome extensions
    /extensions\//i,
    /^chrome:\/\//i,
    // Ignore Google flakiness
    /\/(gtm|ga|analytics)\.js/i,
    // Other plugins
    /127\.0\.0\.1:4001\/isrunning/i, // Cacaoweb
    /webappstoolbarba\.texthelp\.com\//i,
    /metrics\.itunes\.apple\.com\.edgesuite\.net\//i
  ]
};

export default sentryConfig;
