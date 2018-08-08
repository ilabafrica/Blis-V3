<template>
  <div>
    <result ref="resultForm"></result>
    <v-dialog v-model="dialog" max-width="500px">
      <v-btn slot="activator" color="primary" dark class="mb-2">New Item</v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-form ref="form" v-model="valid" lazy-validation>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12 sm12 md12>
                <v-select
                  :items="lot"
                  v-model="editedItem.lot_id"
                  overflow
                  item-text="number"
                  item-value="id"
                  label="Lot">
                </v-select>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-select
                  :items="testTypes"
                  v-model="editedItem.test_type_id"
                  overflow
                  item-text="name"
                  item-value="id"
                  label="Test Type"
                ></v-select>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
          <v-btn color="blue darken-1" :disabled="!valid" flat @click.native="createControlTest">Save</v-btn>
        </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>

    <v-card-title>
      Tests
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
      :items="controlTests"
      hide-actions
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.lot.number }}</td>
        <td class="text-xs-left">{{ props.item.lot.expiry }}</td>
        <td class="text-xs-left">{{ props.item.lot.instrument.name }}</td>
        <td class="justify-left layout px-0">
          <v-btn outline color="teal lighten-1" small flat @click="editItem(props.item)">
            Edit Test
            <v-icon right dark>edit</v-icon>
          </v-btn>
          <v-btn outline color="primary lighten-1" small flat @click="enterResults(props.item)"
            v-if="props.item.control_test_status.code === 'pending'">
            Enter Results
            <v-icon right dark>input</v-icon>
          </v-btn>
          <v-btn outline color="success lighten-1" small flat @click="enterResults(props.item)"
            v-if="props.item.control_test_status.code === 'completed'">
            Edit Results
            <v-icon right dark>edit</v-icon>
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
  import { EventBus } from './../../app.js';
  import apiCall from '../../utils/api'
  import result from './result'
  export default {
    components: {
      result,
    },
    data: () => ({
      valid: true,
      dialog: false,
      delete: false,
      saving: false,
      search: '',
      query: '',
      pagination: {
        page: 1,
        per_page: 0,
        total: 0,
        visible: 10
      },
      headers: [
        { text: 'Lot Number', value: 'lot_id' },
        { text: 'Expiry Date', value: 'expiry' },
        { text: 'Instrument', value: 'name' },
        { text: 'Actions', value: 'name', sortable: false }
      ],
      measureheaders: [
        { text: 'Measure', value: 'measure' },
        { text: 'Value', value: 'value' }
      ],
      controlTests: [],
      lot: [],
      testTypes: [],
      inputs: [],
      editedIndex: -1,
      editedItem: {
        lot_id: 0,
        test_type_id: '',
        test_type_category_id: '',
      },
      defaultItem: {
        lot_id: 0,
        test_type_id: '',
        test_type_category_id: '',
      },
      defaultResult: ''
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
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

    mounted() {
      // Listen for the update-control-test-list event and its payload.
      EventBus.$on('update-control-test-list', data => {
        console.log('update-control-test-list')
        Object.assign(this.controlTests[this.editedIndex], data)
      });
    },

    methods: {

      initialize () {

        this.query = 'page='+ this.pagination.page;
        if (this.search != '') {
            this.query = this.query+'&search='+this.search;
        }

        apiCall({url: '/api/controltest?' + this.query, method: 'GET' })
        .then(resp => {
          console.log('resp')
          console.log(resp)
          this.controlTests = resp.data;
          this.pagination.total = resp.total;
        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/api/lot', method: 'GET' })
        .then(resp => {
          console.log('lot')
          console.log(resp)
          this.lot = resp.data;
        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/api/testtype', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.testTypes = resp.data;
        })
        .catch(error => {
          console.log(error.response)
        })
      },
      enterResults (test) {
        this.editedIndex = this.controlTests.indexOf(test)
        this.$refs.resultForm.modal(test);
      },

      editItem (item) {

        this.editedIndex = this.controlTests.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {

        confirm('Are you sure you want to delete this item?') && (this.delete = true)

        if (this.delete) {
          const index = this.controlTests.indexOf(item)
          this.controlTests.splice(index, 1)
          apiCall({url: '/api/controltest/'+item.id, method: 'DELETE' })
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

      createControlTest () {
        this.saving = true;
        // update
        if (this.editedIndex > -1) {
          apiCall({url: '/api/controltest/'+this.editedItem.id, data: this.editedItem, method: 'PUT' })
          .then(resp => {
            console.log('resp')
            console.log(resp)

            Object.assign(this.controlTests[this.editedIndex], resp)
            this.resetDialogReferences();
            this.saving = false;
          })
          .catch(error => {
            console.log(error.response)
          })

        // store
        } else {

          apiCall({url: '/api/controltest', data: this.editedItem, method: 'POST' })
          .then(resp => {
            this.controlTests.push(resp)
            console.log('resp')
            console.log(resp)
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