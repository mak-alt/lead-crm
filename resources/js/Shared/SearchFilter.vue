<template>
  <div class="col-sm-3">
    <div class="search-box">
      <input type="text" autocomplete="off" :value="modelValue" class="form-control search" placeholder="Search..." />
      <i class="ri-search-line search-icon"></i>
    </div>
  </div>
  <div class="col-sm-1">
    <button class="ml-3 btn btn-outline-primary text-gray-500 text-sm" :disabled="filters.processing" type="submit">Search</button>
  </div>
</template>

<script>

export default {
  components: {
  },
  props: {
    modelValue: String,
    maxWidth: {
      type: Number,
      default: 300,
    },
  },
  emits: ['update:modelValue', 'reset'],
}
</script>
