<template>
	<section class="section">
		<div class="container">
			<div class="columns">
				<div class="column is-half is-offset-one-quarter">
					<div class="is-flex mb-4 items-center">
						<h2 class="title is-2 has-text-weight-light mr-auto">
							Categories
						</h2>

						<nuxt-link :to="{ name: 'admin-categories-create' }" class="button is-text">
							Add category
						</nuxt-link>
					</div>

					<div class="menu">
						<template
							v-for="category in categories"
						>
							<p class="menu-label">
								<nuxt-link :to="{ name: 'admin-categories-id', params: { id: category.id } }">
									{{ category.name }}
								</nuxt-link>
							</p>

							<ul class="menu-list" v-if="category.children.length">
								<li v-for="child in category.children">
									<nuxt-link :to="{ name: 'admin-categories-id', params: { id: child.id } }">
										{{ child.name }}
									</nuxt-link>
								</li>
							</ul>
						</template>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
	import api from '../../../api'
	import { mapActions, mapGetters } from 'vuex'

	export default {
		middleware: ['admin'],

		computed: {
			...mapGetters({
				categories: 'admin/categories/categories'
			})
		},

		methods: {
			...mapActions({
				fetch: 'admin/categories/index'
			})
		},

		async mounted () {
			await this.fetch()
		}
	}
</script>