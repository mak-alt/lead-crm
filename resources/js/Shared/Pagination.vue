<template>

    <!-- Right Alignment -->
    <nav aria-label="Page navigation example" v-if="links.length > 3">
        <ul class="pagination pagination-separated justify-content-end">
            <template v-for="(link, key) in links">
                <li class="page-item" :class="{ 'active' : link.active }">
                    <Link :key="`link-${key}`" class="page-link" :href="link.url" v-html="link.label" />
                </li>
            </template>
        </ul>
    </nav>
</template>

<script>

export default {
  components: {
  },
  props: {
    links: Array,
  },
}
</script>
