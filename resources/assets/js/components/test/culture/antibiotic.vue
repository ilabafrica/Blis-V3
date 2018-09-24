<template>
  <div>
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-toolbar dark color="primary" class="elevation-0">
          <v-toolbar-title>Receive Specimen</v-toolbar-title>
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
                      :items="antibiotics"
                      v-model="breakPoint.antibiotic_id"
                      overflow
                      item-text="name"
                      item-value="id"
                      label="Antibiotic">
                    </v-select>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field
                      v-model="breakPoint.zone_diameter"
                      :rules="[v => !!v || 'Zone Diameter is Required']"
                      label="Zone Diameter">
                    </v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-select
                      :items="susceptibilityRanges"
                      v-model="breakPoint.susceptibility_range_id"
                      overflow
                      item-text="name"
                      item-value="id"
                      label="Susceptibility">
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
  import apiCall from '../../../utils/api'
  export default {
    data: () => ({
      landscape: true,
      reactive: true,
      valid: true,
      dialog: false,
      saving: false,
      antibiotics: [],
      susceptibilityRanges: [],
      culture: {},
      breakPoint: {
        antibiotic_id: '',
        zone_diameter: '',
        susceptibility_range_id: '',
      }
    }),

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    methods: {

      initialize () {

        apiCall({url: '/api/antibiotic', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.antibiotics = resp.data;
        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/api/susceptibilityrange', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.susceptibilityRanges = resp;
        })
        .catch(error => {
          console.log(error.response)
        })

      },

      modal (culture) {
        this.culture = culture;
        //get it
        // this.breakPoint.result_id = ;
        this.dialog = true;
      },

      close () {
        this.dialog = false
      },

      save () {

        this.saving = true;

        apiCall({url: '/api/test/breakPoint', data: this.breakPoint, method: 'POST' })
        .then(resp => {
          console.log(resp)
          this.saving = false;
        })
        .catch(error => {
          console.log(error.response)
        })

        this.close()
      }
    }
  }
</script>
