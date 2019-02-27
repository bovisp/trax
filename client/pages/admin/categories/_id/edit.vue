<template>
	<section class="section">
		<div class="container">
			<div class="columns">
				<div class="column is-half is-offset-one-quarter">
					<h2 class="title is-2 has-text-weight-light mr-auto">
						Edit: {{ category.name }}
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
											v-for="parentCategory in categories"
											v-if="parentCategory.id != category.id"
											:value="parentCategory.id"
											:key="parentCategory.id"
											style="padding-left: 3rem;"
										>{{ parentCategory.name }}</option>
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
				category: 'admin/categories/category',
				categories: 'admin/categories/categories'
			})
		},

		methods: {
			...mapActions({
				fetch: 'admin/categories/show',
				update: 'admin/categories/update',
				fetchAll: 'admin/categories/index'
			}),

			async fetchCategory (id) {
				await this.fetch(id)
			},

			async submit () {
				let response = await this.update({ form: this.form, categoryId: this.category.id })

				if (response.status === 200) {
					this.successSnackbar(response.data.message)

					setTimeout(() => {
						this.form = {
							name: '',
							parent_id: ''
						}

						this.$router.push({ name: 'admin-categories-id', params: { id: response.data.data.id } })
					}, 3000)
				}
			}
		},

		async mounted () {
			await this.fetchCategory(this.$route.params.id)
			await this.fetchAll()

			setTimeout(() => {
				this.form.name = this.category.name
				this.form.parent_id = this.category.parent ? this.category.parent.id : ''
			}, 200)
		}
	}
</script>