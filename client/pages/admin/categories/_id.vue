<template>
	<section class="section">
		<div class="container">
			<div class="columns">
				<div class="column is-half is-offset-one-quarter">
					<div class="is-flex mb-4 items-center">
						<h2 class="title is-2 has-text-weight-light mr-auto">
							{{ category.name }}
						</h2>

						<nuxt-link to="/" class="button is-text">
							Edit category
						</nuxt-link>
					</div>
					
					<template v-if="hasChildren">
						<h3 class="is-4 title has-text-weight-light">
							Child categories
						</h3>

						<ul class="ml-4">
							<li v-for="child in category.children" class="mb-1">
								<nuxt-link :to="{ name: 'admin-categories-id', params: { id: child.id } }">
									{{ child.name }}
								</nuxt-link>
							</li>
						</ul>
					</template>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'

	export default {
		middleware: ['admin'],

		computed: {
			...mapGetters({
				category: 'admin/categories/category'
			}),

			hasChildren () {
				return typeof this.category.children !== 'undefined' && Object.keys(this.category.children).length > 0
			}
		},

		methods: {
			...mapActions({
				fetch: 'admin/categories/show'
			})
		},

		mounted () {
			this.fetch(this.$route.params.id)
		}
	}
</script>