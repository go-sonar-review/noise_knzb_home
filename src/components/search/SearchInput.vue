<template>
  <div class="c-search-query">
    <span class="c-search-query__before"></span>
    <input
      v-model="query"
      type="search"
      :placeholder="searchPlaceholder"
      class="c-search-query__input"
      @input="handleInput"
    />
    <span class="c-search-query__after"></span>
  </div>
</template>

<script>
import debounce from "lodash/debounce";
import { connectSearchBox } from "instantsearch.js/es/connectors";
import { createWidgetMixin } from "vue-instantsearch";

export default {
  name: "SearchInput",
  mixins: [createWidgetMixin({ connector: connectSearchBox })],
  props: {
    searchPlaceholder: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      query: null,
    };
  },
  created() {
    this.query = new URLSearchParams(window.location.search).get("query");
  },
  methods: {
    handleInput: debounce(function () {
      this.state.refine(this.query);
    }, 500),
  },
};
</script>
