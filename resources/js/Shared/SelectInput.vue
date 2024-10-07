<template>
  <div :class="$attrs.class">
    <label v-if="label" class="form-label" :for="id">{{ label }}: <span v-if="required" class="text-danger">*</span></label>
    <select :id="id" ref="input" data-choices data-choices-search-false v-model="selected" v-bind="{ ...$attrs, class: null }" class="form-select" :class="error ? 'is-invalid' : ''">
      <slot />
    </select>
    <div v-if="error" class="form-error invalid-feedback">{{ error }}</div>
  </div>
</template>

<style scoped>
  .invalid-feedback{
    display: block;
  }
  .choices{
    margin-bottom: 4px !important;
  }
</style>
<script>
import { v4 as uuid } from 'uuid'

export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `select-input-${uuid()}`
      },
    },
    error: String,
    label: String,
    modelValue: [String, Number, Boolean],
    required: Boolean
  },
  emits: ['update:modelValue'],
  data() {
    return {
      selected: this.modelValue,
    }
  },
  watch: {
    selected(selected) {
      this.$emit('update:modelValue', selected)
    },
  },
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
  },
}
</script>
