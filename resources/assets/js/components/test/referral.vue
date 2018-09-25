<template>
  <div>
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-toolbar dark color="primary" class="elevation-0">
          <v-toolbar-title>Refer</v-toolbar-title>
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
                      :items="organizations"
                      v-model="referSpecimen.referred_to"
                      item-text="name"
                      item-value="id"
                      :rules="[v => !!v || 'Facility is Required']"
                      label="Facility"
                      overflow>
                    </v-select>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field
                      readonly
                      v-model="referSpecimen.time_dispatched_to"
                      :rules="[v => !!v || 'Time Dispatched is Required']"
                      label="Time Dispatched"
                      @click="datePicker = true">
                    </v-text-field>
                    <v-date-picker v-show="datePicker" v-model="referSpecimen.time_dispatched_to" :landscape="landscape" :reactive="reactive"></v-date-picker>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-select
                      v-bind:items="referralReasons"
                      v-model="referSpecimen.referralReasonIds"
                      label="Referral Reasons"
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
      datePicker: false,
      landscape: true,
      reactive: true,
      valid: true,
      dialog: false,
      organizations: [],
      referralReasons: [],
      referSpecimen: {
        test_id: '',
        specimen_id: '',
        referred_to: '',
        time_dispatched_to: '',
        referralReasonIds: [],
      }
    }),

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    methods: {

      initialize () {
        apiCall({url: '/api/referralreason', method: 'GET' })
          .then(resp => {
            this.referralReasons = resp;
            console.log(resp)
        }).catch(error => {
            console.log(error.response)
        })

        apiCall({url: '/api/organization', method: 'GET' })
          .then(resp => {
            this.organizations = resp.data;
            console.log(resp)
        }).catch(error => {
            console.log(error.response)
        })
      },

      modal (test) {
        this.initialize();
        this.referSpecimen.test_id = test.id;
        this.referSpecimen.specimen_id = test.specimen_id;
        this.dialog = true;
      },

      close () {
        this.dialog = false
      },

      save () {

          apiCall({url: '/api/test/specimenreferral', data: this.referSpecimen, method: 'POST' })
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
