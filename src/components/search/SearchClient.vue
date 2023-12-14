<template>
  <ais-instant-search
    :search-client="searchClient"
    :index-name="searchIndex"
    :routing="routing"
  >
    <ais-configure
      :filters="filters"
      :disjunctive-facets-refinements.camel="{ ...facets }"
    />
    <slot name="filters" />
    <slot name="top-content" />
    <slot name="hits" />
    <slot name="pagination" />
  </ais-instant-search>
</template>

<script>
import { history as historyRouter } from "instantsearch.js/es/lib/routers";
import { singleIndex as singleIndexMapping } from "instantsearch.js/es/lib/stateMappings";
import searchClient from "../../js/algoliaSearchClient.js";
import { AisInstantSearch, AisConfigure } from "vue-instantsearch";

export default {
  name: "SearchClient",
  components: {
    AisInstantSearch,
    AisConfigure,
  },
  props: {
    contentType: {
      required: true,
      type: String,
    },
    facets: {
      type: Object,
      default: () => {
        return {};
      },
    },
    searchIndex: {
      required: true,
      type: String,
    },
  },
  data() {
    return {
      searchClient,
      routing: {
        router: historyRouter(),
        stateMapping: singleIndexMapping(this.searchIndex),
      },
    };
  },
  computed: {
    filters() {
      if (!this.contentType) return "";

      return `type.handle:${this.contentType}`;
    },
  },
};
</script>
