import { mount } from "@vue/test-utils";
import VueSample from "../src/components/VueSample";

describe("VueSample.vue", () => {
  test("is a Vue instance", () => {
    const propsData = {
      info: { craftVersion: "1.0", environment: "dev" }
    };
    const wrapper = mount(VueSample, { propsData });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });
});
