<template>
  <div class="sample">
    <h2>{{ msg }}</h2>
    <p>
      You're viewing the
      <code>&#060;HelloWorld&#062;</code> component!
    </p>

    <p>Passing in some data from twig:</p>
    <code>
      Craft Version: {{ info.craftVersion }} (passed in as prop)
      <br />
      Environment: {{ info.environment }} (passed in as prop) <br />DB Name:
      <slot></slot>(passed in through slot)
    </code>
  </div>
</template>

<script>
export default {
  name: "VueSample",
  props: {
    info: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      msg: "Sample Component"
    };
  }
};
</script>

<style lang="scss" scoped>
h2 {
  font-weight: normal;
}
</style>
