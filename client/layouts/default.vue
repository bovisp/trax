<template>
  <v-app>
    <TopNav />
    
    <nuxt />
  </v-app>
</template>

<script>
  import TopNav from '../components/navigation/TopNav'

  export default {
    components: {
      TopNav
    }
  }
</script>
