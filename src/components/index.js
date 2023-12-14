import Vue from "vue";
import kebabCase from "lodash/kebabCase";
// eslint-disable-next-line import/no-namespace
import * as Sentry from "@sentry/vue";
import sentryConfig from "../config/sentry.config";

Vue.config.productionTip = false;

if (process.env.VUE_APP_SENTRY_ENABLED !== "false") {
  Sentry.init({ ...sentryConfig });
}

const requireComponent = require.context("./", true, /[A-Z]\w+\.(vue)$/);
const selectors = [];
requireComponent.keys().forEach(filename => {
  // Register components
  const component = requireComponent(filename).default;
  component.name = component.name || filename.match("([^/]+).vue$")[1];
  component.delimiters = component.delimiters || ["${", "}"];
  const elementName = kebabCase(component.name);
  if (elementName.indexOf("-") === -1) {
    console.warn(`element name must contain a dash, rename "${elementName}"`); // eslint-disable-line no-console
    return;
  }
  Vue.component(elementName, component);
  selectors.push(elementName);
});
const detectedElements = [];
/* eslint-disable no-unused-vars */
for (const selector of selectors) {
  detectedElements.push(...document.querySelectorAll(selector));
}
// Mount components

for (const selectorX of selectors) {
  for (const el of document.querySelectorAll(selectorX)) {
    let parent = el.parentNode;
    let mount = true;
    while (parent) {
      if (detectedElements.indexOf(parent) !== -1) {
        mount = false; // this element will be mounted as subcomponent
        break;
      }
      parent = parent.parentNode;
    }
    if (mount) {
      new Vue({ el }); // eslint-disable-line no-new
    }
  }
}
