<template>
  <v-app id="inspire">
    <v-alert
      v-model="alert"
      outline
      align-right
      icon="warning"
      transition="scale-transition"
      color="error"
      dismissible>
      {{message}}
    </v-alert>
    <v-content>
      <v-container fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md5>
            <v-card class="elevation-4">
              <v-toolbar dark color="primary" class="elevation-0">
                <v-toolbar-title>BLIS</v-toolbar-title>
                <v-spacer></v-spacer>
              </v-toolbar>
              <v-form ref="form" v-model="valid" lazy-validation>
              <v-card-text>
                <v-text-field
                  v-model="username"
                  :rules="usernameRules"
                  prepend-icon="person"
                  name="username"
                  label="Email"
                  type="text">
                </v-text-field>
                <v-text-field
                  v-model="password"
                  prepend-icon="lock"
                  :rules="[v => !!v || 'Password is Required']"
                  name="password"
                  label="Password"
                  type="password">
                </v-text-field>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" :disabled="!valid" @click="login">
                  Login
                  <v-icon right dark>arrow_right</v-icon>
                </v-btn>
              </v-card-actions>
            </v-form>
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
        alert: false,
        valid: true,
        message: '',
        username: '',
        usernameRules: [
          v => !!v || 'E-mail is required',
          v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,5})+$/.test(v) || 'E-mail must be valid'
        ],
        password: '',
      };
    },
    methods: {
      login () {
        if (this.$refs.form.validate()) {
          const { username, password } = this
          this.$store.dispatch(AUTH_REQUEST, { username, password })
          .then((response) => {
            this.$router.push('/')
          }).catch((response) => {
            this.message = 'Wrong email or password';
            this.alert = true;
          });
        }
      }
    },
  }
</script>