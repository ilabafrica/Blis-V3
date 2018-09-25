<template>
  <div>
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-toolbar dark color="primary" class="elevation-0">
          <v-toolbar-title> Drug Susceptibility Test Result</v-toolbar-title>
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
                      v-model="editedItem.antibiotic_id"
                      overflow
                      item-text="name"
                      item-value="id"
                      label="Antibiotic">
                    </v-select>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field
                      v-model="editedItem.zone_diameter"
                      label="Zone Diameter">
                    </v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-select
                      :items="susceptibilityRanges"
                      v-model="editedItem.susceptibility_range_id"
                      overflow
                      item-text="name"
                      item-value="id"
                      :rules="[v => !!v || 'Susceptibility is Required']"
                      label="Susceptibility">
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
    <v-card-title>
      Isolated Organism: <b> {{measureRange.display}}</b>
      <v-spacer></v-spacer>

      <v-btn
        outline
        small
        title="Add Break Point"
        color="red"
        flat
        @click="breakPoint()">
        Add Antibiotic
        <v-icon right dark>bug_report</v-icon>
      </v-btn>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="susceptibilities"
      hide-actions
      class="elevation-1">
      <template slot="items" slot-scope="props">
        <td class="text-xs-left">{{ props.item.antibiotic.name }}</td>
        <td class="text-xs-left">{{ props.item.zone_diameter }}</td>
        <td class="text-xs-left">{{ props.item.susceptibility_range.name }}</td>
        <td class="justify-left layout px-0">
          <v-btn
            outline
            small
            title="Delete"
            color="pink"
            flat
            @click="deleteItem(props.item)">
            Delete
            <v-icon right dark>delete</v-icon>
          </v-btn>
        </td>
      </template>
    </v-data-table>
  </div>
</template>
<script>
  import apiCall from '../../../utils/api'
  export default {
    data: () => ({
      valid: true,
      dialog: false,
      delete: false,
      saving: false,
      headers: [
        { text: 'Antibiotic', value: 'antibiotic' },
        { text: 'Zone Diameter', value: 'zone_diameter' },
        { text: 'Result', value: 'result' },
        { text: 'Actions', value: 'actions', sortable: false }
      ],
      susceptibilities: [],
      editedIndex: -1,
      antibiotics: [],
      measureRange: {},
      susceptibilityRanges: [],
      editedItem: {
        antibiotic_susceptibility_id: '',
        result_id: '',
        antibiotic_id: '',
        zone_diameter: '',
        susceptibility_range_id: '',
      },
      defaultItem: {
        result_id: '',
        antibiotic_id: '',
        zone_diameter: '',
        susceptibility_range_id: '',
      }
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Specimen' : 'Edit Specimen'
      },

    },

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    created () {
      this.initialize()
    },

    methods: {

      initialize () {

        apiCall({url: '/api/susceptibilityrange', method: 'GET' })
        .then(resp => {
          this.susceptibilityRanges = resp;
        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/api/antibiotic?measure_range_id='+this.$route.params.measureRangeId, method: 'GET' })
        .then(resp => {
          this.antibiotics = resp;
        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/api/measurerange/'+this.$route.params.measureRangeId, method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.measureRange = resp;
        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/api/antibioticsusceptibility?result_id='+this.$route.params.resultId, method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.susceptibilities = resp;
        })
        .catch(error => {
          console.log(error.response)
        })

      },

      deleteItem (item) {

        confirm('Are you sure you want to delete this item?') && (this.delete = true)

        if (this.delete) {
          const index = this.susceptibilities.indexOf(item)
          this.susceptibilities.splice(index, 1)
          apiCall({url: '/api/result/deletesusceptibility/'+item.id, method: 'GET' })
          .then(resp => {
            console.log(resp)
          })
          .catch(error => {
            console.log(error.response)
          })
        }

      },

      close () {
        this.dialog = false

        // if not saving reset dialog references to datatables
        if (!this.saving) {
          this.resetDialogReferences();
        }
      },

      resetDialogReferences() {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      },

      breakPoint() {
        this.dialog = true;
      },

      save () {

        this.saving = true;
        this.editedItem.result_id = this.$route.params.resultId;

        apiCall({url: '/api/result/susceptibility', data: this.editedItem, method: 'POST' })
        .then(resp => {
            this.susceptibilities.push(resp)
          console.log(resp)
          this.resetDialogReferences();
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