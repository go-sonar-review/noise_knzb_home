<template>
  <div v-if="state?.hits.length" :class="classList">
    <component
      :is="getCardType(item.type.handle)"
      v-for="(item, index) in state?.hits"
      :key="index"
      :item="item"
    ></component>
  </div>
  <div v-else><slot name="no-results-message" /></div>
</template>

<script>
  import { createWidgetMixin } from "vue-instantsearch";
  import { connectHits } from "instantsearch.js/es/connectors";
  import Standard from "./cards/CardStandard.vue";
  import Agenda from "./cards/CardAgenda.vue";
  import Showcase from "./cards/CardShowcase.vue";
  import Vacancy from "./cards/CardVacancy.vue";
  import Search from "./cards/CardSearch.vue";

  export default {
    mixins: [createWidgetMixin({ connector: connectHits })],
    props: {
      contentType: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        cardType: {
          newsDetail: Standard,
          agendaItem: Agenda,
          blog: Standard,
          knowledgeArticle: Showcase,
          showcase: Showcase,
          vacancy: Vacancy
        }
      };
    },
    computed: {
      classList() {
        if (!this.contentType) {
          return "l-results l-results--single-column l-results--no-gap-row";
        }

        if (this.contentType === "vacancy") {
          return "l-results l-results--single-column";
        }

        return "l-results";
      }
    },
    methods: {
      getCardType(type) {
        if (!this.contentType) return Search;

        return this.cardType[type];
      }
    }
  };
</script>
