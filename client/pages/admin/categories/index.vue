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

					<b-table 
						:data="categories" 
						:columns="columns"
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

		data () {
			return {
				columns: [
					{ field: 'name', label: 'Name' }
				],
				defaultOpenedDetails: [],
                showDetailIcon: true
			}
		},

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