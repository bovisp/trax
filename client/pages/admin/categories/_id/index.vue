<template>
	<section class="section">
		<div class="container">
			<div class="columns">
				<div class="column is-half is-offset-one-quarter">
					<div class="is-flex mb-4 items-center">
						<h2 class="title is-2 has-text-weight-light mr-auto">
							{{ category.name }}
						</h2>
					</div>

					<div class="is-flex items-center" v-if="!updating">
						<div class="dropdown is-hoverable is-right ml-auto">
							<div class="dropdown-trigger">
								<button class="button is-white is-borderless" aria-haspopup="true" aria-controls="dropdown-menu4">
									<span class="icon is-small">
										<i class="mdi mdi-settings" aria-hidden="true"></i>
									</span>

									<span class="icon is-small">
										<i class="mdi mdi-menu-down" aria-hidden="true"></i>
									</span>
								</button>
							</div>

							<div class="dropdown-menu" id="dropdown-menu4" role="menu">
								<div class="dropdown-content">
									<div class="dropdown-item">
										<nuxt-link 
											:to="{ name: 'admin-categories-id-edit', params: { id: category.id } }"
										>
											Edit category
										</nuxt-link>
									</div>

									<div 
										class="dropdown-item" 
										@click="updating = true"
										v-if="children.length"
									>
										<a href="#" @click.prevent="updating = true">
											Edit category order
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<template v-if="children.length && !updating">
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

					<template v-if="children.length && updating">
						<nav class="panel">
							<draggable 
								v-model="children" 
								@start="drag = true" 
								@end="drag = false"
							>
							   <div 
								   	v-for="child in children" 
								   	:key="child.id"
								   	class="panel-block is-cursor-pointer" 
							   	>{{child.name}}</div>
							</draggable>
						</nav>
						
						<div class="is-flex">
							<button class="button is-link ml-auto" @click="update">Update order</button>

							<button class="button is-text" @click="cancel">Cancel</button>
						</div>

						<div class="message is-danger mt-4" v-if="Object.keys(errors).length">
							<div class="message-body">
								<ul>
									<li
										v-for="error in errors"
										:key="error"
										v-text="error[0]"
									></li>
								</ul>
							</div>
						</div>
					</template>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	import draggable from 'vuedraggable'

	export default {
		middleware: ['admin'],

		data () {
			return {
				updating: false
			}
		},

		components: {
			draggable
		},

		computed: {
			...mapGetters({
				category: 'admin/categories/category',
				categories: 'admin/categories/categories'
			}),

			children: {
				get() {
		            return this.$store.state.admin.categories.children
		        },
		        set(value) {
		            this.$store.commit('admin/categories/UPDATE_CHILD_ORDERS', value)
		        }
			}
		},

		methods: {
			...mapActions({
				fetch: 'admin/categories/show',
				fetchAll: 'admin/categories/index',
				updateOrder: 'admin/categories/updateOrder' 
			}),

			async fetchCategory (id) {
				await this.fetch(id)
			},

			async update () {
				await this.updateOrder(true)

				if (!Object.keys(this.errors).length) {
					await this.fetchCategory(this.$route.params.id)

					this.updating = false

					this.successSnackbar('Categories order updated')	
				}			
			},

			async cancel () {
				await this.fetch()

				this.updating = false
			}
		},

		async mounted () {
			await this.fetchCategory(this.$route.params.id)
			await this.fetchAll()
		}
	}
</script>