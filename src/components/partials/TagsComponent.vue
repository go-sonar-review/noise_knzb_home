<template>
  <ul class="c-tags">
    <li v-for="tag in tags" :key="tag" class="c-tags__item">
      {{ tag }}
    </li>
  </ul>
</template>

<script>
export default {
  name: "TagsComponent",
  props: {
    tags: {
      type: Array,
      required: true,
    },
  },
};
</script>
