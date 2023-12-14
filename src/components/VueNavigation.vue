<template>
  <div class="c-navigation__inner">
    <div class="c-navigation__header">
      
      <div class="c-navigation__header-item">
        <slot name="search"></slot>
      </div>
      <div class="c-navigation__header-item">
        <slot name="logo"></slot>
      </div>
      <div class="c-navigation__header-item">
        <button class="c-navigation-toggle" :class="{'c-navigation-toggle--open' : isOpen }" @click="toggleMenu()" :aria-label="isOpen ? 'Sluit menu': 'Open menu'">
          <span class="c-navigation-toggle__bar"></span>
          <span class="c-navigation-toggle__bar"></span>
          <span class="c-navigation-toggle__bar"></span>
        </button>
      </div>
    </div>

    <div class="c-navigation__content">
      <slot name="knzb"></slot>
      <slot name="sport"></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: "VueNavigation",
  data() {
    return {
      isOpen: false
    };
  },
  mounted(){
    this.toggleNvigationClass();
  },
  methods: {
    toggleMenu(){
      this.isOpen = !this.isOpen;
      this.toggleNvigationClass();
    },
    toggleNvigationClass(){
      const navigation = document.querySelector('.c-navigation');
      this.isOpen ? navigation.classList.add('c-navigation--is-open') : navigation.classList.remove('c-navigation--is-open');

      this.isOpen ? document.body.classList.add('u-mobile-nav--open') : document.body.classList.remove('u-mobile-nav--open');
    }
  }
};
</script>
