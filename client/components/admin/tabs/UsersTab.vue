<template>
	<aside class="menu">
		<p class="menu-label">
			Roles
		</p>

		<ul class="menu-list">
			<li>
				<nuxt-link :to="{ name: 'admin-roles' }">
					View roles
				</nuxt-link>
			</li>
			<li>
				<nuxt-link :to="{ name: 'admin-roles-create' }">
					Add role
				</nuxt-link>
			</li>
		</ul>
	</aside>
</template>

<script>
	export default {}
</script>