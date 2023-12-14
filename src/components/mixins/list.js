import Vue from "vue";
import debounce from "lodash/debounce";

export default {
  data() {
    return {
      items: null,
      height: null
    };
  },
  mounted() {
    this.getItems();
    this.getListHeight();

    this.setEventlistener();
  },
  unmounted() {
    this.removeEventListener();
  },
  methods: {
    setEventlistener() {
      window.addEventListener("resize", debounce(this.getListHeight, 250));
    },
    removeEventListener() {
      window.removeEventListener("resize", debounce(this.getListHeight, 250));
    },
    getItems() {
      if (!this.$refs.list) {
        console.warn("list ref not found");

        this.items = [];

        return [];
      }

      if (this.$refs.list instanceof Vue) {
        // we can be sure that the children are <li> as these are the only valid child elements for lists
        this.items = this.$refs.list.$el.querySelectorAll("li");
      } else {
        this.items = this.$refs.list.querySelectorAll("li");
      }

      return this.items;
    },
    getListHeight() {
      // Convert nodelist to Array
      const itemsArray = Array.from(this.items);

      this.height = itemsArray.reduce((acc, currentValue) => {
        acc += currentValue.offsetHeight;
        return acc;
      }, 0);

      return this.height;
    }
  }
};
