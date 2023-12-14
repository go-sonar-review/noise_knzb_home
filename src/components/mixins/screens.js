const TABLET_BREAKPOINT = "768";

export default {
  data() {
    return {
      mediaQuery: `screen and (min-width: ${TABLET_BREAKPOINT}px)`,
      screenMatches: null
    };
  },
  mounted() {
    this.setEventListener();
    this.screenMatches = this.getScreenMatches();
  },
  unmounted() {
    this.removeEventListener();
  },
  methods: {
    setEventListener() {
      const mql = window.matchMedia(this.mediaQuery);
      mql.addEventListener("change", this.setScreenMatches);
    },
    removeEventListener() {
      document.removeEventListener("change", this.setScreenMatches);
    },
    getScreenMatches() {
      return window.matchMedia(this.mediaQuery).matches;
    },
    setScreenMatches(e) {
      this.screenMatches = e.matches;
    }
  }
};
