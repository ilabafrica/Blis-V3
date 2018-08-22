<template>
  <div>
    <v-layout row justify-center>
      <v-btn color="primary" dark @click.stop="dialogTestType = true">New Test Type</v-btn>
      <v-dialog v-model="dialogTestType" max-width="500px">
        <v-card>
          <v-card-title>
            Test Details
          </v-card-title>
          <v-card-text>
            <v-flex xs12 sm12 md12>
              <v-text-field
                v-model="newTestType.name"
                :rules="[v => !!v || 'Name is Required']"
                label="Name">
              </v-text-field>
            </v-flex>
            <v-flex xs12 sm12 md12>
              <v-text-field
                v-model="newTestType.description"
                :rules="[v => !!v || 'Description is Required']"
                label="Description"
                multi-line>
              </v-text-field>
            </v-flex>
            <v-flex xs12 sm12 md12>
              <v-text-field
                v-model="newTestType.targetTAT"
                :rules="[v => !!v || 'Target Turnaround Time is Required']"
                label="Target Turnaround Time">
              </v-text-field>
            </v-flex>
            <v-flex xs12 sm12 md12>
              <v-select
                :items="testtypecategory"
                v-model="newTestType.test_type_category_id"
                overflow
                item-text="name"
                item-value="id"
                label="Lab Section"
              ></v-select>
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
      :items="testtypes"
      hide-actions
      class="elevation-1">
      <template slot="items" slot-scope="props">
        <td>{{ props.item.name }}</td>
        <td class="text-xs-left">{{ props.item.description }}</td>
        <td class="text-xs-left">{{ props.item.targetTAT }}</td>
        <td class="text-xs-left">{{ props.item.testtypecategory.name }}</td>
        <td class="justify-left layout px-0">
          <v-btn icon class="mx-0" @click="editItem(props.item)">
            <v-icon color="teal">edit</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" :to="'/testcatalog/measures/'+props.item.id">
            <v-icon color="green">list</v-icon>
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
  import apiCall from '../../../utils/api'
  export default {
    data: () => ({
      dialog: false,
      dialogTestType: false,
      valid: true,
      delete: false,
      saving: false,
      editLevel: 1,
      updating: false,
      measureRangeID: 0,
      RangeID: 0,

      newTestType: {
        name: '',
        description: '',
        test_type_category_id: '',
        targetTAT: '',
      },

      defaultItem: {
        name: '',
        description: '',
        test_type_category_id: '',
        targetTAT: '',
      },

      testtypemapping:[],
      gender: [],
      measure_types: [],
      testtypes: [],
      testtypecategory: [],
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
        { text: 'Description', value: 'description' },
        { text: 'Target Turnaround Time', value: 'targetTAT' },
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

        apiCall({url: '/api/testtypemapping', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.testtypemapping = resp;
        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/api/testtype?' + this.query, method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.testtypes = resp.data;
          this.pagination.per_page = resp.per_page;
          this.pagination.total = resp.total;
        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/api/gender?' + this.query, method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.gender = resp;
        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/api/testtypecategory', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.testtypecategory = resp.data;
        })
        .catch(error => {
          console.log(error.response)
        })
      },

      editItem (item) {
        this.updating = true
        this.editLevel = this.testtypes.indexOf(item)
        this.newTestType = Object.assign({}, item)
        this.dialogTestType = true
      },

      deleteItem (item) {

        confirm('Are you sure you want to delete this item?') && (this.delete = true)

        if (this.delete) {
          const index = this.testtypes.indexOf(item)
          this.testtypes.splice(index, 1)
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
        this.dialogTestType = false
        this.editLevel = 1
        // if not saving reset dialog references to datatables
        if (!this.saving) {
          this.resetDialogReferences();
        }
      },

      closeMainDialog () {
        this.dialog = false
        this.dialogTestType = false

        // if not saving reset dialog references to datatables
        if (!this.saving) {
          this.resetDialogReferences();
        }
      },

      resetDialogReferences() {
        this.newTestType = Object.assign({}, this.defaultItem)
        this.editLevel = 1
      },

      testTypeMapper: function(x){
        x = this.newTestType.id;
        this.testtypemapping = this.testtypemapping.filter(function(testID){
          return testID.test_type_id === x;
        })
      },

      saveTestType () {

        this.saving = true;
        // update
        if (this.updating) {
          apiCall({url: '/api/testtype/'+this.newTestType.id, data: this.newTestType, method: 'PUT' })
          .then(resp => {
            Object.assign(this.testtypes[this.editLevel], this.newTestType)
            console.log(resp)
            this.editLevel = 2;
          })
          .catch(error => {
            console.log(error.response)
          })

          this.testTypeMapper();

          this.specimen_type = _.map(this.testtypemapping, 'specimen_type_id');
          
          this.close()
          this.dialog = true;

        // store
        } else {

          apiCall({url: '/api/testtype', data: this.newTestType, method: 'POST' })
          .then(resp => {
            this.testtypes.push(this.newTestType)
            console.log(resp.testTypeId)
            this.newTestType.id = resp.testTypeId;
            this.editLevel = 2;
          })
          .catch(error => {
            console.log(error.response)
          })
          this.close()
        }
      },
    }
  }
</script>