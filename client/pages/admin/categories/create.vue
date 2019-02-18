<template>
	<section class="section">
		<div class="container">
			<div class="columns">
				<div class="column is-half is-offset-one-quarter">
					<h2 class="title is-2 has-text-weight-light">
						Add category
					</h2>

					<form @submit.prevent="submit">
						<div class="field" v-if="categories.length">
							<label for="parent_id" class="label">
								Parent category
							</label>

							<div class="control">
								<div class="select">
									<select name="" id="parent_id" v-model="form.parent_id">
										<option value=""></option>

										<option
											v-for="category in categories"
											:value="category.id"
											:key="category.id"
											style="padding-left: 3rem;"
										>{{ category.name }}</option>
									</select>
								</div>
							</div>
						</div>

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
							<input type="submit" class="button is-link is-outlined">
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	import api from '../../../api'

	export default {
		middleware: ['admin'],

		data () {
			return {
				form: {
					name: '',
					parent_id: ''
				}
			}
		},

		computed: {
			...mapGetters({
				categories: 'admin/categories/categories'
			})
		},

		methods: {
			...mapActions({
				store: 'admin/categories/store',
				fetch: 'admin/categories/index'
			}),

			async submit () {
				let response = await this.store({ form: this.form })

				if (response.status === 201) {
					this.successSnackbar(response.data.message)

					setTimeout(() => {
						this.form = {
							name: '',
							parent_id: ''
						}

						this.$router.push({ name: 'admin-categories' })
					}, 3000)
				}
			}
		},

		mounted () {
			this.fetch()
		}
	}
</script>