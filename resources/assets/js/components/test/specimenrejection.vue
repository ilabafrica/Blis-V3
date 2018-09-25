<template>
  <div>
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-toolbar dark color="primary" class="elevation-0">
          <v-toolbar-title>Reject Specimen</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn round outline color="blue lighten-1" flat @click.native="close">
            Cancel
            <v-icon right dark>close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-form ref="form" v-model="valid" lazy-validation>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12 sm12 md12>
                    <v-select
                      v-bind:items="rejectionReasons"
                      v-model="specimenRejection.rejectionReasonIds"
                      label="Rejecion Reasons"
                      item-text="display"
                      item-value="id"
                      autocomplete multiple chips>
                    </v-select>
                  </v-flex>
                  <v-flex xs3 offset-xs9 text-xs-right>
                    <v-btn round outline xs12 sm6 color="blue darken-1" :disabled="!valid" @click.native="save">
                      Save <v-icon right dark>cloud_upload</v-icon>
                    </v-btn>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>
        </v-form>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  import { EventBus } from './../../app.js';
  import apiCall from '../../utils/api'
  export default {
    data: () => ({
      calendar: false,
      landscape: true,
      reactive: true,
      valid: true,
      dialog: false,
      saving: false,
      specimenRejection: {
        test_id: '',
        specimen_id: '',
        rejectionReasonIds: [],
      },
      rejectionReasons: [],
      test: {}
    }),

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    methods: {

      initialize () {
        apiCall({url: '/api/rejectionreason', method: 'GET' })
          .then(resp => {
            this.rejectionReasons = resp;
            console.log(resp)
        }).catch(error => {
            console.log(error.response)
        })
      },

      modal (test) {
        this.initialize()
        this.test = test;
        this.specimenRejection.test_id = test.id;
        this.specimenRejection.specimen_id = test.specimen_id;
        this.dialog = true;
      },

      close () {
        this.dialog = false

      },


      save () {
            console.log('this.specimenRejection')
            console.log(this.specimenRejection)

          apiCall({url: '/api/test/specimenrejection', data: this.specimenRejection, method: 'POST' })
          .then(resp => {
            console.log(resp)
            EventBus.$emit('update-test-list', resp);
          })
          .catch(error => {
            console.log(error.response)
          })
        this.close()

      }
    }
  }
</script>
