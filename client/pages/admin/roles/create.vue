<template>
	<section class="section">
		<div class="container">
			<div class="columns">
				<div class="column is-half is-offset-one-quarter">
					<h2 class="title is-2 has-text-weight-light">
						Add role
					</h2>

					<form @submit.prevent="submit">
						<div class="field">
							<label for="name" class="label">Name</label>

							<div class="control">
								<input 
									type="text" 
									class="input" 
									id="name"
									v-model="form.name"
									:class="{ 'is-danger': errors.name }"
								> 
							</div>

							<p 
								class="help is-danger"
								v-if="errors.name"
								v-text="errors.name[0]"
							></p>
						</div>

						<div class="field">
							<label for="display_name" class="label">Dispay name</label>

							<div class="control">
								<input 
									type="text" 
									class="input" 
									id="display_name"
									v-model="form.display_name"
									:class="{ 'is-danger': errors.display_name }"
								> 
							</div>

							<p 
								class="help is-danger"
								v-if="errors.display_name"
								v-text="errors.display_name[0]"
							></p>
						</div>

						<div class="field">
							<input type="submit" class="button is-link is-outlined">
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
	import { mapActions } from 'vuex'

	export default {
		middleware: ['admin'],

		data () {
			return {
				form: {
					name: '',
					display_name: ''
				}
			}
		},

		methods: {
			...mapActions({
				store: 'admin/roles/store'
			}),

			async submit () {
				let response = await this.store({ form: this.form })

				if (response.status === 201) {
					this.successSnackbar(response.data.message)

					setTimeout(() => {
						this.$router.push({ name: 'admin-roles' })
					}, 3000)
				}
			}
		}
	}
</script>