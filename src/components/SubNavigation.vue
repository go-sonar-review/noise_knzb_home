<template>
  <Fragment>
    <!-- Adds an extra element to help detect when nav is sticky -->
    <div v-if="mode === 'sticky'" ref="stickyHelper" class="c-sub-navigation-sticky-helper"></div>

    <fade-in-out :config="backdropConfig">
      <div
        v-show="menuIsOpen && menuIsSticky"
        class="c-sub-navigation-backdrop"
        @click="toggleNavigation"
      ></div>
    </fade-in-out>

    <nav
      class="c-sub-navigation"
      :class="{
        'c-sub-navigation--sticky': mode === 'sticky',
        'c-sub-navigation--dropdown': mode === 'dropdown'
      }"
      :aria-label="menuName"
    >
      <div v-if="!screenMatches">
        <button
          class="c-sub-navigation__toggle"
          id="sub-navigation-toggle"
          aria-controls="sub-navigation-list"
          @click="toggleNavigation"
        >
          <img ref="menuIcon" :src="`${siteUrl}assets/icons/menu.svg`" alt="menu" />

          <span>{{ menuLabel }}</span>
        </button>

        <div class="c-sub-navigation__inner">
          <scale-in-out :config="scaleDividerConfig">
            <div v-if="menuIsOpen" class="c-sub-navigation__divider"></div>
          </scale-in-out>

          <!-- Detached list background so it can be animated with scale transformations -->
          <scale-in-out :config="scaleBackgroundConfig">
            <div
              v-show="menuIsOpen"
              class="c-sub-navigation__list-background"
              ref="background"
            ></div>
          </scale-in-out>

          <slide-group-in-out
            id="sub-navigation-list"
            class="c-sub-navigation__list"
            aria-labelledby="sub-navigation-toggle"
            ref="list"
            tag="ul"
            absolute
          >
            <slot v-if="menuIsOpen" name="list-items"></slot>
          </slide-group-in-out>
        </div>
      </div>

      <ul v-else ref="list" class="c-sub-navigation__list">
        <slot name="list-items"></slot>
      </ul>
    </nav>
  </Fragment>
</template>

<script>
  // eslint-disable-next-line import/no-extraneous-dependencies
  import { Fragment } from "vue-fragment";
  import ListMixin from "./mixins/list";
  import ScreensMixin from "./mixins/screens";

  import ScaleInOut from "./transitions/ScaleInOut.vue";
  import SlideGroupInOut from "./transitions/SlideGroupInOut.vue";

  import { fastTimings, fastestTimings } from "../animation/timings";
  import { move, rotate } from "../animation/effects";

  const END_DELAY_CONFIG = 250;

  export default {
    name: "SubNavigation",
    mixins: [ListMixin, ScreensMixin],
    components: {
      Fragment,
      ScaleInOut,
      SlideGroupInOut
    },
    data() {
      return {
        menuIsSticky: null,
        menuIsOpen: false,
        sectionAnimations: [],
        menuIconAnimation: null
      };
    },
    props: {
      menuName: {
        type: String,
        default: "Sub Navigation"
      },
      menuLabel: {
        type: String,
        default: "Menu"
      },
      /**
       * MODES : "static", "sticky", "dropdown"
       * Sticky : will stick to the parent container
       * an intersection observer keeps track if the nav state is sticky (can change while scrolling)
       * when the menu is openen while not sticky, other sections will move down to reserve space for the menu
       * when the menu is openen while sticky, the menu acts as an absoluted element so no space needs to be reserved
       * all animations only use transform and opacity to keep them performant
       */
      mode: {
        type: String,
        default: "static"
      },
      siteUrl: {
        type: String,
        required: true
      }
    },
    computed: {
      backdropConfig() {
        return {
          timings: { ...fastestTimings, endDelay: END_DELAY_CONFIG }
        };
      },
      scaleBackgroundConfig() {
        return {
          axis: "Y",
          transformOrigin: "top center",
          timings: {
            ...fastTimings,
            endDelay: END_DELAY_CONFIG
          }
        };
      },
      scaleDividerConfig() {
        return {
          axis: "X",
          transformOrigin: "top left",
          timings: fastTimings
        };
      }
    },
    mounted() {
      if (this.mode === "sticky") {
        this.initNavStickyObserver();
      }
    },
    updated() {
      this.getItems();
      this.setBackgroundHeight();

      if (this.mode === "sticky") {
        this.animateSections();
      }
    },
    watch: {
      screenMatches() {
        if (this.screenMatches) {
          this.menuIsOpen = null;
        }
      },
      menuIsOpen() {
        this.toggleMenuIconAnimation();
      },
      height() {
        this.setBackgroundHeight();
      }
    },
    methods: {
      initNavStickyObserver() {
        const observer = new IntersectionObserver(
          entries => (this.menuIsSticky = entries[0].intersectionRatio === 0),
          { threshold: [0, 1] }
        );

        observer.observe(this.$refs.stickyHelper);
      },
      toggleMenuIconAnimation() {
        if (this.menuIsOpen) {
          this.animateMenuIcon();
        } else {
          this.reverseMenuIconAnimation();
        }
      },
      animateMenuIcon() {
        if (!this.$refs.menuIcon) return null;

        const config = {
          axis: "Y",
          timings: fastTimings
        };

        const effect = rotate(this.$refs.menuIcon, config);

        this.menuIconAnimation = new Animation(effect);
        this.menuIconAnimation.play();
      },
      async reverseMenuIconAnimation() {
        if (!this.$refs.menuIcon || !this.menuIconAnimation) return null;

        await this.menuIconAnimation.finished;

        this.menuIconAnimation.reverse();
      },
      animateSections() {
        this.sections = document.querySelectorAll(".l-section, .c-footer, .c-partner-slider");

        if (!this.sections.length) return null;

        const config = {
          offset: this.height,
          timings: {
            ...fastTimings,
            endDelay: END_DELAY_CONFIG
          }
        };

        if (!this.menuIsSticky && this.menuIsOpen && !this.sectionsHaveMoved) {
          this.moveSectionPositions(config);
          this.sectionsHaveMoved = true;
        } else if (!this.menuIsOpen && this.sectionsHaveMoved) {
          this.reverseSectionPositions();
          this.sectionsHaveMoved = false;
        }
      },
      moveSectionPositions(config) {
        this.sections.forEach((section, index) => {
          const effect = move(section, config);

          this.sectionAnimations[index] = new Animation(effect);
          this.sectionAnimations[index].play();
        });
      },
      reverseSectionPositions() {
        this.sections.forEach(async (_, index) => {
          if (!this.sectionAnimations[index]) return null;

          // Wait for animation to have finished
          await this.sectionAnimations[index].finished;

          this.sectionAnimations[index].playbackRate = 1.5;
          this.sectionAnimations[index].reverse();
        });
      },
      toggleNavigation() {
        this.menuIsOpen = !this.menuIsOpen;
      },
      setBackgroundHeight() {
        const background = this.$refs.background;

        if (!this.$refs.background) return null;

        this.getListHeight();

        background.style.height = `${this.height}px`;
      }
    }
  };
</script>
