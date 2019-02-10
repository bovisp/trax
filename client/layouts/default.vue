<template>
  <div>
    <TopNav />

    <nuxt />
  </div>
</template>

<script>
  import TopNav from '../components/navigation/TopNav'

  export default {
    components: {
      TopNav
    }
  }
</script>