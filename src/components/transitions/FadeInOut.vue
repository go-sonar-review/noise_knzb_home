<template>
  <Transition :css="false" @enter="enter" @leave="leave">
    <slot />
  </Transition>
</template>

<script>
  import AnimationMixin from "../mixins/transitions";
  import effects from "../../animation/effects";

  export default {
    name: "FadeInOut",
    mixins: [AnimationMixin],
    data() {
      return {
        effect: effects.fade
      };
    }
  };
</script>
