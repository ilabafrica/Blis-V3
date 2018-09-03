<template>
    <div>
        <v-layout row wrap>
            <p class="flex xs11" style="font-size:2rem; font-weight:100">Test Search (<small class="grey--text">{{total_tests}} Tests Matched</small>)</p>            
            <v-btn icon @click="toggle_filter_options = !toggle_filter_options">
                <v-icon>{{ toggle_filter_options ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}</v-icon>
            </v-btn>
        </v-layout>
        <v-layout row wrap>
            <v-data-table
                :headers="headers"
                :items="tests"
                hide-actions
                class="elevation-1"
            >
                <template slot="items" slot-scope="props">
                    <tr>
                        <td class="text-xs-right">{{ props.item.name }}</td>
                        <td class="text-xs-right">
                            <tr v-for="measure in props.item.measures" :key="measure.id">
                                <td :rowspan="measure.ranges.length">{{measure.name}}</td>
                            </tr>
                        </td>
                        <td>
                            <tr v-for="measure in props.item.measures" :key="measure.id">
                                <td>
                                    <tr v-for="range in measure.ranges" :key="range.id">
                                        <td>{{range.display}}</td>
                                    </tr>
                                </td>
                            </tr>
                        </td>
                        <td>
                            <tr v-for="measure in props.item.measures" :key="measure.id">
                                <td>
                                    <tr v-for="range in measure.ranges" :key="range.id">
                                        <td>
                                            <tr><td>Male</td></tr>
                                            <tr><td>Female</td></tr>
                                        </td>                                        
                                    </tr>
                                </td>
                            </tr>
                        </td>
                        <td>
                            <tr v-for="measure in props.item.measures" :key="measure.id">
                                <td>
                                    <tr v-for="range in measure.ranges" :key="range.id">
                                        <td>
                                            <tr><td>{{ range.male.under_5 }}</td></tr>
                                            <tr><td>{{ range.female.under_5 }}</td></tr>
                                        </td>                                        
                                    </tr>
                                </td>
                            </tr>
                        </td>
                        <td>
                            <tr v-for="measure in props.item.measures" :key="measure.id">
                                <td>
                                    <tr v-for="range in measure.ranges" :key="range.id">
                                        <td>
                                            <tr><td>{{ range.male["5_to_20"] }}</td></tr>
                                            <tr><td>{{ range.female["5_to_20"] }}</td></tr>
                                        </td>                                        
                                    </tr>
                                </td>
                            </tr>
                        </td>
                        <td>
                            <tr v-for="measure in props.item.measures" :key="measure.id">
                                <td>
                                    <tr v-for="range in measure.ranges" :key="range.id">
                                        <td>
                                            <tr><td>{{ range.male.over_20 }}</td></tr>
                                            <tr><td>{{ range.female.over_20 }}</td></tr>
                                        </td>                                        
                                    </tr>
                                </td>
                            </tr>
                        </td>
                        <td>
                            <tr v-for="measure in props.item.measures" :key="measure.id">
                                <td>
                                    <tr v-for="range in measure.ranges" :key="range.id">
                                        <td>
                                            <tr><td>{{ range.male.total }}</td></tr>
                                            <tr><td>{{ range.female.total }}</td></tr>
                                        </td>                                       
                                    </tr>
                                </td>
                            </tr>
                        </td>
                        
                        <td class="text-xs-right">{{ props.item.total }}</td>
                    </tr>
                </template>
            </v-data-table>
        </v-layout>
    </div>
</template>

<style scoped>
    td tr td{
        padding: 0px !important;
    }
</style>

<script>
import apiCall from "../../../utils/api";
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
  }),

  computed: {
    length: function() {
      return Math.ceil(this.pagination.total / this.pagination.visible);
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
                    console.log("A new Entry is, ",setThis)
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
  }
};
</script>