<template>
	<div>
		<div id="layout-wrapper">
			<Header />
			<Nav />
			<slot />
			<flash-messages/>
		</div>
	</div>
</template>

<script>
	import { Link } from '@inertiajs/inertia-vue3'
	import Header from '@/Shared/Header'
	import Nav from '@/Shared/Nav'

	export default {
		components: {
			Header,
			Nav
		},
	}
</script>