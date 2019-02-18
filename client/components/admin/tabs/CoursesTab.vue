<template>
	<aside class="menu">
		<p class="menu-label">
			Categories
		</p>

		<ul class="menu-list">
			<li>
				<nuxt-link :to="{ name: 'admin-categories' }">
					View categories
				</nuxt-link>
			</li>
			<li>
				<nuxt-link :to="{ name: 'admin-categories-create' }">
					Add category
				</nuxt-link>
			</li>
		</ul>
	</aside>
</template>

<script>
	export default {}
</script>