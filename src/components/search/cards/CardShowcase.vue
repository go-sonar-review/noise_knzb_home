<template>
  <div class="c-card c-card--without-box-shadow c-card--dark-light">
    <div class="c-card__content">
      <h3
        class="t-heading-4 t-heading-4--primary t-heading-4--style-normal t-heading-4--semi-bold t-heading-4--line-height-compact t-heading-4--margin-reset t-heading-4--no-transform u-limit-lines-3"
      >
        {{ item.cardTitle }}
      </h3>
    </div>
    <div class="c-card__details">
      <div class="c-card__detail-content">
        <tags-component :tags="item.categories" />
      </div>
    </div>

    <div class="c-card__button">
      <a
        class="c-link c-link--primary c-link--has-icon-before c-link--has-clip-path-left c-link--without-text"
        :href="item.url"
        target="_self"
        aria-label=""
      >
        <span class="c-link__label"></span>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  name: "CardShowcase",
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
};
</script>
