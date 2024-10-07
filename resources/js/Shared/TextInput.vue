<template>
  <div :class="$attrs.class">
    <label v-if="label" class="form-label" :for="id">{{ label }} <span v-if="required" class="text-danger">*</span></label>
    <input :id="id" ref="input" v-bind="{ ...$attrs, class: null }" :placeholder="placeholder" class="form-control" :class="error ? 'is-invalid' : ''" :type="type" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
    <div v-if="error" class="form-error invalid-feedback">{{ error }}</div>
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
        return `text-input-${uuid()}`
      },
    },
    type: {
      type: String,
      default: 'text',
    },
    error: String,
    label: String,
    modelValue: String,
    placeholder: String,
    required: Boolean
  },
  emits: ['update:modelValue'],
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
    setSelectionRange(start, end) {
      this.$refs.input.setSelectionRange(start, end)
    },
  },
}
</script>
