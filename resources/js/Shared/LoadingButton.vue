<template>
  <button :disabled="loading" class="flex items-center">
    <div v-if="loading" class="btn btn-success w-100 btn-spinner" />
    <slot />
  </button>
</template>

<script>
export default {
  props: {
    loading: Boolean,
  },
}
</script>
