<template>
  <div>
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-toolbar dark color="primary" class="elevation-0">
          <v-toolbar-title>Test Details</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn round outline color="blue lighten-1" flat @click.native="close">
            Cancel
            <v-icon right dark>close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text v-if="test.id">
          <p><span class="grey--text pa-2">Test Num: </span>{{test.id}}</p>
          <p><span class="grey--text pa-2">Patient: </span>{{test.encounter.patient.name.text}}</p>
          <p><span class="grey--text pa-2">Specimen Type: </span>{{test.specimen.specimen_type.name}}</p>
          <p><span class="grey--text pa-2"></span>{{test.id}}</p>
          {{test}}
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
            <v-btn round outline xs12 sm6 color="blue darken-1" :disabled="!valid" @click.native="verify">
              <!-- if completed and permissions right -->
              Verify <v-icon right dark>check_circle_outline</v-icon>
            </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  import apiCall from '../../utils/api'
  export default {
    data: () => ({
      calendar: false,
      landscape: true,
      reactive: true,
      valid: true,
      dialog: false,
      test: {}
    }),

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    methods: {

      modal (test) {
        this.test = test;
        this.dialog = true;
      },

      verify () {
        apiCall({url: '/api/test/verify/'+this.test.id, method: 'GET' })
        .then(resp => {
          console.log(resp)
        })
        .catch(error => {
          console.log(error.response)
        })
        this.close()
      },

      close () {
        this.dialog = false
      },
    }
  }
</script>
