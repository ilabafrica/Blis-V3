<template>
    <div>
        <v-layout row wrap>
            <p class="flex xs11" style="font-size:2rem; font-weight:100">Infection Report (<small class="grey--text">{{total_tests}} Tests Matched</small>)</p>            
            <v-btn icon @click="toggle_filter_options = !toggle_filter_options">
                <v-icon>{{ toggle_filter_options ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}</v-icon>
            </v-btn>
        </v-layout>
        <v-layout row wrap>
            <v-data-table
                :headers="headers"
                :items="tableData"
                hide-actions
                class="elevation-1"
            >
                <template slot="items" slot-scope="props">
                    <tr v-for="row in props.item" :key="row.uniqueKey">
                        <td v-if="row.tt" :rowspan="row.tt.rc">{{row.tt.value}}</td>
                        <td v-if="row.measure" :rowspan="row.measure.rc">{{row.measure.value}}</td>
                        <td v-if="row.measure_range" :rowspan="row.measure_range.rc">{{row.measure_range.value}}</td>
                        <td v-if="row.gender" :rowspan="row.gender.rc">{{row.gender.value}}</td>
                        <td v-if="row.under_5" :rowspan="row.under_5.rc">{{row.under_5.value}}</td>
                        <td v-if="row['5_to_20']" :rowspan="row['5_to_20'].rc">{{row['5_to_20'].value}}</td>
                        <td v-if="row.over_20" :rowspan="row.over_20.rc">{{row.over_20.value}}</td>
                        <td v-if="row.total" :rowspan="row.total.rc">{{row.total.value}}</td>
                        <td v-if="row.main_total" :rowspan="row.main_total.rc">{{row.main_total.value}}</td>
                    </tr>
                </template>
            </v-data-table>
        </v-layout>
    </div>
</template>

<script>
import apiCall from "../../utils/api";
import Chart from "chart.js";
export default {
   
  data: () => ({
    url_prefix: "/api/stats/",
    search: "",
    query: "",
    pagination: {
      page: 1,
      per_page: 0,
      total: 0,
      visible: 10
    },
    headers: [
        { text: 'Test Types', value: 'test_type_id' },
        { text: 'Measures', value: 'measure_id' },
        { text: 'Measures Range', value: 'measure_range_id' },
        { text: 'Gender', value: 'gender' },
        { text: 'Below 5', value: 'under_5' },
        { text: '5 to 20', value: '5_to_20' },
        { text: 'Above 20', value: 'over_20' },
        { text: 'M/F Total', value: 'm_f_total'},
        { text: 'Total', value: 'total' },
      ],
    toggle_filter_options:true,
    total_tests: null,
    test_ids: null,
    types: {},
    
    tests:[],
    formattedTests: []
  }),

  computed: {
    length: function() {
      return Math.ceil(this.pagination.total / this.pagination.visible);
    },
    tableData: function() {
        let formattedData = []
        let uniqueKey = 0;
        this.tests.forEach((testtype, tt_index) => { // test type loop
            console.log("Test Type is: ", testtype)
            let row = []
            let measure_count = 0;
            for (const key1 in testtype.measures) { // measures loop
                if (testtype.measures.hasOwnProperty(key1)) {
                    const measure = testtype.measures[key1];
                    console.log("Measure is: ", measure)
                    let range_count = 0;
                    for (const key2 in measure.ranges) { //ranges loop
                        if (measure.ranges.hasOwnProperty(key2)) {
                            const range_result = measure.ranges[key2];
                            console.log("Range is:",range_result)                               
                            let rowMale =this.formatForTable(range_result.male)
                            rowMale.gender = {value: "Male", rc:1}
                            let rowFemale = this.formatForTable(range_result.female)
                            rowFemale.gender = {value: "Female", rc:1}
                            if(measure_count == 0 && range_count==0){
                                let tt_h = 0, m_h = 0
                                for (const key in testtype.measures) {
                                    if (testtype.measures.hasOwnProperty(key)) {
                                        const element = testtype.measures[key];
                                        let r_h = Object.keys(element.ranges).length*2
                                        tt_h += r_h
                                    }
                                }
                                rowMale.measure = {value: measure.name, rc:Object.keys(measure.ranges).length*2}
                                rowMale.tt = {value: testtype.name, rc:tt_h}
                                rowMale.main_total = {value: testtype.total, rc: tt_h}
                            }else if (range_count==0){
                                rowMale.measure = {value: measure.name, rc:Object.keys(measure.ranges).length*2}                                
                            }
                            rowMale.measure_range = {value: range_result.display, rc:2}                            
                            rowMale.uniqueKey = uniqueKey
                            uniqueKey +=1
                            rowFemale.uniqueKey = uniqueKey
                            uniqueKey +=1
                            console.log("Male row ",rowMale)
                            console.log("Female row ",rowFemale)
                            row.push(rowMale)
                            row.push(rowFemale)
                        }
                        range_count += 1
                    }
                }
                measure_count +=1
            }
            formattedData.push(row)
        });
        console.log("Formated Tests ", formattedData)
        return formattedData
        // Vue.set(this,'formattedTests', formattedData)
    }
    
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
        this.query = "page=" + this.pagination.page;
               
        // if (this.search != "") {
        //     this.query = this.query + "&search=" + this.search;
        // }
        apiCall({url:this.url_prefix+"users", method:"GET"})
        .then(resp=>{
            let users = []
            console.log("User request response is, ",resp)
            resp.forEach(element => {
                users.push({'text':element.name, 'value':element.id})
            });
            Vue.set(this, 'users', users)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:"/api/location", method:"GET"})
        .then(resp=>{
            let locations = []
            console.log("Location request response is, ",resp)
            resp.data.forEach(element => {
                locations.push({'text':element.name, 'value':element.id})
            });
            Vue.set(this, 'locations', locations)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:"/api/stats/tests/types", method:"GET"})
        .then(resp=>{
            let types = {}
            resp.forEach(element => {
                types[element.id] = element.name;
            });
            console.log("Types are ",types)
            Vue.set(this, 'types', types)
            this.getResults()
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:"/api/testtypecategory", method:"GET"})
        .then(resp=>{
            let categories = []
            console.log("Categories request response is, ",resp)
            resp.data.forEach(element => {
                categories.push({'text':element.name, 'value':element.id})
            });
            Vue.set(this, 'categories', categories)
        })
        .catch(error => {
            console.log(error.response)
        })
    },
    getResults(){
        apiCall({url:this.url_prefix+"results/totals?by_results=alpha&by_age=true&by_test_types=true&by_gender=true", method:"GET"})
        .then(resp=>{
            let total = 0
            let setThis = []
            let cleanArray = []
            let formattedData = []
            console.log("Result response is ", resp)
            resp.forEach(element => { // loop through all the responses,
                total += element.total
                if(!setThis[element.test_type_id]){ // if the setThis array doesn't have an index relating to an id, set up the object structure with the test type id as the index
                    setThis[element.test_type_id]={ // assign a new object to the array element at index of test_type_id
                        id : element.test_type_id, 
                        name : this.types[element.test_type_id], // test type should be set up such that the key is the test type id and the corresponding valuis the test type display name
                        measures : {}, // each test type may have various measures, thus initialize an object with the following structure. Using object instead of array to void holes in the array that would need to be cleaned up later                            
                        total: 0
                    }
                    //console.log("A new Entry is, ",setThis)
                }
                if(!setThis[element.test_type_id].measures[element.measure_id]){ 
                    setThis[element.test_type_id].measures[element.measure_id] = {
                            name : element.measure_name,
                            ranges : {}, // each measure may have various ranges, thus initialize an object with the following structure. Using object instead of array to void holes in the array that would need to be cleaned up later
                            total : 0
                        }
                }
                if(!setThis[element.test_type_id].measures[element.measure_id].ranges[element.measure_range_id]){ 
                    setThis[element.test_type_id].measures[element.measure_id].ranges[element.measure_range_id] ={ //instanciate an intial entry with the key of the current element as there are no other measures to compare against
                        display : element.measure_range_display,
                        male : {"under_5":0,"5_to_20":0,"over_20":0, "total":0},
                        female : {"under_5":0,"5_to_20":0,"over_20":0, "total":0},
                        total : 0
                    }
                }
                if(element.gender_id==1){
                    if(!setThis[element.test_type_id].measures[element.measure_id].ranges[element.measure_range_id].male){
                        setThis[element.test_type_id].measures[element.measure_id].ranges[element.measure_range_id].male = this.addTestTypeData(element)
                    }else{
                        setThis[element.test_type_id].measures[element.measure_id].ranges[element.measure_range_id].male=this.addTestTypeDataNew(setThis[element.test_type_id].measures[element.measure_id].ranges[element.measure_range_id].male,element)
                    }
                }
                if(element.gender_id==2){
                    if(!setThis[element.test_type_id].measures[element.measure_id].ranges[element.measure_range_id].female){
                        setThis[element.test_type_id].measures[element.measure_id].ranges[element.measure_range_id].female = this.addTestTypeData(element)
                    }else{
                        setThis[element.test_type_id].measures[element.measure_id].ranges[element.measure_range_id].female=this.addTestTypeDataNew(setThis[element.test_type_id].measures[element.measure_id].ranges[element.measure_range_id].female,element)
                    }
                }
                setThis[element.test_type_id].measures[element.measure_id].ranges[element.measure_range_id].total += element.total
                setThis[element.test_type_id].measures[element.measure_id].total += element.total
                setThis[element.test_type_id].total += element.total
            });
            setThis.forEach(element => {
                if(element){
                    cleanArray.push(element)
                }
            });
            console.log("Set This ", setThis)
            setThis = []
            console.log("Clean Array is ", cleanArray)
            Vue.set(this, 'total_tests', total)
            Vue.set(this, 'toggle_filter_options', false)               
            Vue.set(this, 'tests', cleanArray)   
        })
        .catch(error => {
            console.log(error.response)
        })
    },
    addTestTypeData(element){
        let formattedTestTypeData = {}
        formattedTestTypeData['under_5'] = parseInt(element['under_5'], 10)
        formattedTestTypeData['5_to_20'] = parseInt(element['5_to_20'], 10)
        formattedTestTypeData['over_20'] = parseInt(element['over_20'], 10)
        formattedTestTypeData['total'] = element.total
        return formattedTestTypeData
    },
    addTestTypeDataNew(current, addition){ //adding an 
        current['under_5'] += parseInt(addition['under_5'], 10)
        current['5_to_20'] += parseInt(addition['5_to_20'], 10)
        current['over_20'] += parseInt(addition['over_20'], 10)
        current['total'] += addition.total
        return current
    },
    formatForTable(object){
        let formatedObject ={}
        for (const key in object) {
            if (object.hasOwnProperty(key)) {
                const element = object[key];
                formatedObject[key] = {value: element, rc:1}
            }
        }
        return formatedObject
    }
  }
};
</script>