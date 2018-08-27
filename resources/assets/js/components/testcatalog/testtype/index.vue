<template>
  <div>
    <v-layout row justify-center>
      <v-btn color="primary" dark @click.stop="dialog = true">New Test Type</v-btn>
      <v-dialog v-model="dialog" max-width="500px">
        <v-card>
          <v-card-title>
            Test Details
          </v-card-title>
          <v-card-text>
            <v-flex xs12 sm12 md12>
              <v-text-field
                v-model="editedItem.name"
                :rules="[v => !!v || 'Name is Required']"
                label="Name">
              </v-text-field>
            </v-flex>
            <v-flex xs12 sm12 md12>
              <v-text-field
                v-model="editedItem.description"
                :rules="[v => !!v || 'Description is Required']"
                label="Description">
              </v-text-field>
            </v-flex>
            <v-flex xs12 sm12 md12>
              <v-text-field
                v-model="editedItem.targetTAT"
                :rules="[v => !!v || 'Target Turnaround Time is Required']"
                label="Target Turnaround Time">
              </v-text-field>
            </v-flex>
            <v-flex xs12 sm12 md12>
              <v-select
                :items="testTypeCategories"
                v-model="editedItem.test_type_category_id"
                overflow
                item-text="name"
                item-value="id"
                label="Lab Section"
              ></v-select>
            </v-flex>
            <v-flex xs12 sm12 md12>
              <v-checkbox
                v-model="editedItem.culture"
                value="1"
                label="Use Culture Options">
              </v-checkbox>
            </v-flex>
          </v-card-text>
          <v-card-actions>
            <v-btn color="primary" flat @click.stop="closeMainDialog">Close</v-btn>
            <v-btn color="blue darken-1" :disabled="!valid" flat @click.native="saveTestType">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
    <v-card-title>
      Test Type
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
      :items="testTypes"
      hide-actions
      class="elevation-1">
      <template slot="items" slot-scope="props">
        <td>{{ props.item.name }}</td>
        <td class="text-xs-left">{{ props.item.test_type_category.name }}</td>
        <td class="justify-left layout px-0">
          <v-btn
            outline
            small
            title="View"
            color="green"
            flat
            @click="view(props.item)">
            View
            <v-icon right dark>visibility</v-icon>
          </v-btn>
          <v-btn
            outline
            small
            title="View"
            color="teal"
            flat
            @click="editItem(props.item)">
            Edit
            <v-icon right dark>edit</v-icon>
          </v-btn>
          <v-btn
            outline
            small
            :to="{ name: 'TestTypeSpecimenType', params: { testTypeId:props.item.id} }"
            title="Specimen Types"
            color="green"
            flat
            v-if="$can('manage_test_catalog')">
            Specimen Types
            <v-icon right dark>list</v-icon>
          </v-btn>
          <v-btn
            outline
            small
            :to="{ name: 'Measure', params: { testTypeId:props.item.id} }"
            title="Measures"
            color="blue"
            flat
            v-if="$can('manage_test_catalog')">
            Measures
            <v-icon right dark>list</v-icon>
          </v-btn>
          <v-btn
            outline
            small
            title="Delete"
            color="pink"
            v-if="$can('manage_test_catalog')"
            flat
            @click="deleteItem(props.item)">
            Delete
            <v-icon right dark>delete</v-icon>
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
  import apiCall from '../../../utils/api'
  export default {
    data: () => ({
      dialog: false,
      valid: true,
      delete: false,
      saving: false,
      editedIndex: -1,
      editedItem: {
        name: '',
        description: '',
        test_type_category_id: '',
        targetTAT: '',
        culture: 0,
      },
      defaultItem: {
        name: '',
        description: '',
        test_type_category_id: '',
        targetTAT: '',
        culture: 0,
      },
      testTypes: [],
      testTypeCategories: [],
      items: [],
      
      search: '',
      query: '',
      pagination: {
        page: 1,
        per_page: 0,
        total: 0,
        visible: 10
      },
      headers: [
        { text: 'Name', value: 'name' },
        { text: 'Test Category', value: 'test_type_category_id' },
        { text: 'Actions', value: 'name', sortable: false }
      ],
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
      },

      length: function() {
        return Math.ceil(this.pagination.total / this.pagination.per_page);
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

        apiCall({url: '/api/testtype?' + this.query, method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.testTypes = resp.data;
          this.pagination.per_page = resp.per_page;
          this.pagination.total = resp.total;
        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/api/testtypecategory', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.testTypeCategories = resp.data;
        })
        .catch(error => {
          console.log(error.response)
        })
      },

      editItem (item) {
        this.editedIndex = this.testTypes.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {

        confirm('Are you sure you want to delete this item?') && (this.delete = true)

        if (this.delete) {
          const index = this.testTypes.indexOf(item)
          this.testTypes.splice(index, 1)
          apiCall({url: '/api/testtype/'+item.id, method: 'DELETE' })
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
        if (!this.saving) {
          this.resetDialogReferences();
        }
      },

      resetDialogReferences() {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editLevel = 1
      },

      saveTestType () {

        this.saving = true;
        // update
        if (this.editedIndex > -1) {
          apiCall({url: '/api/testtype/'+this.editedItem.id, data: this.editedItem, method: 'PUT' })
          .then(resp => {
            Object.assign(this.testTypes[this.editedIndex], resp)
            console.log(resp)
            this.resetDialogReferences();
            this.saving = false;

          })
          .catch(error => {
            console.log(error.response)
          })

        // store
        } else {

          apiCall({url: '/api/testtype', data: this.editedItem, method: 'POST' })
          .then(resp => {
            this.testTypes.push(resp)
            this.resetDialogReferences();
            this.saving = false;
          })
          .catch(error => {
            console.log(error.response)
          })
        }
        this.close()
      },
    }
  }
</script>