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
                <v-overflow-btn
                  :items="suppliers"
                  v-model="editedItem.supplier_id"
                  item-text="name"
                  item-value="id"
                  label="Supplier"
                ></v-overflow-btn>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="editedItem.name"
                  :rules="[v => !!v || 'Name is Required']"
                  label="Name">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="editedItem.unit"
                  :rules="[v => !!v || 'Unit is Required']"
                  label="Unit">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="editedItem.min"
                  :rules="[v => !!v || 'Min. Level is Required']"
                  label="Min. Level">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="editedItem.max"
                  :rules="[v => !!v || 'Max. Level is Required']"
                  label="Max. Level">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="editedItem.storage_req"
                  :rules="[v => !!v || 'Storage Req. is Required']"
                  label="Storage Req.">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="editedItem.remarks"
                  :rules="[v => !!v || 'Remarks is Required']"
                  label="Remarks">
                </v-text-field>
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
    <v-dialog v-model="issueDialog" max-width="1200px">
      <v-card>
        <v-card-title>
          <span class="headline">Issue Stock Items</span>
        </v-card-title>
        <v-form ref="form" v-model="valid" lazy-validation>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs8 sm8 md8>
                  <v-flex xs12 sm12 md12>
                    <v-data-table
                      :headers="requestheaders"
                      :items="request"
                      hide-actions
                      class="elevation-1"
                    >
                      <template slot="items" slot-scope="props">
                        <td>
                          <v-radio-group
                            v-model="requestItem.request_id"
                            :rules="[v => !!v || 'Request ID is Required']"
                            name="rowSelector">
                            <v-radio :value="props.item.id"/>
                          </v-radio-group>
                        </td>
                        <td class="text-xs-left">{{ props.item.user.name }}</td>
                        <td class="text-xs-left">{{ props.item.lab.name }}</td>
                        <td class="text-xs-left">{{ props.item.quantity_requested }}</td>
                        <td class="text-xs-left">{{ props.item.quantity_issued }}</td>
                        <td class="text-xs-left">{{ props.item.remarks }}</td>
                      </template>
                    </v-data-table>
                  </v-flex>
                  <v-flex xs6 sm6 md6>
                    <v-text-field
                      readonly
                      v-model="requestItem.stock_id"
                      :rules="[v => !!v || 'Stock ID is Required']"
                      label="Stock ID">
                    </v-text-field>
                  </v-flex>
                  <v-flex xs6 sm6 md6>
                    <v-text-field
                      v-model="requestItem.quantity"
                      :rules="[v => !!v || 'Quantity Signed Out is Required']"
                      label="Quantity Signed Out">
                    </v-text-field>
                  </v-flex>
                  <v-flex xs6 sm6 md6>
                    <v-text-field
                      readonly
                      v-model="requestItem.date_issued"
                      :rules="[v => !!v || 'Date Signed Out is Required']"
                      label="Date Signed Out"
                      @click="showIssueCalendar()">
                    </v-text-field>
                    <v-date-picker v-show="issue_calendar" v-model="requestItem.date_issued" :landscape="landscape" :reactive="reactive"></v-date-picker>
                  </v-flex>
                  <v-flex xs6 sm6 md6>
                    <v-text-field
                      v-model="requestItem.received_by"
                      :rules="[v => !!v || 'Received By is Required']"
                      label="Received By">
                    </v-text-field>
                  </v-flex>
                  <v-flex xs6 sm6 md6>
                    <v-text-field
                      v-model="requestItem.remarks"
                      :rules="[v => !!v || 'Remarks is Required']"
                      label="Remarks">
                    </v-text-field>
                  </v-flex>
              </v-flex>
              <v-flex xs4 sm4 md4>
                <v-flex xs12 sm12 md12>
                  Item: {{itemdetails.name}}
                </v-flex>
                <v-flex xs12 sm12 md12>
                  Units: {{itemdetails.unit}}
                </v-flex>
                <v-flex xs12 sm12 md12>
                  Lot No.: {{stockItem.lot_no}}
                </v-flex>
                <v-flex xs12 sm12 md12>
                  Available Quantity: {{itemdetails.stockValue}}
                </v-flex>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.native="resetIssueDialogReferences">Cancel</v-btn>
          <v-btn color="blue darken-1" :disabled="!valid" flat @click.native="saveIssueStock">Save</v-btn>
        </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
    <v-dialog v-model="addStock" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Receive New Medical Stock</span>
        </v-card-title>
        <v-form ref="form" v-model="valid" lazy-validation>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="stockItem.item_id"
                  readonly
                  label="Item">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="stockItem.lot_no"
                  :rules="[v => !!v || 'Lot no. is Required']"
                  label="Lot no.">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="stockItem.batch_no"
                  :rules="[v => !!v || 'Batch no. is Required']"
                  label="Batch no.">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  readonly
                  v-model="stockItem.expiry_date"
                  :rules="[v => !!v || 'Expiry Date is Required']"
                  label="Expiry Date"
                  @click="showExpCalendar()">
                </v-text-field>
                <v-date-picker v-show="expiry_calendar" v-model="stockItem.expiry_date" :landscape="landscape" :reactive="reactive"></v-date-picker>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="stockItem.manufacturer"
                  :rules="[v => !!v || 'Manufacturer is Required']"
                  label="Manufacturer">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-select
                  :items="suppliers"
                  v-model="stockItem.supplier_id"
                  overflow
                  item-text="name"
                  item-value="id"
                  label="Supplier"
                ></v-select>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="stockItem.quantity_supplied"
                  :rules="[v => !!v || 'Quantity Supplied is Required']"
                  label="Quantity Supplied">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="stockItem.cost_per_unit"
                  :rules="[v => !!v || 'Cost Per Unit is Required']"
                  label="Cost Per Unit">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  readonly
                  v-model="stockItem.date_received"
                  :rules="[v => !!v || 'Date Received is Required']"
                  label="Date Received"
                  @click="showRecCalendar()">
                </v-text-field>
                <v-date-picker v-show="rec_calendar" v-model="stockItem.date_received" :landscape="landscape" :reactive="reactive"></v-date-picker>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="stockItem.remarks"
                  :rules="[v => !!v || 'Remarks is Required']"
                  label="Remarks">
                </v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.native="resetStockDialogReferences">Cancel</v-btn>
          <v-btn color="blue darken-1" :disabled="!valid" flat @click.native="saveStock">Save</v-btn>
        </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
    <v-dialog v-model="receiveDialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click.native="receiveDialog = false">
            <v-icon>close</v-icon>
          </v-btn>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn dark flat @click.native="addStock = true">Add new Stock</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-data-table
          :headers="stockheaders"
          :items="stock"
          hide-actions
          class="elevation-1"
        >
          <template slot="items" slot-scope="props">
            <td>{{ props.item.lot_no }}</td>
            <td class="text-xs-left">{{ props.item.batch_no }}</td>
            <td class="text-xs-left">{{ props.item.manufacturer }}</td>
            <td class="text-xs-left">{{ props.item.quantity_supplied }}</td>
            <td class="text-xs-left">{{ props.item.quantity_issued }}</td>
            <td class="text-xs-left">{{ props.item.balance }}</td>
            <td class="text-xs-left">{{ props.item.expiry_date }}</td>
            <td class="justify-left layout px-0">
              <v-btn
                outline
                small
                title="Edit"
                color="teal"
                flat
                @click="editItem(props.item)">
                Edit
                <v-icon right dark>edit</v-icon>
              </v-btn>
              <v-btn
                outline
                small
                title="Edit"
                color="warning"
                flat
                @click="issueItem(props.item)">
                Issue Stock
                <v-icon right dark>done_all</v-icon>
              </v-btn>
            </td>
          </template>
        </v-data-table>
      </v-card>
    </v-dialog>
    <v-card-title>
      Items
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
      :items="item"
      hide-actions
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.name }}</td>
        <td class="text-xs-left">{{ props.item.unit }}</td>
        <td class="text-xs-left">{{ props.item.min }}</td>
        <td class="text-xs-left">{{ props.item.max }}</td>
        <td class="text-xs-left">{{ props.item.storage_req }}</td>
        <td class="text-xs-left">{{ props.item.remarks }}</td>
        <td class="text-xs-left">{{ props.item.stockValue }}</td>
        <td class="justify-left layout px-0">
          <v-btn
            outline
            small
            title="Edit"
            color="teal"
            flat
            @click="editItem(props.item)">
            Edit
            <v-icon right dark>edit</v-icon>
          </v-btn>
          <v-btn
            outline
            small
            title="Edit"
            color="green"
            flat
            @click="itemStock(props.item)">
            Log Stock Usage
            <v-icon right dark>book</v-icon>
          </v-btn>
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
  import Vue from "vue";
  export default {
    name:'InventoryItem',
    data: () => ({
      expiry_calendar: false,
      rec_calendar: false,
      issue_calendar: false,
      valid: true,
      dialog: false,
      issueDialog: false,
      delete: false,
      saving: false,
      receiveDialog: false,
      addStock: false,
      landscape: true,
      reactive: true,
      suppliers: [],
      itemdetails: [],
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
        { text: 'Unit', value: 'unit' },
        { text: 'Min. Level', value: 'min' },
        { text: 'Max. Level', value: 'max' },
        { text: 'Storage Req.', value: 'storage_req' },
        { text: 'Remarks', value: 'remarks' },
        { text: 'Quantity', value: 'quantity' },
        { text: 'Actions', value: 'name', sortable: false }
      ],
      stockheaders: [
        { text: 'Lot No.', value: 'lot_no' },
        { text: 'Batch No.', value: 'batch_no' },
        { text: 'Manufacturer', value: 'manufacturer' },
        { text: 'Quantity Supplied', value: 'quantity_supplied' },
        { text: 'Quantity Issued', value: 'quantity_issued' },
        { text: 'Balance', value: 'balance' },
        { text: 'Expiry Date', value: 'expiry_date' },
        { text: 'Actions', value: 'name', sortable: false }
      ],
      requestheaders: [
        { text: 'Selection', value: 'selection' },
        { text: 'Requested By', value: 'requested_by' },
        { text: 'Lab Section', value: 'lab_section' },
        { text: 'Quantity Requested', value: 'quantity_requested' },
        { text: 'Quantity Issued', value: 'quantity_issued' },
        { text: 'Remarks', value: 'remarks' }
      ],
      item: [],
      stock: [],
      request: [],
      editedIndex: -1,
      requestItem: {
        stock_id: '',
        request_id: '',
        quantity: '',
        date_issued: '',
        issued_by: '',
        received_by: '',
        remarks: '',
      },
      defaultrequestItem: {
        stock_id: '',
        request_id: '',
        quantity: '',
        date_issued: '',
        issued_by: '',
        received_by: '',
        remarks: '',
      },
      stockItem: {
        stock_id: '',
        item_id: '',
        lot_no: '',
        batch_no: '',
        expiry_date: '',
        manufacturer: '',
        supplier_id: '',
        quantity_supplied: '',
        cost_per_unit: '',
        date_received: '',
        remarks: '',
      },
      defaultstockItem: {
        item_id: '',
        lot_no: '',
        batch_no: '',
        expiry_date: '',
        manufacturer: '',
        supplier_id: '',
        quantity_supplied: '',
        cost_per_unit: '',
        date_received: '',
        remarks: '',
      },
      editedItem: {
        supplier_id: '',
        name: '',
        unit: '',
        min: '',
        max: '',
        storage_req: '',
        remarks: '',
      },
      defaultItem: {
        supplier_id: '',
        name: '',
        unit: '',
        min: '',
        max: '',
        storage_req: '',
        remarks: '',
      }
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

        apiCall({url: '/item?' + this.query, method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.item = resp.data;
          this.pagination.total = resp.total;
        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/supplier', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.suppliers = resp.data;
        })
        .catch(error => {
          console.log(error.response)
        })
      },

      showExpCalendar(){
        this.expiry_calendar = true
      },

      showRecCalendar(){
        this.rec_calendar = true
      },

      showIssueCalendar(){
        this.issue_calendar = true
      },

      editItem (item) {
        this.editedIndex = this.item.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      itemStock(item){
        this.stockItem.item_id = item.id

        apiCall({url: '/stockDetails/'+item.id, method: 'GET' })
        .then(resp => {
          let stock = resp
          
          console.log("Stock history response is:",resp) 
          Vue.set(this,"stock",stock)
          //this.request = resp.data.request;
          //console.log('requests')
          //console.log(resp)
          //this.pagination.total = resp.total;
        })
        .catch(error => {
          console.log(error.response)
        })
        this.itemdetails = item
        console.log("item")
        console.log(this.itemdetails)
        this.receiveDialog = true
      },

      issueItem(item){
        this.requestItem.stock_id = item.id
        apiCall({url: '/requestIssue/'+item.item_id, method: 'GET' })
        .then(resp => {
          let request = resp
          Vue.set(this,"request",request)
          //this.request = resp.data.request;
          console.log('requests')
          console.log(resp)
          //this.pagination.total = resp.total;
        })
        .catch(error => {
          console.log(error.response)
        })
        //console.log("Stock history response is:",this.itemdetails) 
        this.issueDialog = true
      },

      deleteItem (item) {

        confirm('Are you sure you want to delete this item?') && (this.delete = true)

        if (this.delete) {
          const index = this.item.indexOf(item)
          this.item.splice(index, 1)
          apiCall({url: '/api/item/'+item.id, method: 'DELETE' })
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

      resetStockDialogReferences() {
        this.stockItem = Object.assign({}, this.defaultstockItem)
        this.addStock = false
      },

      resetIssueDialogReferences() {
        this.requestItem = Object.assign({}, this.defaultrequestItem)
        this.issueDialog = false
      },

      save () {

        this.saving = true;
        // update
        if (this.editedIndex > -1) {

          apiCall({url: '/item/'+this.editedItem.id, data: this.editedItem, method: 'PUT' })
          .then(resp => {
            Object.assign(this.item[this.editedIndex], this.editedItem)
            console.log(resp)
            this.resetDialogReferences();
            this.saving = false;
          })
          .catch(error => {
            console.log(error.response)
          })

        // store
        } else {

          apiCall({url: '/item', data: this.editedItem, method: 'POST' })
          .then(resp => {
            this.item.push(this.editedItem)
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

      saveStock () {
        apiCall({url: '/stock', data: this.stockItem, method: 'POST' })
          .then(resp => {
            this.stock.push(this.stockItem)
            console.log(resp)
            this.resetStockDialogReferences();
            //this.saving = false;
          })
          .catch(error => {
            console.log(error.response)
        })
      },

      saveIssueStock () {
        apiCall({url: '/issueStock', data: this.requestItem, method: 'POST' })
          .then(resp => {
            console.log(resp)
            this.resetIssueDialogReferences();
            //this.saving = false;
          })
          .catch(error => {
            console.log(error.response)
        })
      }
    }
  }
</script>