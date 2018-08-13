<template>
  <div>
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Reject Specimen</span>
        </v-card-title>
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
                </v-layout>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
              <v-btn color="blue darken-1" :disabled="!valid" flat @click.native="save">Reject Specimen</v-btn>
            </v-card-actions>
        </v-form>
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
          })
          .catch(error => {
            console.log(error.response)
          })
        this.close()

      }
    }
  }
</script>
