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

    <v-dialog v-model="resultEditDialog" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Edit Results</span>
        </v-card-title>
        <v-form ref="form" v-model="valid" lazy-validation>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex
              v-for="result in savedResults"
              :key="result.measure.id"
              xs12 sm12 md12>
                <v-text-field 
                  v-if="result.measure.measure_type.code === 'numeric'"
                  v-model="inputs[result.measure.id]"
                  v-on:change="onChange(result.measure.id)"
                  :label="result.measure.name">
                </v-text-field>
                <v-text-field
                  v-if="result.measure.measure_type.code === 'free_text'"
                  v-model="inputs[result.measure.id]"
                  v-on:change="onChange(result.measure.id)"
                  :label="result.measure.name">
                </v-text-field>
                <v-select
                  v-if="result.measure.measure_type.code === 'alphanumeric'"
                  :items="result.measure.measure_ranges"
                  v-model="inputs[result.measure.id]"
                  value="inputs[result.measure.id]"
                  item-text="display"
                  item-value="id"
                  v-on:change="onChange(result.measure.id)"
                  :label="result.measure.name"
                  overflow>
                </v-select>
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
              v-for="measure in measures"
              :key="measure.id"
              xs12 sm12 md12>          
                <v-text-field 
                  v-if="measure.measure_type.name === 'Numeric'"
                  v-model="inputs[measure.id]"
                  v-on:change="onChange(measure.id)"
                  :label="measure.name">
                </v-text-field>
                <v-text-field
                  v-if="measure.measure_type.name === 'Free Text'"
                  v-model="inputs[measure.id]"
                  v-on:change="onChange(measure.id)"
                  :label="measure.name">
                </v-text-field>
                <v-select
                  v-if="measure.measure_type.name === 'Alphanumeric'"
                  :items="measure.measure_ranges"
                  v-model="inputs[measure.id]"
                  value="inputs[measure.id]"
                  item-text="display"
                  v-on:change="onChange(measure.id)"
                  :label="measure.name"
                  overflow>
                </v-select>
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
      :items="controlTests"
      hide-actions
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.lot.number }}</td>
        <td class="text-xs-left">{{ props.item.lot.expiry }}</td>
        <td class="text-xs-left">{{ props.item.lot.instrument.name }}</td>
        <td class="text-xs-left">
          <v-chip v-if="props.item.control_test_status.name === 'Pending'" small color="info">Pending</v-chip>
          <v-chip v-if="props.item.control_test_status.name === 'Passed'" small color="green">Passed</v-chip>
          <v-chip v-if="props.item.control_test_status.name === 'Failed'" small color="red">Failed</v-chip>
        </td>
        <td class="justify-left layout px-0">
          <v-btn outline color="teal lighten-1" small flat @click="editItem(props.item)">
            Edit Test
            <v-icon right dark>edit</v-icon>
          </v-btn>
          <v-btn outline color="primary lighten-1" small flat @click="itemResults(props.item)"
            v-if="props.item.control_test_status.name === 'Pending'">
            Enter Results
            <v-icon right dark>input</v-icon>
          </v-btn>
          <v-btn outline color="success lighten-1" small flat @click="itemEditResults(props.item)"
            v-if="props.item.control_test_status.name !== 'Pending'">
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
  import apiCall from '../../utils/api'
  export default {
    data: () => ({
      valid: true,
      dialog: false,
      resultdialog: false,
      resultEditDialog: false,
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
      controlTests: [],
      lot: [],
      testTypes: [],
      measures: [],
      savedResults: [],
      results: {
        control_test_id: '',
        measures: {}
      },
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

      editItem (item) {

        this.editedIndex = this.controlTests.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      itemResults (item) {
        this.measures = item.test_type.measures

        this.editedIndex = this.controlTests.indexOf(item)
        this.results.control_test_id = item.id;

        this.editedItem = Object.assign({}, item)
        this.resultdialog = true
      },

      itemEditResults (item) {
        this.savedResults = item.control_results;
        // prepare models to attach saved values to
        for (var i = this.savedResults.length - 1; i >= 0; i--){

          if (this.savedResults[i].measure.measure_type.code == 'numeric'||
            this.savedResults[i].measure.measure_type.code == 'free_text') {
            this.inputs[this.savedResults[i].measure.id] = this.savedResults[i].result;

          }else if (this.savedResults[i].measure.measure_type.code == 'alphanumeric') {
            this.inputs[this.savedResults[i].measure.id] = this.savedResults[i].measure_range_id;

            this.onChange(this.savedResults[i].measure.id)
          }
        }

        this.editedIndex = this.controlTests.indexOf(item)
        this.results.control_test_id = item.id;

        this.editedItem = Object.assign({}, item)
        this.resultEditDialog = true
      },

      onChange (measure_id) {
         this.$nextTick(() => {
           this.results.measures[measure_id] = {
             // if alphanumeric
             measure_range_id: this.inputs[measure_id],
             // if numeric||freetext
             result: this.inputs[measure_id]
           };
         });
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

// update this dont make sense
      resetResultDialogReferences() {
        this.results = Object.assign({}, this.defaultResult)
        this.editedIndex = -1
      },

      createControlTest () {
        this.saving = true;
        // update
        if (this.editedIndex > -1) {
          apiCall({url: '/api/controltest/'+this.editedItem.id, data: this.editedItem, method: 'PUT' })
          .then(resp => {
            Object.assign(this.controlTests[this.editedIndex], this.editedItem)
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
            // this.controlTests.push(this.editedItem)
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

      saveResults () {
console.log('this.results')
console.log(this.results)
        apiCall({url: '/api/controlresult', data: this.results, method: 'POST' })
          .then(resp => {
            console.log('edited item')
            console.log(this.editedItem)
            console.log('after edit')
            console.log(this.editedIndex)
            this.save();
            this.resetResultDialogReferences();
            this.resultdialog = false;
        })
          .catch(error => {
            console.log(error.response)
        })
      }
    }
  }
</script>