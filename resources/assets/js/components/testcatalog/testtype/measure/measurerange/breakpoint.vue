<template>
  <div>
    <v-dialog v-model="dialog" max-width="500px">
      <v-btn
        outline
        small
        color="primary"
        slot="activator"
        flat>
        New Item
        <v-icon right dark>playlist_add</v-icon>
      </v-btn>
      <v-card>
        <v-toolbar dark color="primary" class="elevation-0">
          <v-toolbar-title>{{ formTitle }}</v-toolbar-title>
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
                  :rules="[v => !!v || 'Antibiotic is Required']"
                  item-text="name"
                  item-value="id"
                  label="Antibiotic">
                </v-select>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="editedItem.resistant_max"
                  :rules="[v => !!v || 'Resistant Max is Required']"
                  label="Resistant Max">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="editedItem.intermediate_min"
                  :rules="[v => !!v || 'Intermediate Min is Required']"
                  label="Intermediate Min">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="editedItem.intermediate_max"
                  :rules="[v => !!v || 'Intermediate Max is Required']"
                  label="Intermediate Max">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="editedItem.sensitive_min"
                  :rules="[v => !!v || 'Sensitive Min is Required']"
                  label="Sensitive Min">
                </v-text-field>
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

    <v-card-title>
      Susceptibility Break Points
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Search"
        single-line
        v-on:keyup.enter="initialize"
        hide-details>
      </v-text-field>
    </v-card-title>

    <v-data-table
      :headers="headers"
      :items="breakPoints"
      hide-actions
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.antibiotic.name }}</td>
        <td class="text-xs-left">{{ props.item.resistant_max }}</td>
        <td class="text-xs-left">{{ props.item.intermediate_min }}</td>
        <td class="text-xs-left">{{ props.item.intermediate_max }}</td>
        <td class="text-xs-left">{{ props.item.sensitive_min }}</td>
        <td class="justify-left layout px-0">
          <v-btn
            outline
            small
            flat
            title="Edit"
            v-if="$can('manage_test_catalog')"
            color="teal"
            @click="editItem(row.item)">
            Edit
            <v-icon right dark>edit</v-icon>
          </v-btn>
          <v-btn
            outline
            small
            flat
            title="Edit"
            v-if="$can('manage_test_catalog')"
            color="pink"
            @click="deleteItem(row.item)">
            Delete
            <v-icon right dark>delete</v-icon>
          </v-btn>
        </td>
      </template>
    </v-data-table>
  </div>
</template>
<script>
  import apiCall from '../../../../../utils/api'
  export default {
    data: () => ({
      landscape: true,
      reactive: true,
      antibiotics: [],
      breakPoints: [],
      valid: true,
      dialog: false,
      delete: false,
      saving: false,
      search: '',
      headers: [
        { text: 'Antibiotic', value: 'antibiotic' },
        { text: 'Resistant Max', value: 'resistant_max' },
        { text: 'Intermediate Min', value: 'intermediate_min' },
        { text: 'Intermediate Max', value: 'intermediate_max' },
        { text: 'Sensitive Min', value: 'sensitive_min' },
        { text: 'Actions', value: 'name', sortable: false }
      ],
      editedIndex: -1,
      editedItem: {
        antibiotic_id: '',
        resistant_max: '',
        intermediate_min: '',
        intermediate_max: '',
        sensitive_min: '',
        measure_range_id: '',
      },
      defaultItem: {
        antibiotic_id: '',
        resistant_max: '',
        intermediate_min: '',
        intermediate_max: '',
        sensitive_min: '',
        measure_range_id: '',       
      }
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
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

        apiCall({url: '/api/measurerange/'+this.$route.params.measureRangeId, method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.breakPoints = resp.susceptibility_break_points;


        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/api/antibiotic', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.antibiotics = resp.data;
        })
        .catch(error => {
          console.log(error.response)
        })
      },

      editItem (item) {
        this.editedIndex = this.breakPoints.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {

        confirm('Are you sure you want to delete this item?') && (this.delete = true)

        if (this.delete) {
          const index = this.breakPoints.indexOf(item)
          this.breakPoints.splice(index, 1)
          apiCall({url: '/api/susceptibilitybreakpoint/'+item.id, method: 'DELETE' })
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

      save () {

        this.saving = true;
        // update
        if (this.editedIndex > -1) {

          apiCall({url: '/api/susceptibilitybreakpoint/'+this.editedItem.id, data: this.editedItem, method: 'PUT' })
          .then(resp => {
            Object.assign(this.breakPoints[this.editedIndex], this.editedItem)
            console.log(resp)
            this.resetDialogReferences();
            this.saving = false;
          })
          .catch(error => {
            console.log(error.response)
          })

        // store
        } else {

          apiCall({url: '/api/susceptibilitybreakpoint', data: this.editedItem, method: 'POST' })
          .then(resp => {
            this.breakPoints.push(this.editedItem)
            console.log(resp)
            this.resetDialogReferences();
            this.saving = false;
          })
          .catch(error => {
            console.log(error.response)
          })
        }
        this.close()

      }
    }
  }
</script>