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
              <v-btn v-if="editLevel === 3" dark flat @click.native="closeMainDialog">Close</v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-card-text>
            <v-btn color="primary" dark @click.stop="dialog2 = !dialog2" v-if="editLevel === 1">Enter Test Details</v-btn>

            <v-container 
              v-if="editLevel > 1">
              <v-divider></v-divider>
                <v-list-tile-title
                  v-if="editLevel === 2"
                  >Specimen Types
                </v-list-tile-title>
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
                    <v-layout child-flex row wrap v-if="editLevel === 3">
                      <v-dialog v-model="dialog3" max-width="500px">
                        <v-card>
                          <v-card-title>
                            Measure Details
                          </v-card-title>
                          <v-card-text>
                            <v-flex xs12 sm12 md12>
                              <v-text-field
                                v-model="measurefield.name"
                                :rules="[v => !!v || 'Measure Name is Required']"
                                label="Name">
                              </v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-select
                                :items="measure_types"
                                v-model="measurefield.measure_type_id"
                                overflow
                                item-text="name"
                                item-value="id"
                                label="Measure Type"
                              ></v-select>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-text-field
                                v-model="measurefield.unit"
                                :rules="[v => !!v || 'Unit is Required']"
                                label="Unit">
                              </v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-text-field
                                v-model="measurefield.description"
                                :rules="[v => !!v || 'Description is Required']"
                                label="Description">
                              </v-text-field>
                            </v-flex>
                          </v-card-text>
                          <v-card-actions>
                            <v-btn color="primary" flat @click.stop="closeMeasureDialogue">Close</v-btn>
                            <v-btn color="blue darken-1" :disabled="!valid" flat @click.native="saveMeasure">Save</v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>
                      <v-dialog v-model="dialog4" max-width="1000px">
                        <v-card>
                          <v-card-title>
                            Measure Ranges
                          </v-card-title>
                          <v-layout v-if="measureRangeID === 1">
                            <v-btn color="info" dark @click="dialog5 = !dialog5">
                              Add New Range
                            </v-btn>
                            <v-data-table
                              :headers="rangeheaders"
                              :items="measureranges"
                              max-width="900px"
                              hide-actions
                              v-if="editLevel === 3">
                              <template slot="items" slot-scope="row">
                                <tr :key="row.item.id">
                                  <td>{{row.item.display}}</td>
                                  <td>{{row.item.age_min}}</td>
                                  <td>{{row.item.age_max}}</td>
                                  <td>{{row.item.gender.display}}</td>
                                  <td>{{row.item.low}}</td>
                                  <td>{{row.item.high}}</td>
                                </tr>
                              </template>
                            </v-data-table>
                          </v-layout>
                          <v-layout v-if="measureRangeID != 1">
                            <v-btn color="info" dark @click="dialog6 = !dialog6">
                              Add New Range
                            </v-btn>
                            <v-data-table
                              :headers="alpharangeheaders"
                              :items="measureranges"
                              max-width="900px"
                              hide-actions
                              v-if="editLevel === 3">
                              <template slot="items" slot-scope="row">
                                <tr :key="row.item.id">
                                  <td>{{row.item.display}}</td>
                                  <td>{{row.item.interpretation_id}}</td>
                                </tr>
                              </template>
                            </v-data-table>
                          </v-layout>
                          <v-card-actions>
                            <v-btn color="primary" flat @click.stop="dialog4 = false">Close</v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>
                      <v-dialog v-model="dialog5" max-width="500px">
                        <v-card>
                          <v-card-title>
                            Numeric Range Details
                          </v-card-title>
                          <v-card-text>
                            
                              <v-flex xs12 sm12 d-flex>
                              <v-select
                                v-model="numerics.age_range"
                                :items="age_range"
                                label="Age Range"
                              ></v-select>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-text-field
                                v-model="numerics.age_min"
                                :rules="[v => !!v || 'Lower age limit is Required']"
                                label="Lower Age Limit">
                              </v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-text-field
                                v-model="numerics.age_max"
                                :rules="[v => !!v || 'Upper age limit is Required']"
                                label="Upper Age Limit">
                              </v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 d-flex>
                              <v-select
                                v-model="numerics.gender_id"
                                :items="gender"
                                label="Gender"
                                item-text="display"
                                item-value="id"
                              ></v-select>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-text-field
                                v-model="numerics.low"
                                :rules="[v => !!v || 'Lower Measure limit is Required']"
                                label="Lower Measure Range">
                              </v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-text-field
                                v-model="numerics.high"
                                :rules="[v => !!v || 'Upper Measure limit is Required']"
                                label="Upper Measure Range">
                              </v-text-field>
                            </v-flex>
                          </v-card-text>
                          <v-card-actions>
                            <v-btn color="primary" flat @click.stop="closeMeasureRangeDialog">Close</v-btn>
                            <v-btn color="blue darken-1" :disabled="!valid" flat @click.native="saveMeasureRange">Save</v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>
                      <v-dialog v-model="dialog6" max-width="500px">
                        <v-card>
                          <v-card-title>
                            Range Details
                          </v-card-title>
                          <v-card-text>
                            <v-flex xs12 sm12 md12>
                              <v-text-field
                                v-model="alphanumerics.display"
                                :rules="[v => !!v || 'Value is Required']"
                                label="Value">
                              </v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 d-flex>
                              <v-select
                                v-model="alphanumerics.interpretation_id"
                                :items="interpretation"
                                label="Interpretation"
                                item-text="name"
                                item-value="id"
                              ></v-select>
                            </v-flex>
                          </v-card-text>
                          <v-card-actions>
                            <v-btn color="primary" flat @click.stop="closeAlphaMeasureRangeDialog">Close</v-btn>
                            <v-btn color="blue darken-1" :disabled="!valid" flat @click.native="saveMeasureRange">Save</v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>
                      <v-list-tile-title>Measures</v-list-tile-title>
                        <v-btn color="info" dark @click.stop="dialog3 = true" v-if="editLevel === 3">
                          Add New Measure
                        </v-btn>
                        <v-divider></v-divider>
                        <v-layout child-flex>
                          <v-data-table
                            :headers="measureheaders"
                            :items="measures"
                            hide-actions
                            class="elevation-1"
                          >
                            <template slot="items" slot-scope="props">
                              <td>{{ props.item.name }}</td>
                              <td class="text-xs-left">{{ props.item.unit }}</td>
                              <td class="text-xs-left">{{ props.item.description }}</td>
                              <td class="justify-left layout px-0">
                                <v-btn icon class="mx-0" @click="editMeasure(props.item)">
                                  <v-icon color="teal">edit</v-icon>
                                </v-btn>
                                <v-btn icon class="mx-0" @click="deleteMeasure(props.item)">
                                  <v-icon color="pink">delete</v-icon>
                                </v-btn>
                                <v-btn color="info" dark @click="viewMeasureRanges(props.item)" v-if="editLevel === 3">
                                  Measure Ranges
                                </v-btn>
                              </td>
                            </template>
                          </v-data-table>
                        </v-layout>
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
            <v-btn color="primary" flat @click.stop="closeMainDialog">Close</v-btn>
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
      dialog3: false,
      dialog4: false,
      dialog5: false,
      dialog6: false,
      valid: true,
      dialog: false,
      delete: false,
      saving: false,
      editLevel: 1,
      updating: false,
      measureRangeID: 0,
      RangeID: 0,

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

      measurefield: {
        test_type_id: '',
        measure_type_id: '',
        name: '',
        unit: '',
        description: '',
      },

      defaultMeasureItem: {
        test_type_id: '',
        measure_type_id: '',
        name: '',
        unit: '',
        description: '',
      },

      numerics:{
        age_range: '',
        age_min: '',
        age_max: '',
        gender_id: '',
        low: '',
        high: '',
      },

      defaultNumericsItem:{
        age_range: '',
        age_min: '',
        age_max: '',
        gender_id: '',
        low: '',
        high: '',
      },

      alphanumerics:{
        display: '',
        interpretation_id: '',
      },

      defaultAlphaNumericsItem:{
        display: '',
        interpretation_id: '',
      },

      age_range: ['Years', 'Months', 'Days'],
      gender: [],
      interpretation: [],
      measure_types: [],
      measureranges: [],
      specimentypes: [],
      testtypes: [],
      measures: [],
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
      rangeheaders: [
        { text: 'Display', value: 'display' },
        { text: 'Minimum Age (Years)', value: 'age_min' },
        { text: 'Maximum Age (Years)', value: 'age_max' },
        { text: 'Gender', value: 'gender_id' },
        { text: 'Lower limit', value: 'low' },
        { text: 'Higher limit', value: 'high' },
      ],
      alpharangeheaders: [
        { text: 'Display', value: 'display' },
        { text: 'Interpretation', value: 'interpretation_id' },
      ],
      measureheaders: [
        { text: 'Name', value: 'name' },
        { text: 'Unit', value: 'unit' },
        { text: 'Description', value: 'description', sortable: false }
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

        apiCall({url: '/api/measurerange', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.measureranges = resp;
        })
        .catch(error => {
          console.log(error.response)
        })
      },

      editItem (item) {
        this.updating = true
        this.editLevel = this.testtypes.indexOf(item)
        this.newTest = Object.assign({}, item)
        this.dialog2 = true
      },

      editMeasure (item) {
        this.updating = true
        this.itemIndex = this.measures.indexOf(item)
        this.measurefield = Object.assign({}, item)
        this.editLevel = 3
        this.dialog3 = true
      },

      viewMeasureRanges (item){
        this.measureRangeMapper(item);
        console.log('item id')
        console.log(item.id)
        this.RangeID = item.id
        this.itemIndex = this.measures.indexOf(item)
        if(item.measure_type_id === 1){
          this.measureRangeID = 1
        }else if(item.measure_type_id === 2){
          this.measureRangeID = 2
        }else if(item.measure_type_id === 3){
          this.measureRangeID = 3
        }else{
          this.measureRangeID = 4
        }
        this.dialog4 = true

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

      deleteMeasure (item) {

        confirm('Are you sure you want to delete this item?') && (this.delete = true)

        if (this.delete) {
          const index = this.measures.indexOf(item)
          this.measures.splice(index, 1)
          apiCall({url: '/api/measure/'+item.id, method: 'DELETE' })
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
        this.dialog2 = false

        // if not saving reset dialog references to datatables
        if (!this.saving) {
          this.resetDialogReferences();
        }
      },

      closeMeasureDialogue () {
        this.dialog3=false
        this.updating = false
        this.resetMeasureDialogReferences();
        // if not saving reset dialog references to datatables
        /*if (!this.saving) {
          this.resetMeasureDialogReferences();
        }*/
      },

      closeMeasureRangeDialog () {
        this.dialog5=false
        this.updating=false
        this.resetMeasureRangeDialogReferences();

      },

      closeAlphaMeasureRangeDialog () {
        this.dialog6=false
        this.updating=false
        this.resetAlphaMeasureRangeDialogReferences();

      },

      resetDialogReferences() {
        this.newTest = Object.assign({}, this.defaultItem)
        this.editLevel = 1
      },

      resetMeasureDialogReferences() {
        this.measurefield = Object.assign({}, this.defaultMeasureItem)
      },

      resetMeasureRangeDialogReferences () {
        this.numerics = Object.assign({}, this.defaultNumericsItem)
      },

      resetAlphaMeasureRangeDialogReferences () {
        this.alphanumerics = Object.assign({}, this.defaultAlphaNumericsItem)
      },

      testTypeMapper: function(x){
        x = this.newTest.id;
        this.testtypemapping = this.testtypemapping.filter(function(testID){
          return testID.test_type_id === x;
        })
      },

      measureMapper: function(x){
        x = this.newTest.id;
        this.measures = this.measures.filter(function(measureID){
          return measureID.test_type_id === x;
        })
      },

      measureRangeMapper: function(item){
        this.measureranges = this.measureranges.filter(function(measureID){
          return measureID.measure_id === item.id;
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
            this.measureMapper();
            this.editLevel = 3;
            this.updating = false;
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
            this.measureMapper();
            this.editLevel = 3;
            this.updating = false;
          })
          .catch(error => {
            console.log(error.response)
          })
        }
      },

      saveMeasure(){
        this.saving = true;
        // update
        if (this.updating) {

          apiCall({url: '/api/measure/'+this.measurefield.id, data: this.measurefield, method: 'PUT' })
          .then(resp => {
            Object.assign(this.measures[this.itemIndex], this.measurefield)
            console.log(resp)
            this.closeMeasureDialogue();
          })
          .catch(error => {
            console.log(error.response)
          })

        //store
        } else {
        this.measurefield.test_type_id = this.newTest.id;

          apiCall({url: '/api/measure', data: this.measurefield, method: 'POST' })
          .then(resp => {
            this.measures.push(this.measurefield)
            console.log('resp')
            console.log(resp)
            
            this.closeMeasureDialogue();
          })
          .catch(error => {
            console.log(error.response)
          })
        }
      },

      saveMeasureRange(){
        if(this.measureRangeID === 1){
          this.numerics.measure_id = this.RangeID
          apiCall({url: '/api/measurerange', data: this.numerics, method: 'POST' })
          .then(resp => {
            this.measureranges.push(this.numerics)
            console.log('numerics');
            console.log(this.numerics);
          })
          .catch(error => {
            console.log(error.response)
          })
          this.closeMeasureRangeDialog();
        }else{
          this.alphanumerics.measure_id = this.RangeID
          apiCall({url: '/api/measurerange', data: this.alphanumerics, method: 'POST' })
          .then(resp => {
            this.measureranges.push(this.alphanumerics)
            console.log('alphanumerics');
            console.log(this.alphanumerics);
          })
          .catch(error => {
            console.log(error.response)
          })
          this.closeAlphaMeasureRangeDialog();
        }
        
        /*this.resetDialogReferences();
        this.closeMainDialog();
        this.saving = false;*/
      }
    }
  }
</script>