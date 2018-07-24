<template>
  <v-app id="inspire">
    <v-navigation-drawer v-if='isAuthenticated && isProfileLoaded' v-model="drawer" fixed app>
      <sidebar></sidebar>
    </v-navigation-drawer>
    <v-toolbar v-if="isAuthenticated && isProfileLoaded" color="primary" class="elevation-1" dark fixed app>
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
      <v-toolbar-title>BLISv3.0</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-menu offset-y>
        <v-btn primary flat slot="activator"><v-icon left>developer_board</v-icon> {{name}}</v-btn>
        <v-list>
            <v-list-tile @click="logout">
              <v-list-tile-title>Logout</v-list-tile-title>
            </v-list-tile>
        </v-list>
      </v-menu>
    </v-toolbar>
    <v-content>
      <v-container fluid>
        <loading v-if='authLoading'></loading>
        <router-view></router-view>
      </v-container>
    </v-content>
    <v-footer v-if='isAuthenticated && isProfileLoaded' color="primary" app>
      <v-card-text class="white--text">
        &copy; {{ new Date().getFullYear() }} — <strong>@iLabAfrica</strong>
      </v-card-text>
    </v-footer>
  </v-app>
</template>

<script>
  import { mapGetters, mapState } from 'vuex'
  import { AUTH_LOGOUT } from '../store/actions/auth'
  import { USER_REQUEST } from '../store/actions/user'
  Vue.component('sidebar', require('./sidebar'));
  Vue.component('loading', require('./loading'));

  export default {
    created: function () {
      if (this.$store.getters.isAuthenticated) {
        this.$store.dispatch(USER_REQUEST)
      }
    },
    data: () => ({
      user: {},
      drawer: null
    }),
    methods: {
      logout: function () {
        this.$store.dispatch(AUTH_LOGOUT).then(() => this.$router.push('/login'))
      }
    },
    computed: {
      ...mapGetters(['getProfile', 'isAuthenticated', 'isProfileLoaded']),
      ...mapState({
        authLoading: state => state.auth.status === 'loading',
        name: state => `${state.user.profile.name}`,
      })
    },
  }
</script>