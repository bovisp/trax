<template>
	<div>
		<p v-if="user">Hello, {{user.name}}</p>

		<nuxt-link
	      to="/dashboard"
	    >Admin</nuxt-link>

	    <button @click="$store.dispatch('auth/fetch')">Check</button>
	</div>
</template>

<script>
export default {
	middleware: ['auth']
}
</script>