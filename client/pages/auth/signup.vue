<template>
	<div class="column is-half-tablet is-offset-one-quarter-tablet">
		<div class="box">
			<h2 class="title is-2 has-text-dark has-text-weight-light has-text-centered">
				Sign up
			</h2>

			<article class="message is-danger" v-if="errors.message">
				<div class="message-body">
					{{ errors.message[0] }}
				</div>
			</article>

			<form @submit.prevent="submit">
				<div class="field">
					<label for="name" class="label">
						Name
					</label>

					<div class="control">
						<input 
							type="text" 
							v-model="form.name" 
							class="input"
							:class="{ 'is-danger': errors.name }"
							id="name" 
						>
					</div>

					<p
						class="help is-danger"
						v-if="errors.name"
						v-text="errors.name[0]"
					></p>
				</div>

				<div class="field">
					<label for="email" class="label">
						Email
					</label>

					<div class="control">
						<input 
							type="email" 
							v-model="form.email" 
							class="input"
							:class="{ 'is-danger': errors.email }"
							id="email" 
						>
					</div>

					<p
						class="help is-danger"
						v-if="errors.email"
						v-text="errors.email[0]"
					></p>
				</div>

				<div class="field">
					<label for="password" class="label">
						Password
					</label>

					<div class="control">
						<input 
							type="password" 
							v-model="form.password" 
							class="input"
							:class="{ 'is-danger': errors.password }"
							id="password" 
						>
					</div>

					<p
						class="help is-danger"
						v-if="errors.password"
						v-text="errors.password[0]"
					></p>
				</div>

				<div class="field">
					<input 
						type="submit" 
						class="button is-outlined is-link is-fullwidth" 
						value="Sign in"
					>
				</div>
			</form>

			<p class="mt-2">
				Have an account? 

				<nuxt-link :to="{ name: 'auth-signin' }" class="has-text-link">
					Sign in.
				</nuxt-link>
			</p>
		</div>
	</div>
</template>

<script>
	export default {
		layout: 'hero',

		middleware: ['guest'],

		data () {
			return {
				form: {
					email: '',
					password: '',
					name: ''
				}
			}
		},

		methods: {
			submit () {
				this.$store.dispatch('auth/register', this.form)
					.then(result => {
						this.$router.push({ name: 'dashboard' })
					})
					.catch(error => {})
			}
		}
	}
</script>