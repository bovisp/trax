<template>
	<section class="section">
		<div class="container">
			<div class="columns">
				<div class="column is-half is-offset-one-quarter">
					<div class="is-flex mb-4 items-center">
						<h2 class="title is-2 has-text-weight-light mr-auto">
							{{ role.display_name }}
						</h2>
					</div>

					<div class="content">
						<p>
							<strong>Name: </strong>{{ role.name }}
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'

	export default {
		computed: {
			...mapGetters({
				role: 'admin/roles/role'
			})
		},

		methods: {
			...mapActions({
				fetch: 'admin/roles/show'
			})
		},

		mounted () {
			this.fetch(this.$route.params.id)
		}
	}
</script>