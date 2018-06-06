<template>
  <div v-if='isAuthenticated && isProfileLoaded'>
    Dashboard
  </div>
</template>

<script>
  import { mapGetters, mapState } from 'vuex'

  export default {
    computed: {
      ...mapGetters(['isAuthenticated', 'isProfileLoaded']),
    },
  }
</script>