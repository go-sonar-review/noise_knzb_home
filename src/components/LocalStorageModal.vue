<template>
  <div v-if="showModal && id" class="modal">
    <div class="modal__backdrop" aria-hidden="true" @click="closeModal()"></div>

    <div class="modal__inner">
      <button class="modal__close" @click="closeModal()"></button>

      <div class="modal__content">
        <slot name="modal-content"></slot>

        <div v-if="links" class="l-content c-link-list">
          <a v-for="(link, index) in links"
            :key="`link--${index}`"
            :href="link.url"
            :target="link.target"
            class="c-link c-link--primary c-link--has-icon-before c-link--has-clip-path-left c-link--without-background-color"
            @click.prevent="handleNavigation(link)"
          >
            <span class="c-link__label">{{ link.text }}</span>
        </a>
        </div>
      </div>

      <div class="modal__image-container">
        <slot name="image-content"></slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "LocalStorageModal",
  props: {
    id: {
      type: String,
      required: true,
    },
    links: {
      type: Array,
      default: () => {
        return [];
      },
    },
  },
  data() {
    return {
      showModal: true,
    };
  },
  mounted() {
    this.setInitialLocalStorageState();
  },
  methods: {
    setInitialLocalStorageState() {
      const localStorageState = this.getLocalStorageState();
      this.setLocalStorageState(localStorageState ?? "open");
      this.showModal = localStorageState !== "closed";
      
      this.handleBackgroundScrollBehavior();
    },
    getLocalStorageState() {
      return localStorage.getItem(this.id);
    },
    setLocalStorageState(state) {
      localStorage.setItem(this.id, state);
    },
    closeModal() {
      this.showModal = false;
      this.setLocalStorageState("closed");
      this.handleBackgroundScrollBehavior();
    },
    handleNavigation(link) {
      this.closeModal();
      if (link.target === '_blank') {
        window.open(link.url, '_blank');
      } else {
        window.location.href = link.url;
      }
    },
    handleBackgroundScrollBehavior() {
      if (this.showModal) {
        document.body.classList.add("u-modal--open");
      } else {
        document.body.classList.remove("u-modal--open");
      }
    },
  },
};
</script>
