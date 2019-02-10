<template>
	<header>
		<nav class="navbar is-link" role="navigation" aria-label="main navigation">
			<div class="navbar-brand">
				<nuxt-link class="navbar-item has-text-weight-light is-size-4" to="/">
					Trax
				</nuxt-link>

				<a 
					role="button" 
					class="navbar-burger" 
					aria-label="menu" 
					aria-expanded="false"
					data-target="topNav"
				>
				  <span aria-hidden="true"></span>
				  <span aria-hidden="true"></span>
				  <span aria-hidden="true"></span>
				</a>
			</div>

			<div class="navbar-menu" id="topNav">
				<div class="navbar-start"></div>

				<div class="navbar-end">
					<template v-if="!authenticated">
						<div class="navbar-item">
							<div class="buttons">
								<nuxt-link
							    	:to="{ name: 'auth-signin' }"
							    	class="button is-outlined is-link is-inverted"
							    >Sign in</nuxt-link>

							    <nuxt-link
							    	:to="{ name: 'auth-signup' }"
							    	class="button is-inverted is-link"
							    >Register</nuxt-link>
							</div>
						</div>
					</template>

					<template v-else>
						<div class="navbar-item has-dropdown is-hoverable">
							<a class="navbar-link">
								{{ user.name }}
							</a>

							<div class="navbar-dropdown is-right">
								<a class="navbar-item" @click.prevent="signout">
									Logout
								</a>
							</div>
						</div>
					</template>
				</div>
			</div>
		</nav>
	</header>
</template>

<script>
	export default {
		methods: {
			async signout () {
				await this.$store.dispatch('auth/logout')

				this.$router.push('/')
			}
		}
	}
</script>