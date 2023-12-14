<template>
  <a :href="item.url" class="c-link-card">
    <div class="c-card-text">
      <div class="c-card-text__main">
        <h2 class="t-heading-4 t-heading-4--primary-dark">
          {{ item.cardTitle }}
        </h2>
        <a
          class="c-link c-link--primary c-link--has-clip-path-right"
          :href="item.url"
        >
          <span class="c-link__label">Bekijk vacature</span>
        </a>
      </div>
      <div class="c-card-text__summary">
        <p class="t-paragraph t-paragraph--primary-dark">{{ item.cardSummary }}</p>
      </div>
    </div>
  </a>
</template>

<script>
export default {
  name: "CardVacancy",
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
};
</script>
