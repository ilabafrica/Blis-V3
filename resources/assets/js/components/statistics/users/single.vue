<template>
    <div>
        <v-layout row wrap v-if="tests.cur">            
            <v-flex xs12 sm4 md3 lg2 class="blis-stats-card-parent">
                <div class="elevation-1 blis-grid blis-stats-card">
                    <span class="blis-stats-num"> {{totalTestsRequested()}} </span>
                    <span class="blis-stats-num-label">Total Tests requested</span>
                </div>
            </v-flex>
            <div class="flex blis-stats-card-parent xs12 sm4 md3 lg2" v-for="status in tests.statuses" :key=status.id>
                <div class="elevation-1 blis-grid blis-stats-card">
                    <span class="blis-stats-num"> {{totalTestsStatus(status.id).length}} </span>
                    <span class="blis-stats-num-label">Total Tests {{status.name}}</span>
                </div>
            </div>
            <div class="flex blis-stats-card-parent xs12 sm4 md3 lg2" v-if="oldest_patient_tested">
                <div class="elevation-1 blis-grid blis-stats-card">
                    <span class="blis-stats-num"> {{oldest_patient_tested.age_at_test}} </span>
                    <span class="blis-stats-num-label">Oldest Patient Tested</span>
                </div>
            </div>
            <div class="flex blis-stats-card-parent xs12 sm4 md3 lg2" v-if="youngest_patient_tested">
                <div class="elevation-1 blis-grid blis-stats-card">
                    <span class="blis-stats-num"> {{youngest_patient_tested.age_at_test}} </span>
                    <span class="blis-stats-num-label">Youngest Patient Tested</span>
                </div>
            </div>
        </v-layout>
        <v-layout row wrap style="margin:20px;">
            <v-flex xs12 sm6 md4 lg4 style="padding:10px;">
                <v-card>
                    <v-card-title class="headline grey lighten-2" primary-title>
                        Total Tests Done Per Gender
                    </v-card-title>
                    <v-card-text>
                        <canvas id="myChart" width="400" height="400"></canvas>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md4 lg4 style="padding:10px;">
                <v-card>
                    <v-card-title class="headline grey lighten-2" primary-title>
                        Total Tests Per Day
                    </v-card-title>
                    <v-card-text>
                        <canvas id="myChart2" width="400" height="400"></canvas>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md4 lg4 style="padding:10px;">
                <v-card>
                    <v-card-title class="headline grey lighten-2" primary-title>
                        Total Tests Per Status
                    </v-card-title>
                    <v-card-text>
                        <canvas id="myChart3" width="400" height="400"></canvas>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md4 lg4 style="padding:10px;">
                <v-card>
                    <v-card-title class="headline grey lighten-2" primary-title>
                        Total Tests Per Category
                    </v-card-title>
                    <v-card-text>
                        <canvas id="myChart4" width="400" height="400"></canvas>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </div>
</template>
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
    tests: {
        cur:[],
        statuses:[],
        types:[],
        categories:[]
    },
    counts:{
        date_counts: {},
        gender_counts : {},
        type_counts:{},
        type_category_counts:{}
    },
    oldest_patient_tested:{},
    youngest_patient_tested:{}
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
        if (this.search != "") {
            this.query = this.query + "&search=" + this.search;
        }

        apiCall({url:this.url_prefix+"tests/statuses?"+this.query, method:"GET"})
        .then(resp=>{
            Vue.set(this.tests, 'statuses', resp)
            console.log("Test Statuses are ", this.tests.statuses)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/types?"+this.query, method:"GET"})
        .then(resp=>{
            Vue.set(this.tests, 'types', resp)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/type-categories?"+this.query, method:"GET"})
        .then(resp=>{
            Vue.set(this.tests, 'categories', resp)
        })
        .catch(error => {
            console.log(error.response)
        })

        apiCall({url:this.url_prefix+"tests/done/full?user_id="+this.$route.params.id, method:"GET"})
        .then(resp=>{
            // console.log("Full tests are",resp)   
            // let gender_counts = {'1':0, '2':0, '3':0,'4':0}
            let gender_counts = {}
            let date_counts = {}
            let status_counts = {}, type_counts = {}, type_category_counts = {}
            let youngest_patient_tested = {}, oldest_patient_tested = {}
            resp.map(x =>{
                // For each iteration check if a gender index has been instanitated matching the current gender id and add 1 to it else assign the new gender count index a value of 1 
                gender_counts[x.gender_id] ? true : gender_counts[x.gender_id]={}
                gender_counts[x.gender_id].total = gender_counts[x.gender_id].total ? gender_counts[x.gender_id].total + 1 : 1;
                gender_counts[x.gender_id][x.test_status_id]  = gender_counts[x.gender_id][x.test_status_id] ? gender_counts[x.gender_id][x.test_status_id] + 1 : 1                

                date_counts[x.test_started_at] = date_counts[x.test_started_at] ? date_counts[x.test_started_at] + 1 : 1 
                status_counts[x.test_status_id] = status_counts[x.test_status_id] ? status_counts[x.test_status_id] + 1 : 1 
                
                // float comparison is buggy so Math.round(age *100) before comparison this means a calculated age comparison of (1.258>2.578) years would be calculated as (125>257) which would return false
                // console.log(x.age_at_test, youngest_patient_tested.age_at_test, oldest_patient_tested.age_at_test)
                if(typeof youngest_patient_tested.age_at_test === 'undefined' || Math.round(youngest_patient_tested.age_at_test * 100)>=Math.round(x.age_at_test * 100)){
                    youngest_patient_tested =  x
                }
                if(typeof oldest_patient_tested.age_at_test === 'undefined' || Math.round(oldest_patient_tested.age_at_test * 100)<=Math.round(x.age_at_test * 100)){
                    oldest_patient_tested =  x
                }
                // type_counts[x.test_type_id]? true : type_counts[x.test_type_id] = {}
                // type_counts[x.test_type_id].name = x.test_type_name
                // type_counts[x.test_type_id].total = type_counts[x.test_type_id].total ? type_counts[x.test_type_id].total + 1 : 1 
                
                type_counts[x.test_type_id] = type_counts[x.test_type_id] ? type_counts[x.test_type_id] + 1 : 1 
                type_category_counts[x.test_type_category_id] = type_category_counts[x.test_type_category_id] ? type_category_counts[x.test_type_category_id] + 1 : 1 
            })
            console.log("Gender Counts are" ,gender_counts)
            console.log("Date Counts are",date_counts)
            console.log("Status Counts are",status_counts)
            console.log("Youngest Patient Tested",youngest_patient_tested)
            console.log("Oldest Patient Tested",oldest_patient_tested)
            console.log("Type Counts are",type_counts)
            console.log("Type Category Counts are",type_category_counts)

            let labels = [], gender_count_totals = [], gender_count_totals_done = []
            for (const key in gender_counts) {
                if (gender_counts.hasOwnProperty(key)) {
                    const element = gender_counts[key];
                    labels.push(key)
                    gender_count_totals.push(element.total)
                    gender_count_totals_done.push(element['3'])
                    console.log(element.total,key)
                }
            }
            let basicLineGraphOptions = {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                };
           
            let basicBackgroundColors = ['#1976d2', '#a6e1fa', '#0a2472', '#395C6B', '#EAD2AC', '#D1DEDE','#1D201F']
            
            var ctx = document.getElementById("myChart");
            var myRadarChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels,
                    datasets: [{
                            data: gender_count_totals,
                            label: 'Total Per Gender',
                            backgroundColor: basicBackgroundColors
                        }
                    ]
                },
                options:{
                    onClick: (e,i)=>{
                        console.log(e)
                        console.log(i)
                    }
                }
            });

            let ordered_date_counts = {};
            Object.keys(date_counts).sort().forEach(function(key) {
                ordered_date_counts[key] = date_counts[key];
            });
            let ordered_status_counts = {};
            Object.keys(status_counts).sort().forEach(function(key) {
                ordered_status_counts[key] = status_counts[key];
            });
            let ordered_type_category_counts = {};
            Object.keys(type_category_counts).sort().forEach(function(key) {
                ordered_type_category_counts[key] = type_category_counts[key];
            });
            var ctx2 = document.getElementById("myChart2");
            var myRadarChart = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: Object.keys(ordered_date_counts),
                    datasets: [{
                            data: Object.values(ordered_date_counts),
                            label: 'Total Per Date'
                        }
                    ]
                },
                options: basicLineGraphOptions
            });

            var ctx3 = document.getElementById("myChart3");
            var mydoughnutChart = new Chart(ctx3, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(ordered_status_counts).map(x=>{
                                return this.tests.statuses.filter(y =>{
                                    return y.id == x
                                })[0].name
                            }),
                    datasets: [{
                            data: Object.values(ordered_status_counts),
                            label: 'Total Test Per Status',
                            backgroundColor: basicBackgroundColors
                        }
                    ]
                }
            });

            var ctx4 = document.getElementById("myChart4");
            var mydoughnutChart2 = new Chart(ctx4, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(ordered_type_category_counts).map(x=>{
                                return this.tests.categories.filter(y =>{
                                    return y.id == x
                                })[0].name
                            }),
                    datasets: [{
                            data: Object.values(ordered_type_category_counts),
                            label: 'Total Test Per Category',
                            backgroundColor: basicBackgroundColors
                        }
                    ]
                }
            });
            
            
            Vue.set(this.tests,'cur',resp)
            Vue.set(this,'youngest_patient_tested',youngest_patient_tested)
            Vue.set(this,'oldest_patient_tested',oldest_patient_tested)
            
            Vue.set(this.counts, 'gender_counts', gender_counts)
            Vue.set(this.counts, 'date_counts', ordered_date_counts)
            Vue.set(this.counts, 'type_counts', type_counts)
        })
        .catch(error =>{
            console.log(error.response)
        })
    },

    totalTestsRequested(){
        let count = 0;      
        if(this.counts && this.counts.gender_counts){    
            let gcounts = this.counts.gender_counts
                  
            for (const key in gcounts) {
                if (gcounts.hasOwnProperty(key)) {
                    const element =gcounts[key];
                    count += element.total
                }
            }
        }
        console.log("Counts under total tests requested ",this.tests.cur)
        return count;
    },

    totalTestsStatus(status){
        return this.tests.cur.filter((x)=>{
            return x.test_status_id===status
        })
    },
    testsPerType(testType){
        for (const key in this.tests.type_counts) {
            if (this.tests.type_counts.hasOwnProperty(key)) {
                const element = this.tests.type_counts[key];
                
            }
        }
    },
    getTestTypes(){        
        return Object.keys(this.tests.type_counts)
    },

    getAge(birthday) {
      return ~~((Date.now() - Date.parse(birthday)) / 31557600000);
    }
  }
};
</script>