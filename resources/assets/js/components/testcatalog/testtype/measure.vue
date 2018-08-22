<template>
  <div>
    <v-layout row justify-center>
      <v-dialog
        v-model="dialog"
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition"
        scrollable>
        <v-card tile>
          <v-toolbar card dark color="primary">
            <v-btn icon dark @click.native="closeMainDialog">
              <v-icon>close</v-icon>
            </v-btn>
            <v-toolbar-title>
              <!-- todo: here put name of measure whose ranges are being  worked on -->
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn dark flat @click.native="closeMainDialog">Close</v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-card-text>
            <!-- list of measure ranges -->
            <div>
              <v-btn
                v-if="measure.measure_type.code === 'numeric'"
                color="info" dark @click="dialogNumericRange = !dialogNumericRange">
                Add New Range
              </v-btn>
              <v-btn
                else
                color="info" dark @click="dialogAlphanumericRange = !dialogAlphanumericRange">
                Add New Range
              </v-btn>
              <v-layout v-if="measure.measure_type.code === 'numeric'">
                <v-data-table
                  :headers="rangeheaders"
                  :items="measure.measure_ranges"
                  hide-actions >
                  <template slot="items" slot-scope="row">
                    <tr :key="row.item.id">
                      <td>{{row.item.age_min}}</td>
                      <td>{{row.item.age_max}}</td>
                      <td>{{row.item.gender.display}}</td>
                      <td>{{row.item.low}}</td>
                      <td>{{row.item.high}}</td>
                      <td class="justify-left layout px-0">
                        <v-btn icon class="mx-0" @click="deleteItem(row.item)">
                          <v-icon color="pink">delete</v-icon>
                        </v-btn>
                      </td>
                    </tr>
                  </template>
                </v-data-table>
              </v-layout>
              <v-layout v-if="measure.measure_type.code != 'numeric'">
                <v-data-table
                  :headers="alpharangeheaders"
                  :items="measure.measure_ranges"
                  hide-actions>
                  <template slot="items" slot-scope="row">
                    <tr :key="row.item.id">
                      <td>{{row.item.display}}</td>
                      <td>{{row.item.interpretation_id}}</td>
                      <td class="justify-left layout px-0">
                        <v-btn icon class="mx-0" @click="deleteItem(row.item)">
                          <v-icon color="pink">delete</v-icon>
                        </v-btn>
                      </td>
                    </tr>
                  </template>
                </v-data-table>
              </v-layout>
            </div>
            <v-container>
              <v-layout child-flex row wrap>
                <v-dialog v-model="dialogMeasure" max-width="500px">
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
                          :items="measureTypes"
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
                <v-dialog v-model="dialogNumericRange" max-width="500px">
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
                <v-dialog v-model="dialogAlphanumericRange" max-width="500px">
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
              </v-layout>
            </v-container>
          </v-card-text>
          <div style="flex: 1 1 auto;"></div>
        </v-card>
      </v-dialog>
    </v-layout>
    <v-card-title>
      {{testType.name}}
    </v-card-title>
    <v-data-table
      :items="specimenTypes"
      hide-actions>
      <template slot="items" slot-scope="row">
        <tr :key="row.item.id">
          <td>{{row.item.name}}</td>
          <td>
            <v-checkbox
              v-model="specimenTypeIds"
              :value="row.item.id"
              v-on:click="toggleSpecimenAssignment(row.item)">
            </v-checkbox>
          </td>
        </tr>
      </template>
    </v-data-table>
    <v-list-tile-title>Measures</v-list-tile-title>
      <v-btn color="info" dark @click.stop="dialogMeasure = true">
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
            <td class="justify-left layout px-0">
              <v-btn icon class="mx-0" @click="editMeasure(props.item)">
                <v-icon color="teal">edit</v-icon>
              </v-btn>
              <v-btn icon class="mx-0" @click="getMeasureRanges(props.item)">
                <v-icon color="info">tune</v-icon>
              </v-btn>
              <v-btn icon class="mx-0" @click="deleteMeasure(props.item)">
                <v-icon color="pink">delete</v-icon>
              </v-btn>
            </td>
          </template>
        </v-data-table>
      </v-layout>
  </div>
</template>
<script>
  import apiCall from '../../../utils/api'
export default {
    data: () => ({
      dialog: false,
      dialogMeasure: false,
      dialogNumericRange: false,
      dialogAlphanumericRange: false,
      valid: true,
      dialog: false,
      delete: false,
      saving: false,
      updating: false,
      savingMeasure: false,
      updatingMeasure: false,
      measureType: '',
      RangeID: 0,

      measure: {},

      measurefield: {
        test_type_id: '',
        measure_type_id: '',
        name: '',
        unit: '',
        description: '',
      },

      defaultMeasure: {
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

      defaultNumerics:{
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

      defaultAlphaNumerics:{
        display: '',
        interpretation_id: '',
      },

      age_range: ['Years', 'Months', 'Days'],
      gender: [],
      interpretation: [],
      measureTypes: [],
      measureRanges: [],
      specimenTypes: [],
      testType: {},
      measures: [],
      items: [],
      
      search: '',
      query: '',

      rangeheaders: [
        { text: 'Minimum Age (Years)', value: 'age_min' },
        { text: 'Maximum Age (Years)', value: 'age_max' },
        { text: 'Gender', value: 'gender_id' },
        { text: 'Lower limit', value: 'low' },
        { text: 'Higher limit', value: 'high' },
        { text: 'Actions', value: 'name', sortable: false },
      ],
      alpharangeheaders: [
        { text: 'Display', value: 'display' },
        { text: 'Interpretation', value: 'interpretation_id' },
        { text: 'Actions', value: 'name', sortable: false },
      ],
      measureheaders: [
        { text: 'Name', value: 'name' },
        { text: 'Unit', value: 'unit' },
        { text: 'Actions', value: 'name', sortable: false },
      ]
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
      },
    },

    beforeCreate() {
      // get earger loaded test type
      apiCall({url: '/api/testtype/'+parseInt(this.$route.params.id), method: 'GET' })
        .then(resp => {
          console.log('Test Type')
          console.log(resp)
          this.testType = resp;

          this.measures = resp.measures;
          this.specimenTypeIds = _.map(resp.specimen_types, 'id');
          console.log('Specimen Type Ids')
          console.log(this.specimenTypeIds)
        })
        .catch(error => {
          console.log(error.response)
      })

      apiCall({url: '/api/specimentype', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.specimenTypes = resp.data;
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

        if (this.search != '') {
            this.query = this.query+'&search='+this.search;
        }

        apiCall({url: '/api/gender', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.gender = resp;
        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/api/interpretation', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.interpretation = resp;
        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/api/measuretype', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.measureTypes = resp;
        })
        .catch(error => {
          console.log(error.response)
        })
      },

      editMeasure (item) {
        this.updatingMeasure = true
        this.itemIndex = this.measures.indexOf(item)
        this.measurefield = Object.assign({}, item)
        this.dialogMeasure = true
      },

      getMeasureRanges (measure){

        this.measure = measure
        this.measureRanges = measure.measure_ranges;
        this.measureId = measure.id
        this.itemIndex = this.measures.indexOf(measure)
        if(measure.measure_type.code === 'numeric'){
          this.measureType = 'numeric';
        }else if(measure.measure_type.code === 'alphanumeric'){
          this.measureType = 'alphanumeric';
        }else if(measure.measure_type.code === 'multi_alphanumeric'){
          this.measureType = 'multi_alphanumeric';
        }else{
          this.measureType = 'free_text'
        }
        this.dialog = true
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

      closeMainDialog () {
        this.dialog = false
      },

      closeMeasureDialogue () {
        this.dialogMeasure=false
        this.updatingMeasure = false
        this.resetMeasureDialogReferences();
      },

      closeMeasureRangeDialog () {
        this.dialogNumericRange=false
        this.updatingMeasureRange=false
        this.resetMeasureRangeDialogReferences();

      },

      closeAlphaMeasureRangeDialog () {
        this.dialogAlphanumericRange=false
        this.updatingMeasureRange=false
        this.resetAlphaMeasureRangeDialogReferences();

      },

      resetMeasureDialogReferences() {
        this.measurefield = Object.assign({}, this.defaultMeasure)
      },

      resetMeasureRangeDialogReferences () {
        this.numerics = Object.assign({}, this.defaultNumerics)
      },

      resetAlphaMeasureRangeDialogReferences () {
        this.alphanumerics = Object.assign({}, this.defaultAlphaNumerics)
      },

      updateTestType () {

        apiCall({url: '/api/testtype/'+parseInt(this.$route.params.id), method: 'GET' })
          .then(resp => {
            console.log('Test Type')
            console.log(resp)
            this.testType = resp;

            this.measures = resp.measures;
            this.specimenTypeIds = _.map(resp.specimen_types, 'id');
            console.log('Specimen Type Ids')
            console.log(this.specimenTypeIds)
          })
          .catch(error => {
            console.log(error.response)
        })
      },

      toggleSpecimenAssignment (specimenType) {

        this.query = 'specimen_type_id='+ specimenType.id+'&&test_type_id='+ this.testType.id;

        // if attached
        if (_.includes(this.specimenTypeIds, specimenType.id)) {

          console.log('dettach specimen_type-test-type')
          // detach
          apiCall({
            url: '/api/specimentypetesttype/detach?'+this.query,
            method: 'GET'
          })
          .then(resp => {
            console.log(resp)
            this.updateTestType();
          })
          .catch(error => {
            console.log(error.response)
          })
        } else {

          console.log('attach specimen_type-test-type')
          // attach
          apiCall({
            url: '/api/specimentypetesttype/attach?'+this.query,
            method: 'GET'
          })
          .then(resp => {
            console.log(resp)
            this.updateTestType();
          })
          .catch(error => {
            console.log(error.response)
          })
        }
      },

      saveMeasure(){
        this.savingMeasure = true;
        // update
        if (this.updatingMeasure) {

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
        this.measurefield.test_type_id = this.testType.id;

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

        if(this.measureType === 'numeric'){
          this.numerics.measure_id = this.measureId
          apiCall({url: '/api/measurerange', data: this.numerics, method: 'POST' })
          .then(resp => {
            this.measureRanges.push(this.numerics)
            console.log('numerics');
            console.log(this.numerics);
          })
          .catch(error => {
            console.log(error.response)
          })
          this.closeMeasureRangeDialog();
        }else{
          this.alphanumerics.measure_id = this.measureId
          apiCall({url: '/api/measurerange', data: this.alphanumerics, method: 'POST' })
          .then(resp => {
            this.measureRanges.push(this.alphanumerics)
            console.log('alphanumerics');
            console.log(this.alphanumerics);
          })
          .catch(error => {
            console.log(error.response)
          })
          this.closeAlphaMeasureRangeDialog();
        }
      }
    }
  }
</script>