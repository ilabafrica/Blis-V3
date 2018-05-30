<template>
  <v-app id="inspire">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>BLIS</v-toolbar-title>
                <v-spacer></v-spacer>
              </v-toolbar>
              <v-card-text>
                <v-text-field v-model="username" prepend-icon="person" name="username" label="Email" type="text"></v-text-field>
                <v-text-field v-model="password" prepend-icon="lock" name="password" label="Password" type="password"></v-text-field>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="login">Login</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
  import {AUTH_REQUEST} from '../store/actions/auth'
  export default {
    data() {
        return {
            username: '',
            password: '',
        };
    },
    methods: {
      login () {
        const { username, password } = this
        this.$store.dispatch(AUTH_REQUEST, { username, password }).then(() => {
          this.$router.push('/')
        });
      }
    },
  }
</script>