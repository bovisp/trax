<template>
  <section class="container">
    <p>Home</p>
    <nuxt-link
      :to="{ name: 'auth-signin' }"
    > Log In</nuxt-link>

    <nuxt-link
      :to="{ name: 'dashboard' }"
    >Dashboard</nuxt-link>
  </section>
</template>

<script>

export default {
  
}
</script>