<template>
  <div class="custom-dropdown" :tabindex="tabindex" @blur="visible = false">
    <div class="c-select" @click="toggleVisibility">
      {{ selected }}
    </div>
    <div :class="{ active: visible }" class="custom-dropdown__options">
      <ul>
        <li
          class="custom-dropdown__options__item"
          :value="' '"
          @click="
            selected = label;
            toggleVisibility();
            $emit('input', $event);
          "
        >
          {{ label }}
        </li>
        <li
          class="custom-dropdown__options__item"
          v-for="option in options"
          :value="option.value"
          @click="
            selected = option.value;
            toggleVisibility();
            $emit('input', $event);
          "
        >
          {{ option.value }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "SearchDropDown",
  props: {
    options: {
      type: Array,
      required: true,
    },
    label: {
      type: String,
      required: true,
    },
    defaultOption: {
      type: String,
      required: false,
      default: null,
    },
    tabindex: {
      type: Number,
      required: false,
      default: 0,
    },
  },
  data() {
    return {
      selected: this.label
        ? this.defaultOption
        : this.options.length > 0
        ? this.options[0]
        : null,
      visible: false,
    };
  },
  methods: {
    toggleVisibility() {
      this.visible = !this.visible;
    },
  },
};
</script>
