<template>
  <a class="c-link-card" :href="item.url">
    <div class="c-card c-card--without-box-shadow c-card--without-padding">
      <div class="c-card__image">
        <image-component
          sizes="(max-width: 1023px) 90vw, (max-width: 1439px) 45vw, 750px"
          :image="item.featuredImage"
          class-image="u-object-fit"
        />
      </div>

      <div class="c-card__content">
        <h3
          class="t-heading-4 t-heading-4--primary t-heading-4--style-normal t-heading-4--semi-bold t-heading-4--line-height-compact t-heading-4--margin-reset t-heading-4--no-transform u-limit-lines-3"
        >
          {{ item.cardTitle }}
        </h3>
      </div>
      <div class="c-card__details">
        <div class="c-card__date">
          <p class="c-date">{{ item.datePublished }}</p>
        </div>

        <div class="c-card__detail-content">
          <tags-component :tags="item.categories" />
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
    </div>
  </a>
</template>

<script>
export default {
  name: "CardStandard",
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
};
</script>
