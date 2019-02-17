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

					<b-table :data="roles" :columns="columns"></b-table>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
	import api from '../../../api'

	export default {
		middleware: ['admin'],
		
		data () {
			return {
				roles: [],
				columns: [
					{ field: 'name', label: 'Name' },
                    { field: 'display_name', label: 'Display name'}
				]
			}
		},

		asyncData ({ params }) {
			return api.roles.index()
				.then(response => {
					return { roles: response.data.data }
				})
		}
	}
</script>