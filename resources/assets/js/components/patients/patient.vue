<template>
  <div>
    <v-dialog v-model="dialog" max-width="500px">
      <v-btn slot="activator" color="primary" dark class="mb-2">New Patient</v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-form ref="form" v-model="valid" lazy-validation>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="editedItem.identifier"
                  :rules="[v => !!v || 'Patient No. is Required']"
                  label="Patient No.">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field v-if="editedIndex > -1"
                  v-model="editedItem.name.given"
                  :rules="[v => !!v || 'Given Name is Required']"
                  label="Given Name">
                </v-text-field>
                <v-text-field v-if="editedIndex === -1"
                  v-model="editedItem.given"
                  :rules="[v => !!v || 'Given Name is Required']"
                  label="Given Name">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field v-if="editedIndex > -1"
                  v-model="editedItem.name.family"
                  :rules="[v => !!v || 'Family Name is Required']"
                  label="Family Name">
                </v-text-field>
                <v-text-field v-if="editedIndex === -1"
                  v-model="editedItem.family"
                  :rules="[v => !!v || 'Family Name is Required']"
                  label="Family Name">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                Gender
                <v-radio-group v-if="editedIndex > -1"
                  v-model="editedItem.gender.display" row
                  >
                  <v-radio label="Male" value="Male"></v-radio>
                  <v-radio label="Female" value="Female"></v-radio>
                </v-radio-group>
                <v-radio-group v-if="editedIndex === -1"
                  v-model="editedItem.gender" row
                  >
                  <v-radio label="Male" value="Male"></v-radio>
                  <v-radio label="Female" value="Female"></v-radio>
                </v-radio-group>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  readonly
                  v-model="editedItem.birth_date"
                  :rules="[v => !!v || 'Date of Birth is Required']"
                  label="Date of Birth"
                  @click="showCalendar()">
                </v-text-field>
                <v-date-picker v-show="calendar" v-model="editedItem.birth_date" :landscape="landscape" :reactive="reactive"></v-date-picker>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
          <v-btn color="blue darken-1" :disabled="!valid" flat @click.native="save">Save</v-btn>
        </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>

    <v-card-title>
      Patients
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
      :items="patient"
      hide-actions
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.identifier }}</td>
        <td class="text-xs-left"> {{ props.item.name.given }}
                                  {{ props.item.name.family }}</td>
        <td class="text-xs-left">{{ props.item.gender.display }}</td>
        <td class="text-xs-left">{{ props.item.birth_date }}</td>
        <td class="justify-left layout px-0">
          <v-btn icon class="mx-0" @click="editItem(props.item)">
            <v-icon color="teal">edit</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" @click="deleteItem(props.item)">
            <v-icon color="pink">delete</v-icon>
          </v-btn>
        </td>
      </template>
    </v-data-table>
    <div class="text-xs-center">
      <v-pagination
        :length="length"
        :total-visible="pagination.visible"
        v-model="pagination.page"
        @input="initialize"
        circle>
      </v-pagination>
    </div>
  </div>
</template>
<script>
  import apiCall from '../../utils/api'
  export default {
    data: () => ({
      calendar: false,
      valid: true,
      dialog: false,
      delete: false,
      saving: false,
      landscape: true,
      reactive: true,
      dropdown_gender: ['Female', 'Male'],
      search: '',
      query: '',
      pagination: {
        page: 1,
        per_page: 0,
        total: 0,
        visible: 10
      },
      headers: [
        { text: 'Patient No.', value: 'patientno' },
        { text: 'Name', value: 'name' },
        { text: 'Gender', value: 'gender' },
        { text: 'Date of Birth', value: 'birth_date' },
        { text: 'Actions', value: 'name', sortable: false }
      ],
      patient: [],
      editedIndex: -1,
      editedItem: {
        identifier: '',
        name: '',
        gender: '',
        birth_date: '',

      },
      defaultItem: {
        identifier: '',
        name: '',
        gender: '',
        birth_date: '',

      }
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Patient' : 'Edit Patient Details'
      },

      length: function() {
        return Math.ceil(this.pagination.total / 10);
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

        this.query = 'page='+ this.pagination.page;
        if (this.search != '') {
            this.query = this.query+'&search='+this.search;
        }

        apiCall({url: '/api/patient?' + this.query, method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.patient = resp.data;
          this.pagination.total = resp.total;
        })
        .catch(error => {
          console.log(error.response)
        })
      },

      showCalendar(){
        this.calendar = true
      },

      editItem (item) {
        this.editedIndex = this.patient.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {

        confirm('Are you sure you want to delete this item?') && (this.delete = true)

        if (this.delete) {
          const index = this.patient.indexOf(item)
          this.patient.splice(index, 1)
          apiCall({url: '/api/patient/'+item.id, method: 'DELETE' })
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
        this.calendar = false
      },

      save () {

        this.saving = true;
        // update
        if (this.editedIndex > -1) {

          apiCall({url: '/api/patient/'+this.editedItem.id, data: this.editedItem, method: 'PUT' })
          .then(resp => {
            Object.assign(this.patient[this.editedIndex], this.editedItem)
            console.log(resp)
            this.resetDialogReferences();
            this.saving = false;
          })
          .catch(error => {
            console.log(error.response)
          })

        // store
        } else {

          apiCall({url: '/api/patient', data: this.editedItem, method: 'POST' })
          .then(resp => {
            this.patient.push(this.editedItem)
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