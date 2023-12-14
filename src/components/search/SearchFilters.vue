<template>
  <div class="c-search-filter">
    <div class="c-search-filter__input">
      <search-input :search-placeholder="searchPlaceholder" />
    </div>
    <div v-if="showCategorySelect" class="c-search-filter__categories">
      <search-categories attribute="categories" label="Alle categorieën" />
    </div>
    <div v-if="!contentType" class="c-search-filter__categories">
      <search-categories attribute="type.name" label="Alle content typen" />
    </div>
  </div>
</template>

<script>
  export default {
    name: "SearchFilters",
    props: {
      contentType: {
        type: String,
        required: true
      },
      searchPlaceholder: {
        type: String,
        required: true
      },
      showCategorySelect: {
        type: Boolean,
        default: () => true
      }
    }
  };
</script>
