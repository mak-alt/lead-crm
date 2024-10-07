<template>
	<img :src="profile" alt="" class="rounded-circle" />
</template>

<script>
	
	export default {
		props: {
			profile: String
		},
	}

</script>