<template>
  <a :href="item.url" class="c-link-card">
    <div class="c-card-search">
      <h3 class="t-title t-title--uppercase t-title--tertiary t-title--small">
        {{ item.type.name }}
      </h3>
      <h2 class="t-title t-title--uppercase t-title--primary">
        {{ item.cardTitle }}
      </h2>
      <div v-if="item.cardSummary" class="c-card-search__summary">
        <p class="t-paragraph t-paragraph--primary">
          {{ item.cardSummary }}
        </p>
      </div>
    </div>
  </a>
</template>

<script>
export default {
  name: "CardSearch",
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
};
</script>
