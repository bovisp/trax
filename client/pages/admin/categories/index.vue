<template>
	<section class="section">
		<div class="container">
			<div class="columns">
				<div class="column is-half is-offset-one-quarter">
					<div class="is-flex mb-4 items-center">
						<h2 class="title is-2 has-text-weight-light mr-auto">
							Categories
						</h2>
					</div>

					<template v-if="!updating">
						<div class="is-flex items-center">
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
											<nuxt-link :to="{ name: 'admin-categories-create' }">
												Add category
											</nuxt-link>
										</div>

										<div class="dropdown-item" @click="updating = true">
											<a href="#" @click.prevent="updating = true">
												Edit category order
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>

						<b-table 
							:data="categories" 
							:opened-detailed="defaultOpenedDetails"
							:show-detail-icon="showDetailIcon"
							ref="table"
							detailed
	            			detail-key="id"
						>
							<template slot-scope="props">
								<b-table-column field="name" label="Name">
				                    <nuxt-link :to="{ name: 'admin-categories-id', params: { id: props.row.id } }">
		                				{{ props.row.name }}
		                			</nuxt-link>
				                </b-table-column>
							</template>

							<template slot="detail" slot-scope="props">
				                <div v-if="props.row.children.length">
				                	<h3 class="title is-5 has-text-weight-light">
				                		Child categories
				                	</h3>

				                	<ul class="ml-4">
				                		<li
											v-for="child in props.row.children"
											:key="child.id"
				                		>
				                			<nuxt-link :to="{ name: 'admin-categories-id', params: { id: child.id } }">
				                				{{ child.name }}
				                			</nuxt-link>
				                		</li>
				                	</ul>
				                </div>

				                <div v-else>
				                	<p>No child categories</p>
				                </div>
				            </template>
						</b-table>
					</template>

					<template v-else>
						<nav class="panel">
							<draggable 
								v-model="categories" 
								@start="drag = true" 
								@end="drag = false"
							>
							   <div 
								   	v-for="element in categories" 
								   	:key="element.id"
								   	class="panel-block is-cursor-pointer" 
							   	>{{element.name}}</div>
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
	import api from '../../../api'
	import { mapActions, mapGetters } from 'vuex'
	import draggable from 'vuedraggable'

	export default {
		middleware: ['admin'],

		components: {
			draggable
		},

		data () {
			return {
				columns: [
					{ field: 'name', label: 'Name' }
				],
				defaultOpenedDetails: [],
                showDetailIcon: true,
                updating: false
			}
		},

		computed: {
			categories: {
		        get() {
		            return this.$store.state.admin.categories.categories
		        },
		        set(value) {
		            this.$store.commit('admin/categories/UPDATE_CATEGORY_ORDERS', value)
		        }
		    }
		},

		methods: {
			...mapActions({
				fetch: 'admin/categories/index',
				updateOrder: 'admin/categories/updateOrder' 
			}),

			async update () {
				await this.updateOrder()

				if (!Object.keys(this.errors).length) {
					await this.cancel()

					this.successSnackbar('Categories order updated')
				}				
			},

			async cancel () {
				await this.fetch()

				this.updating = false
			}
		},

		async mounted () {
			await this.fetch()
		}
	}
</script>