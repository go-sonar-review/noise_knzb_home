export default {
  props: {
    config: {
      type: Object,
      default: undefined
    }
  },
  data() {
    return {
      animation: null
    };
  },
  methods: {
    async enter(element, done) {
      if (!this.effect) {
        console.warn("data method should contain an effect:", this.effect);

        done();
        return null;
      }

      const effect = this.effect(element, this.config);

      this.animation = new Animation(effect);
      this.animation.play();

      await this.animation.finished;

      this.animation.commitStyles();

      done();
    },
    async leave(_, done) {
      if (!this.animation) {
        done();
        return null;
      }

      this.animation.playbackRate = 1.5;
      this.animation.reverse();

      await this.animation.finished;

      done();
    }
  }
};
