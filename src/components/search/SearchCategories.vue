<template>
  <div id="app">
    <search-drop-down
      class="select"
      :defaultOption="category? category : label"
      :label="label"
      :options="state?.items ? state?.items : []"
      @input="handleInput"
    />
  </div>
</template>

<script>
  import { createWidgetMixin } from "vue-instantsearch";
  import { connectMenu } from "instantsearch.js/es/connectors";

export default {
  name: "SearchCategories",
  mixins: [createWidgetMixin({ connector: connectMenu })],
  props: {
      attribute: {
        type: String,
        required: true
      },
      label: {
        type: String,
        required: true
      },
    },
    data() {
      return {
        category: null,
      };
    },
    computed: {
      widgetParams() {
        return {
          attribute: this.attribute
        };
      },
    },
    created() {
      this.category = this.getCategoryFromSearchParams();
    },
    watch: {
      "state.items.length"(newItemsAmount) {
         this.category = newItemsAmount !== 0 ? this.getCategoryFromSearchParams() : "";
      }
    },
    methods: {
      getCategoryFromSearchParams() {
        return new URLSearchParams(window.location.search).get(`menu[${this.attribute}]`) ?? "";
      },
      handleInput(event) {
        const value = event.target.getAttribute("value");
        this.state.refine(value);
    }
    }
};
</script>
