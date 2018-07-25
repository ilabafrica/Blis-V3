<template>
  <div>
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
                  label="Lot"
                ></v-select>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-select
                  :items="testtype"
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
          <v-btn color="blue darken-1" :disabled="!valid" flat @click.native="save">Save</v-btn>
        </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>

    <v-dialog v-model="resultdialog" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Enter Results</span>
        </v-card-title>
        <v-form ref="form" v-model="valid" lazy-validation>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex
              v-for="(measure, index) in measures"
              :key="index"
              xs12 sm12 md12>          
                <v-text-field 
                  v-if="measure.measure_type.name === 'Numeric'"
                  v-model="inputs[index]"
                  v-on:change="onChange(
                    index,
                    measure.id,
                    measure.control_test_id,
                    measure.measure_ranges,
                    inputs[index])"
                  :label="measure.name"
                >
                </v-text-field>
                <v-text-field
                  v-if="measure.measure_type.name === 'Free Text'"
                  v-model="inputs[index]"
                  v-on:change="onChange(
                    index,
                    measure.id,
                    measure.control_test_id,
                    measure.measure_ranges,
                    inputs[index])"
                  :label="measure.name"
                >
                </v-text-field>
                <v-select
                  v-if="measure.measure_type.name === 'Alphanumeric'"
                  :items="measure.measure_ranges"
                  v-model="inputs[index]"
                  item-text="display"
                  item-value="display"
                  v-on:change="onChange(
                    index,
                    measure.id,
                    measure.control_test_id,
                    measure.measure_ranges,
                    inputs[index])"
                  :label="measure.name"
                  overflow
                >
                </v-select>
                <v-select
                  v-if="measure.measure_type.name === 'Multi Alphanumeric'"
                  :items="measure.measure_ranges"
                  chips
                  attach
                  multiple
                  v-model="inputs[index]"
                  v-on:change="onChange(
                    index,
                    measure.id,
                    measure.control_test_id,
                    measure.measure_ranges,
                    inputs[index])"
                  :label="measure.name"
                  item-text="display"
                  item-value="display"
                ></v-select>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
          <v-btn color="blue darken-1" :disabled="!valid" flat @click.native="saveResults()">Save</v-btn>
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
      :items="controltest"
      hide-actions
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.lot.number }}</td>
        <td class="text-xs-left">{{ props.item.lot.expiry }}</td>
        <td class="text-xs-left">{{ props.item.lot.instrument.name }}</td>
        <td class="text-xs-left">
          <v-btn v-if="props.item.test_status_id === 1" color="error">Pending</v-btn>
          <v-btn v-if="props.item.test_status_id === 2" color="info">Started</v-btn>
          <v-btn v-if="props.item.test_status_id === 3" color="success">Completed</v-btn>
          <v-btn v-if="props.item.test_status_id === 4" color="warning">Verfied</v-btn>
        </td>
        <td class="justify-left layout px-0">
          <v-btn icon class="mx-0" @click="editItem(props.item)">
            <v-icon color="teal">edit</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" @click="deleteItem(props.item)">
            <v-icon color="pink">delete</v-icon>
          </v-btn>
          <v-btn v-if="props.item.time_started === null" depressed small @click="startItem(props.item)">Start</v-btn>
          <v-btn v-if="props.item.test_status_id === 2" depressed small color="primary" @click="itemResults(props.item)">Enter Results</v-btn>
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
      valid: true,
      dialog: false,
      resultdialog: false,
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
        { text: 'Status', value: '', sortable: false },
        { text: 'Actions', value: 'name', sortable: false }
      ],
      measureheaders: [
        { text: 'Measure', value: 'measure' },
        { text: 'Value', value: 'value' }
      ],
      controltest: [],
      lot: [],
      testtype: [],
      measures: [],
      results: [],
      inputs: [],
      editedIndex: -1,
      editedItem: {
        lot_id: 0,
        test_type_id: '',
        targetTAT: '',
        test_type_category_id: '',
      },
      defaultItem: {
        lot_id: 0,
        test_type_id: '',
        targetTAT: '',
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
          this.controltest = resp.data;
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
          this.testtype = resp.data;
        })
        .catch(error => {
          console.log(error.response)
        })
      },

      editItem (item) {
        this.editedIndex = this.controltest.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      itemResults (item) {
        console.log ('item edited')
        console.log (item)
        this.editedIndex = this.controltest.indexOf(item)
        this.measures = item.test_type.measures
        for (var i = this.measures.length - 1; i >= 0; i--){
          this.measures[i].control_test_id = item.id;
        }
        this.resultdialog = true
        console.log('check item')
        console.log(this.measures)
        /*this.editedItem = Object.assign({}, item)
        this.dialog = true*/
      },

      startItem (item) {
        this.editedIndex = this.controltest.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.editedItem.test_status_id = 2
        this.editedItem.time_started = 0
        apiCall({url: '/api/controltest/'+this.editedItem.id, data: this.editedItem, method: 'PUT' })
          .then(resp => {
            Object.assign(this.controltest[this.editedIndex], this.editedItem)
            console.log(resp)
            this.resetDialogReferences();
            this.saving = false;
          })
          .catch(error => {
            console.log(error.response)
          })
      },

      onChange (index,measure_id,control_test_id,measure_ranges_id,result) {
         console.log('on change');
         this.$nextTick(() => {
           this.results[index] = {
             measure_id: measure_id,
             control_test_id: control_test_id,
             measure_ranges_id: measure_ranges_id,
             result: this.inputs[index] 
           };
         });
         console.log(this.results);
       },

      deleteItem (item) {

        confirm('Are you sure you want to delete this item?') && (this.delete = true)

        if (this.delete) {
          const index = this.controltest.indexOf(item)
          this.controltest.splice(index, 1)
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

      resetResultDialogReferences() {
        this.results = Object.assign({}, this.defaultResult)
        this.editedIndex = -1
      },

      save () {

        this.saving = true;
        // update
        if (this.editedIndex > -1) {

          apiCall({url: '/api/controltest/'+this.editedItem.id, data: this.editedItem, method: 'PUT' })
          .then(resp => {
            Object.assign(this.controltest[this.editedIndex], this.editedItem)
            console.log(resp)
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
            this.controltest.push(this.editedItem)
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

      saveResults () {
        apiCall({url: '/api/controlresult', data: this.results, method: 'POST' })
          .then(resp => {
            console.log('before reset')
            console.log(this.results)
            this.resetResultDialogReferences();
            console.log('after reset')
            console.log(this.results)
            this.resultdialog = false;
          })
          .catch(error => {
            console.log(error.response)
          })
      }
    }
  }
</script>