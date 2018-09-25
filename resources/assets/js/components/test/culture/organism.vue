<template>
  <div>
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-toolbar dark color="primary" class="elevation-0">
          <v-toolbar-title>Add Organism Isolated</v-toolbar-title>
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
                      :items="measureRanges"
                      v-model="result.measure_range_id"
                      overflow
                      item-text="display"
                      :rules="[v => !!v || 'Isolated Organism by is Required']"
                      item-value="id"
                      label="Isolated Organism">
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
  import { EventBus } from './../../../app.js'
  import apiCall from '../../../utils/api'
  export default {
    data: () => ({
      valid: true,
      dialog: false,
      saving: false,
      measureRanges: [],
      measure: {},
      result: {
        test_id: '',
        measure_id: '',
        measure_range_id: '',
      },
    }),

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    methods: {

      modal (measureId,testId) {
        this.result.test_id = testId;
        this.result.measure_id = measureId;

        apiCall({url: '/api/measure/'+measureId+'/measurerange', method: 'GET' })
          .then(resp => {
            console.log(resp)
            this.measureRanges = resp;
            this.dialog = true;
        }).catch(error => {
            console.log(error.response)
        })
      },

      close () {
        this.dialog = false
      },

      save () {

        this.saving = true;

        apiCall({url: '/api/result', data: this.result, method: 'POST' })
          .then(resp => {
            console.log(resp)
            EventBus.$emit('update-isolated-organism-list', resp);
            this.dialog = false;
        })
          .catch(error => {
            console.log(error.response)
        })
        this.close()
      }
    }
  }
</script>
