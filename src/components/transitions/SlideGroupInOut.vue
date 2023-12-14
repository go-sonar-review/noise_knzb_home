<template>
  <TransitionGroup
    :css="false"
    :tag="tag"
    ref="list"
    @before-enter="beforeEnter"
    @enter="enter"
    @leave="leave"
  >
    <!-- Slot should contain list elements with the following attributes: -->
    <!-- :key="{{ id }}" :data-index="{{ index }}" -->
    <slot />
  </TransitionGroup>
</template>

<script>
  import ListMixin from "../mixins/list";
  import { slide } from "../../animation/effects";
  import { staggerTimings } from "../../animation/timings";

  export default {
    name: "SlideGroupInOut",
    mixins: [ListMixin],
    props: {
      tag: {
        type: String,
        default: "div"
      },
      config: {
        type: Object,
        default: () => {
          return {};
        }
      },
      absolute: {
        type: Boolean,
        default: false
      }
    },
    data() {
      return {
        animations: [],
        filledSpace: 0
      };
    },
    updated() {
      this.getItems();
      this.getListHeight();
    },
    watch: {
      height() {
        //  resets the filled space after all elements have found their place :)
        this.filledSpace = 0;

        if (this.absolute) {
          this.items.forEach(element => {
            this.positionElement(element);
          });
        }
      }
    },
    methods: {
      beforeEnter(element) {
        if (this.absolute) {
          element.style.position = "absolute";
        }
      },
      async enter(element, done) {
        if (!element.dataset.index) {
          this.logIndexFailedError();
          return null;
        }

        this.positionElement(element);

        await this.animateElementIn(element);

        done();
      },
      async leave(element, done) {
        if (!element.dataset.index) {
          this.logIndexFailedError();
          return null;
        }

        await this.animateElementOut(element);

        //  resets the filled space after all elements have found their place :)
        this.filledSpace = 0;

        done();
      },
      animateElementIn(element) {
        const index = element.dataset.index - 1;

        const config = {
          ...this.config,
          timings: staggerTimings(index)
        };

        const effect = slide(element, config);

        this.animations[index] = new Animation(effect);
        this.animations[index].play();

        return this.animations[index].finished;
      },
      animateElementOut(element) {
        const index = element.dataset.index - 1;

        this.animations[index].playbackRate = 2;
        this.animations[index].reverse();

        return this.animations[index].finished;
      },
      positionElement(element) {
        element.style.top = `${this.filledSpace}px`;

        // Keep track of the space that is already occupied so we know where each element should be positioned
        this.filledSpace += element.offsetHeight;
      },
      logIndexFailedError() {
        console.warn("Element cannot be indexed, check the list dataset attribute");
      }
    }
  };
</script>
