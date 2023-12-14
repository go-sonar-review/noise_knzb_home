<template>
  <section :ref="`slider`" class="glide" :class="`glide--${block}`">
    <!-- Controls -->
    <div
      v-if="settings?.controls"
      class="glide__controls"
      data-glide-el="controls"
    >
      <button
        class="glide__arrow glide__arrow--prev"
        data-glide-dir="<"
      ></button>
      <button
        class="glide__arrow glide__arrow--next"
        data-glide-dir=">"
      ></button>
    </div>

    <!-- Slided -->
    <div class="glide__track" data-glide-el="track">
      <ul class="glide__slides">
        <div
          v-for="index in slides"
          :key="`slide--${index}`"
          class="glide__slide"
        >
          <slot :name="`slide--${index}`"></slot>
        </div>
      </ul>
    </div>

    <!-- Timeline -->
    <div
      v-if="settings?.timeline && options.autoplay"
      class="glide__timeline-container"
    >
      <span
        v-for="(s, index) in slides"
        :key="`timeline--${index - 1}`"
        class="glide__timeline"
        :class="{ 'glide__timeline--active': currentIndex === index }"
        :style="{ 'animation-duration': `${options.autoplay}ms` }"
      ></span>
    </div>

    <!-- Bullets -->
    <div
      v-if="settings?.bullets"
      class="glide__bullets"
      data-glide-el="controls[nav]"
    >
      <button
        v-for="index in slides"
        :key="`bullet--${index - 1}`"
        class="glide__bullet"
        :data-glide-dir="`=${index - 1}`"
      ></button>
    </div>
  </section>
</template>

<script>
import Glide from "@glidejs/glide";
import debounce from "lodash/debounce";

export default {
  name: "SlideCarousel",
  props: {
    block: {
      type: String,
      default: "default",
    },
    settings: {
      type: Object,
      default: () => {
        return {};
      },
    },
    slides: {
      type: Number,
      required: true,
    },
    hasNoPeekMobile: {
      type: Boolean,
      default: false,
    },
  },
  data: () => ({
    slider: null,
    options: {},
    hasMinimumSlideCount: false,
  }),
  computed: {
    currentIndex() {
      return this.slider && this.slider.index ? this.slider.index : 0;
    },
  },
  beforeMount() {
    const {
      type,
      drag,
      gap,
      focusAt,
      autoplay,
      peek,
      perView,
      breakpoints,
      bound,
      swipeThreshold,
      dragThreshold,
    } = this.settings;
    this.options = {
      type: type ?? "carousel",
      drag: drag ?? true,
      focusAt: focusAt ?? "center",
      autoplay: autoplay ?? false,
      peek: peek ?? 0,
      gap: gap ?? 10,
      perView: perView ?? 6,
      breakpoints: breakpoints ?? {},
      bound: bound ?? true,
      swipeThreshold: swipeThreshold ?? 10,
      dragThreshold: dragThreshold ?? 10,
      animationTimingFunc: "cubic-bezier(0.5, 1, 0.89, 1)",
      animationDuration: 750,
    };

    if (this.hasNoPeekMobile && window.innerWidth < 768) {
      this.options.peek = 0;
    }
  },
  mounted() {
    this.slider = new Glide(this.$refs.slider, this.options);
    this.slider.mount();
  },
  created() {
    window.addEventListener("resize", debounce(this.resize, 250));
  },
  beforeDestroy() {
    window.removeEventListener("resize", debounce(this.resize, 250));
  },
  methods:{
    resize(){
      this.slider.update()
    }
  }
};
</script>
