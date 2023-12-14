<template>
  <section class="c-hero-slider" >
    <!-- Nav -->
    <div class="c-hero-slider__navigation">
      <button
        class="c-hero-slider__button c-hero-slider__button--left"
        @click="changeIndex(currentIndex - 1)"
      ></button>

      <button
        class="c-hero-slider__button c-hero-slider__button--right"
        @click="changeIndex(currentIndex + 1)"
      ></button>
    </div>
    <!-- Image Slider -->
    <div class="c-hero-slider__wrap">
      <div
        v-for="index in slides"
        :key="`slide--${index}`"
        class="c-hero-slider__slide"
        :class="getClass(index, 'c-hero-slider__slide--')"
      >
        <slot :name="`slide--${index}`"></slot>
      </div>
    </div>
    <div class="c-hero-slider__content-wrap">
      <div class="c-hero-slider__content-container">
        <!-- Content Slider -->
        <div
          v-for="index in slides"
          :key="`content--${index}`"
          class="c-hero-slider__content"
          :class="getClass(index, 'c-hero-slider__content--')"
        >
          <slot :name="`content--${index}`"></slot>
        </div>
        <!-- Progress bar -->
        <div class="c-hero-slider__content-bar">
          <div class="progress" :style="progressStyling"></div>
        </div>
      </div>
    </div>
    <div class="c-hero-slider__bullets">
      <button
        v-for="index in amount"
        :key="`bullet--${index}`"
        class="c-hero-slider__bullet"
        :class="{
          'c-hero-slider__bullet--active':
            (currentIndex % amount) + 1 === index,
        }"
        @click="bulletChangeIndex(index)"
      ></button>
    </div>
  </section>
</template>

<script>
export default {
  name: "SlideCarouselHero",
  props: {
    slides: {
      type: Number,
      required: true,
    },
    amount: {
      type: Number,
      required: true,
    },
  },
  data: () => ({
    currentIndex: 1,
    animationTime: 500,
    moving: false,
    timeBetween: 10000,
    timer: null,
    touchStart: null,
  }),
  computed: {
    progressStyling() {
      if (this.moving) {
        return { width: 0, transition: `width ${this.animationTime}ms linear` };
      }
      return {
        width: "100%",
        transition: `width ${this.timeBetween}ms linear`,
      };
    },
  },
  mounted() {
    this.changeIndex(1);
    this.$el.addEventListener('touchstart', this.handleTouchStart, false);
    this.$el.addEventListener('touchend', this.handleTouchEnd, false);
  },
  destroyed(){
    this.$el.removeEventListener('touchstart', this.handleTouchStart);
    this.$el.removeEventListener('touchend', this.handleTouchEnd);
  },
  methods: {
    handleTouchStart(e){
      this.touchStart = e.changedTouches[0];
    },
    handleTouchEnd(e){
      let start = this.touchStart;
      let end = e.changedTouches[0];
      this.touchStart = null;
      let difference = {x: start.clientX - end.clientX, y: start.clientY - end.clientY}
      
      // Check for swipes to be atleast somewhat right or left instead of up or down (cut off points is 45 degrees)
      if (Math.abs(difference.x) + Math.abs(difference.y) > 100 & Math.abs(difference.x) > Math.abs(difference.y)){
        if (difference.x > 0){
          this.changeIndex(this.currentIndex + 1)
        } else {
          this.changeIndex(this.currentIndex - 1)
        }
      }
    },
    bulletChangeIndex(index) {
      // Calculates how much to move the index to the right.
      const currentBullet = (this.currentIndex % this.amount) + 1;
      const moveUpCount = -(currentBullet - index + this.amount) % this.amount;
      this.changeIndex(this.currentIndex + moveUpCount);
    },
    changeIndex(newIndex) {
      // Ignores event if it's already moving.
      if (!this.moving) {
        this.moving = true;

        // Never alows the index to be 0 or lower (breaks);
        if (newIndex < 1) {
          newIndex += this.slides;
        }

        // Change the index which changes the results from "getClass" to the corrert classes (current, next,  ...etc);
        this.currentIndex = newIndex;

        // Allows another event if the animation is done.
        const _this = this;
        setTimeout(() => {
          _this.moving = false;
        }, this.animationTime);
      }

      // Clears old ChangeIndex event.
      if (this.timer) {
        clearTimeout(this.timer);
      }

      // Automatically fires another ChangeIndex event.
      this.timer = setTimeout(() => {
        this.changeIndex(this.currentIndex + 1);
      }, this.timeBetween + this.animationTime);
    },
    getClass(index, baseClass) {
      switch (this.currentIndex % this.slides) {
        case (index + this.slides) % this.slides:
          return baseClass + "current";
        case (index + this.slides - 1) % this.slides:
          return baseClass + "next";
        case (index + this.slides - 2) % this.slides:
          return baseClass + "next-next";
        case (index + this.slides - 3) % this.slides:
          return baseClass + "next-next-next";
        case (index + this.slides + 1) % this.slides:
          return baseClass + "prev";
        default:
          return baseClass + "hidden";
      }
    },
  },
};
</script>
