<template>
  <div v-if='isAuthenticated && isProfileLoaded'>
    Dashboard{blis generic flow}
  </div>
</template>

<script>
  import { mapGetters, mapState } from 'vuex'

  export default {
    computed: {
      ...mapGetters(['isAuthenticated', 'isProfileLoaded']),
    }
  }
</script>