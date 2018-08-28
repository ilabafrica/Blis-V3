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
                      :items="organisms"
                      v-model="isolatedOrganism.organism_id"
                      overflow
                      item-text="name"
                      :rules="[v => !!v || 'Isolated Organism by is Required']"
                      item-value="id"
                      label="Isolated Organism">
                    </v-select>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn round outline xs12 sm6 color="blue darken-1" :disabled="!valid" @click.native="save">
                Save <v-icon right dark>cloud_upload</v-icon>
              </v-btn>
            </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  import apiCall from '../../../utils/api'
  export default {
    data: () => ({
      valid: true,
      dialog: false,
      saving: false,
      organisms: [],
      measure: {},
      isolatedOrganism: {
        organism_id: '',
      }
    }),

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    methods: {

      initialize () {
        apiCall({url: '/api/measure/'+this.measure.id+'/measurerange', method: 'GET' })
          .then(resp => {
            this.organisms = resp;
            console.log(resp)
        }).catch(error => {
            console.log(error.response)
        })
      },

      modal (measure) {
        this.measure = measure;
        this.initialize()
        this.dialog = true;
      },

      close () {
        this.dialog = false
      },

      save () {

        this.saving = true;

        apiCall({url: '/api/test/specimencollection', data: this.specimenCollection, method: 'POST' })
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
