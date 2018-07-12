<template>
  <div>

<v-layout row justify-center>
      <v-btn color="primary" dark @click.stop="dialog = true">New Test Type</v-btn>
      <v-dialog
        v-model="dialog"
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition"
        scrollable
      >
        <v-card tile>
          <v-toolbar card dark color="primary">
            <v-btn icon dark @click.native="closeMainDialog">
              <v-icon>close</v-icon>
            </v-btn>
            <v-toolbar-title>{{ newTest.name }}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn v-if="editLevel === 2" dark flat @click.native="saveSpecimenTypes">Next</v-btn>
              <v-btn v-if="editLevel === 3" dark flat @click.native="saveMeasureDetails">Save</v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-card-text>
            <v-btn color="primary" dark @click.stop="dialog2 = !dialog2" v-if="editLevel === 1">Enter Test Details</v-btn>

            <v-container 
              v-if="editLevel > 1">
              <v-divider></v-divider>
                <v-list-tile-title
                  v-if="editLevel === 2"
                >Specimen Types</v-list-tile-title>
                  <v-divider></v-divider>
                    <v-data-table
                      :items="specimentypes"
                      hide-actions
                      v-if="editLevel === 2">
                      <template slot="items" slot-scope="row">
                        <tr :key="row.item.id">
                          <td>{{row.item.name}}</td>
                          <td>
                            <v-checkbox
                              v-model="specimen_type"
                              :value="row.item.id">
                            </v-checkbox>
                          </td>
                        </tr>
                      </template>
                    </v-data-table>

              
              <v-divider></v-divider>
              <v-layout row wrap v-if="editLevel === 3">
                <v-list-tile-title>Measures</v-list-tile-title>
                  <v-flex xs3 sm3 md3>
                    <v-text-field
                      v-model="measure.measure_name"
                      :rules="[v => !!v || 'Measure Name is Required']"
                      label="Name">
                    </v-text-field>
                  </v-flex>
                  <v-flex xs3 sm3 md3>
                    <v-select
                      :items="measure_types"
                      v-model="measure.measure_type_id"
                      overflow
                      item-text="name"
                      item-value="id"
                      label="Measure Type"
                    ></v-select>
                  </v-flex>
                  <v-flex xs3 sm3 md3>
                    <v-text-field
                      v-model="measure.unit"
                      :rules="[v => !!v || 'Unit is Required']"
                      label="Unit">
                    </v-text-field>
                  </v-flex>
                  <v-flex xs3 sm3 md3>
                    <v-text-field
                      v-model="measure.measure_description"
                      :rules="[v => !!v || 'Description is Required']"
                      label="Description">
                    </v-text-field>
                  </v-flex>
                  Range Values
                  <v-container grid-list-md text-xs-center>
                    <v-layout row wrap v-if="measure.measure_type_id === 1" v-for="(numeric, i) in numerics" :key="i">
                      
                      <v-flex xs2 sm2 d-flex>
                        <v-select
                          v-model="numeric.age_range"
                          :items="age_range"
                          label="Age Range"
                        ></v-select>
                      </v-flex>:
                      <v-flex xs2 sm2 md2>
                        <v-text-field
                          v-model="numeric.age_min"
                          :rules="[v => !!v || 'Lower age limit is Required']"
                          label="Lower Age Limit">
                        </v-text-field>
                      </v-flex>-
                      <v-flex xs2 sm2 md2>
                        <v-text-field
                          v-model="numeric.age_max"
                          :rules="[v => !!v || 'Upper age limit is Required']"
                          label="Upper Age Limit">
                        </v-text-field>
                      </v-flex>
                      <v-flex xs2 sm2 d-flex>
                        <v-select
                          v-model="numeric.gender_id"
                          :items="gender"
                          label="Gender"
                          item-text="display"
                          item-value="id"
                        ></v-select>
                      </v-flex>
                      <v-flex xs2 sm2 md2>
                        <v-text-field
                          v-model="numeric.low"
                          :rules="[v => !!v || 'Lower Measure limit is Required']"
                          label="Lower Measure Range">
                        </v-text-field>
                      </v-flex>-
                      <v-flex xs2 sm2 md2>
                        <v-text-field
                          v-model="numeric.high"
                          :rules="[v => !!v || 'Upper Measure limit is Required']"
                          label="Upper Measure Range">
                        </v-text-field>
                      </v-flex>
                      <v-btn color="error" @click="removeNumericRange(i)">
                          Remove Range
                      </v-btn>
                    </v-layout>
                    <v-layout row wrap v-if="measure.measure_type_id === 2" v-for="(alphanumeric, i) in alphanumerics" :key="i">
                      <v-flex xs2 sm2 md2>
                        <v-text-field
                          v-model="alphanumeric.display"
                          :rules="[v => !!v || 'Value is Required']"
                          label="Value">
                        </v-text-field>
                      </v-flex>
                      <v-flex xs2 sm2 d-flex>
                        <v-select
                          v-model="alphanumeric.interpretation_id"
                          :items="interpretation"
                          label="Interpretation"
                          item-text="name"
                          item-value="id"
                        ></v-select>
                      </v-flex>
                      <v-btn color="error" @click="removeAlphanumericRange(i)">
                          Remove Range
                      </v-btn>
                    </v-layout>
                    <v-layout row wrap v-if="measure.measure_type_id === 3" v-for="(multialphanumeric, i) in multialphanumerics" :key="i">
                      <v-flex xs2 sm2 md2>
                        <v-text-field
                          v-model="multialphanumeric.display"
                          :rules="[v => !!v || 'Value is Required']"
                          label="Value">
                        </v-text-field>
                      </v-flex>
                      <v-flex xs2 sm2 d-flex>
                        <v-select
                          v-model="multialphanumeric.interpretation_id"
                          :items="interpretation"
                          label="Interpretation"
                          item-text="name"
                          item-value="id"
                        ></v-select>
                      </v-flex>
                      <v-btn color="error" @click="removeMultiAlphanumericRange(i)">
                          Remove Range
                      </v-btn>
                    </v-layout>
                  </v-container>
                  <v-btn color="info" v-if="measure.measure_type_id === 1" @click="addNumericRange">
                    Add New Range
                  </v-btn>
                  
                  <v-btn color="info" v-if="measure.measure_type_id === 2" @click="addAlphanumericRange">
                    Add New Range
                  </v-btn>

                  <v-btn color="info" v-if="measure.measure_type_id === 3" @click="addMultiAlphanumericRange">
                    Add New Range
                  </v-btn>
              </v-layout>
            </v-container>

          </v-card-text>

          <div style="flex: 1 1 auto;"></div>
        </v-card>
      </v-dialog>
      <v-dialog v-model="dialog2" max-width="500px">
        <v-card>
          <v-card-title>
            Test Details
          </v-card-title>
          <v-card-text>
            
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="newTest.name"
                  :rules="[v => !!v || 'Name is Required']"
                  label="Name">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="newTest.description"
                  :rules="[v => !!v || 'Description is Required']"
                  label="Description"
                  multi-line>
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="newTest.targetTAT"
                  :rules="[v => !!v || 'Target Turnaround Time is Required']"
                  label="Target Turnaround Time">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-select
                  :items="testtypecategory"
                  v-model="newTest.test_type_category_id"
                  overflow
                  item-text="name"
                  item-value="id"
                  label="Lab Section"
                ></v-select>
              </v-flex>

          </v-card-text>
          <v-card-actions>
            <v-btn color="primary" flat @click.stop="dialog2=false">Close</v-btn>
            <v-btn color="blue darken-1" :disabled="!valid" flat @click.native="saveTest">Save</v-btn>
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
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.name }}</td>
        <td class="text-xs-left">{{ props.item.description }}</td>
        <td class="text-xs-left">{{ props.item.targetTAT }}</td>
        <td class="text-xs-left">{{ props.item.testtypecategory.name }}</td>
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
      dialog: false,
      dialog2: false,
      valid: true,
      dialog: false,
      delete: false,
      saving: false,
      editLevel: 1,
      updating: false,

      newTest: {
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

      specimen_type: [],
      testtypemapping:[],

      measure: {
        measure_name: '',
        measure_type_id: '',
        unit: '',
        measure_description: '',
      },

      numerics: [],
      alphanumerics: [],
      multialphanumerics: [],
      age_range: ['Years', 'Months', 'Days'],
      gender: [],
      interpretation: [],
      measure_types: [],

      specimentypes: [],
      testtypes: [],
      testtypecategory: [],
      items: [],
      measures: [],
      
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
      ]
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
      },

      length: function() {
        return Math.ceil(this.pagination.total / 10);
      },
    },

    beforeCreate() {

        apiCall({url: '/api/specimentype', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.specimentypes = resp.data;
        })
        .catch(error => {
          console.log(error.response)
        })

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

        apiCall({url: '/api/interpretation?' + this.query, method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.interpretation = resp;
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

        apiCall({url: '/api/measure', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.measures = resp;
        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/api/measuretype', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.measure_types = resp;
        })
        .catch(error => {
          console.log(error.response)
        })
      },

      addNumericRange: function () {
        this.numerics.push(
            {}
          );
      },

      removeNumericRange: function (i) {
        this.numerics.splice(i, 1)
      },

      addAlphanumericRange: function(){
        this.alphanumerics.push(
              {},
          );
      },

      removeAlphanumericRange: function (i) {
        this.alphanumerics.splice(i, 1)
      },

      addMultiAlphanumericRange: function(){
        this.multialphanumerics.push(
              {},
          );
      },

      removeMultiAlphanumericRange: function (i) {
        this.multialphanumerics.splice(i, 1)
      },

      editItem (item) {
        this.updating = true
        this.editLevel = this.testtypes.indexOf(item)
        this.newTest = Object.assign({}, item)
        this.dialog2 = true
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
        this.dialog2 = false
        this.editLevel = 1
        // if not saving reset dialog references to datatables
        if (!this.saving) {
          this.resetDialogReferences();
        }
      },

      closeMainDialog () {
        this.dialog = false

        // if not saving reset dialog references to datatables
        if (!this.saving) {
          this.resetDialogReferences();
        }
      },

      resetDialogReferences() {
        this.newTest = Object.assign({}, this.defaultItem)
        this.editLevel = 1
      },

      testTypeMapper: function(x){
        x = this.newTest.id;
        this.testtypemapping = this.testtypemapping.filter(function(testID){
          return testID.test_type_id === x;
        })
      },

      saveTest () {

        this.saving = true;
        // update
        if (this.updating) {

          apiCall({url: '/api/testtype/'+this.newTest.id, data: this.newTest, method: 'PUT' })
          .then(resp => {
            Object.assign(this.testtypes[this.editLevel], this.newTest)
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

          apiCall({url: '/api/testtype', data: this.newTest, method: 'POST' })
          .then(resp => {
            this.testtypes.push(this.newTest)
            console.log(resp.testTypeId)
            this.newTest.id = resp.testTypeId;
            this.editLevel = 2;
          })
          .catch(error => {
            console.log(error.response)
          })
          this.close()
        }
      },

      saveSpecimenTypes(){
        // update
        if (this.updating) {
        this.saving = true;
        this.specimen_type.testId = this.newTest.id;
        console.log('specimen_type')
        console.log(this.specimen_type)
          apiCall({url: '/api/testtypemapping/update?'+this.newTest.id, data: this.specimen_type, method: 'POST' })
          .then(resp => {
            Object.assign(this.testtypes[this.editLevel], this.specimen_type)
            console.log(resp)
            
            this.editLevel = 3;
          })
          .catch(error => {
            console.log(error.response)
          })
        
        
        // store
        } else {
        this.saving = true;
          apiCall({url: '/api/testtypemapping/create?'+this.newTest.id, data: this.specimen_type, method: 'POST' })
          .then(resp => {
            Object.assign(this.testtypes[this.editLevel], this.specimen_type)
            console.log(resp)
            this.editLevel = 3;
          })
          .catch(error => {
            console.log(error.response)
          })
        }
      },

      saveMeasureDetails (){
        this.saving = true;
        this.measure.test_type_id = this.newTest.id;
            apiCall({url: '/api/measure', data: this.measure, method: 'POST' })
            .then(resp => {
              //this.numerics.measure_id = resp.measureId;
              if(this.measure.measure_type_id === 1){
                  for (var i = this.numerics.length - 1; i >= 0; i--) {
                        this.numerics[i].measure_id = resp.measureId;
                  }
                }
              else if(this.measure.measure_type_id === 2){
                  for (var i = this.alphanumerics.length - 1; i >= 0; i--) {
                    this.alphanumerics[i].measure_id = resp.measureId;
                  }
                }
              else{
                for (var i = this.multialphanumerics.length - 1; i >= 0; i--) {
                    this.multialphanumerics[i].measure_id = resp.measureId;
                  }
              }
              this.saveMeasureRanges();
            })
            .catch(error => {
              console.log(error.response)
            })
      },

      saveMeasureRanges(){
        if(this.measure.measure_type_id === 1){
          apiCall({url: '/api/measurerange', data: this.numerics, method: 'POST' })
          .then(resp => {
            console.log('numerics');
            console.log(this.numerics);
          })
          .catch(error => {
            console.log(error.response)
          })
        }
        else if(this.measure.measure_type_id === 2){
          apiCall({url: '/api/measurerange', data: this.alphanumerics, method: 'POST' })
          .then(resp => {
            console.log('alphanumerics');
            console.log(this.alphanumerics);
          })
          .catch(error => {
            console.log(error.response)
          })
        }
        else{
          apiCall({url: '/api/measurerange', data: this.multialphanumerics, method: 'POST' })
          .then(resp => {
            console.log('alphanumerics');
            console.log(this.multialphanumerics);
          })
          .catch(error => {
            console.log(error.response)
          })
        }
        this.resetDialogReferences();
        this.closeMainDialog();
        this.saving = false;
      }
    }
  }
</script>