<template>
  <picture>
    <source type="image/webp" :srcset="srcsetWebp" :sizes="sizes" />
    <source type="image/jpg" :srcset="srcset" :sizes="sizes" />

    <img
      :src="image.url"
      :alt="image.alt"
      :title="image.title"
      :loading="loading"
      decoding="async"
      :class="classImage"
    />
  </picture>
</template>

<script>
export default {
  name: "ImageComponent",
  props: {
    image: {
      type: Object,
      required: true,
    },
    sizes: {
      type: String,
      default: "100 vw",
    },
    classImage: {
      type: String,
      default: "",
    },
    loading: {
      type: String,
      default: "lazy",
    },
  },
  data() {
    return {
      srcsetDefault: ["375w", "750w", "1200w", "1500w", "1920w", "2400w"],
    };
  },
  computed: {
    srcset() {
      return this?.image.srcset ?? this.srcsetDefault;
    },
    srcsetWebp() {
      return this?.image.srcsetWebp ?? this.srcsetDefault;
    },
  },
};
</script>
