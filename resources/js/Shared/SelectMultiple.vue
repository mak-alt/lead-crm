<template>
  <div :class="$attrs.class">
    <label v-if="label" class="form-label" :for="id">{{ label }}: <span v-if="required" class="text-danger">*</span></label>
    <select v-bind="{ ...$attrs, class: null }" class="form-control" :class="{ error: error }" :id="id" ref="input" data-choices-removeItem data-choices data-choices-multiple-groups="true" multiple data-placeholder="Add Members" v-model="selected" data-choice="true">
        <slot/>
    </select>
    <div v-if="error" class="form-error">{{ error }}</div>
  </div>
</template>

<script>
import { v4 as uuid } from 'uuid'

export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `select-multiple-${uuid()}`
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
