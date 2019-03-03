<template>
	<section class="section">
		<div class="container">
			<div class="columns">
				<div class="column is-half is-offset-one-quarter">
					<div class="is-flex mb-4 items-center">
						<h2 class="title is-2 has-text-weight-light mr-auto">
							Roles
						</h2>

						<nuxt-link :to="{ name: 'admin-roles-create' }" class="button is-text">
							Add role
						</nuxt-link>
					</div>

					<b-table :data="roles">
						<template slot-scope="props">
							<b-table-column field="name" label="Name">
			                    <nuxt-link :to="{ name: 'admin-roles-id', params: { id: props.row.id } }">
	                				{{ props.row.name }}
	                			</nuxt-link>
			                </b-table-column>

			                <b-table-column field="dispay_name" label="Display name">
			                    <nuxt-link :to="{ name: 'admin-roles-id', params: { id: props.row.id } }">
	                				{{ props.row.display_name }}
	                			</nuxt-link>
			                </b-table-column>
						</template>
					</b-table>
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
				roles: 'admin/roles/roles'
			})
		},

		methods: {
			...mapActions({
				fetch: 'admin/roles/index'
			})
		},

		async mounted () {
			await this.fetch()
		}
	}
</script>