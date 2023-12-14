<template>
  <ais-pagination :padding="1" :show-first="false" :show-last="false">
    <template
      v-slot="{
        pages,
        refine,
        createURL,
        currentRefinement,
        isFirstPage,
        isLastPage,
      }"
    >
      <span v-if="isFirstPage && isLastPage"></span>
      <ul v-else class="c-pagination">
        <li class="pagination__item">
          <a
            :class="[
              'c-link c-link--primary c-link--has-icon-before-back c-link--without-text',
              { 'c-link--disabled': isFirstPage },
            ]"
            :href="createURL(currentRefinement - 1)"
            :aria-disabled="isFirstPage"
            @click.prevent="handleRefine(refine, currentRefinement - 1)"
            ><span class="c-link__label"></span
          ></a>
        </li>

        <li v-if="currentRefinement > 1" class="c-pagination__item">
          <a
            class="c-pagination__link"
            :href="createURL(0)"
            @click.prevent="handleRefine(refine, 0)"
            >1<span class="c-pagination__dash">-</span>
          </a>
        </li>

        <li v-for="page in pages" :key="page" class="c-pagination__item">
          <a
            :class="[
              'c-pagination__link',
              { 'c-pagination__link--active': page === currentRefinement },
            ]"
            :href="createURL(page)"
            @click.prevent="handleRefine(refine, page)"
            >{{ page + 1 }}</a
          >
        </li>

        <li class="pagination__item">
          <a
            :class="[
              'c-link c-link--primary c-link--has-icon-before c-link--without-text',
              { 'c-link--disabled': isLastPage },
            ]"
            :href="createURL(currentRefinement + 1)"
            :aria-disabled="isLastPage"
            @click.prevent="handleRefine(refine, currentRefinement + 1)"
            ><span class="c-link__label"></span
          ></a>
        </li>
      </ul>
    </template>
  </ais-pagination>
</template>

<script>
import { AisPagination } from "vue-instantsearch";

export default {
  name: "SearchPagination",
  components: {
    AisPagination,
  },
  methods: {
    handleRefine(refine, refinement) {
      refine(refinement);
      window.scrollTo(0, 0);
    },
  },
};
</script>
