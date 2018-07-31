<template>
    <div>
        <v-layout row wrap v-if="tests.cur">            
            <v-flex xs12 sm4 md3 lg2 class="blis-stats-card-parent">
                <div class="elevation-1 blis-grid blis-stats-card">
                    <span class="blis-stats-num"> {{tests.total_created}} </span>
                    <span class="blis-stats-num-label">Total Tests requested</span>
                </div>
            </v-flex>
            <div class="flex blis-stats-card-parent xs12 sm4 md3 lg2" v-for="status in tests.statuses" :key=status.id>
                <div class="elevation-1 blis-grid blis-stats-card">
                    <span class="blis-stats-num"> {{counts.status_counts[status.id]||0}} </span>
                    <span class="blis-stats-num-label">Requested Tests {{status.name || ""}}</span>
                </div>
            </div>
            <div class="flex blis-stats-card-parent xs12 sm4 md3 lg2">
                <div class="elevation-1 blis-grid blis-stats-card">
                    <span class="blis-stats-num"> {{tests.total_done||"N/A"}} </span>
                    <span class="blis-stats-num-label">Tests Done By This User</span>
                </div>
            </div>
            <div class="flex blis-stats-card-parent xs12 sm4 md3 lg2">
                <div class="elevation-1 blis-grid blis-stats-card">
                    <span class="blis-stats-num"> {{tests.total_verified||"N/A"}} </span>
                    <span class="blis-stats-num-label">Tests Verified By This User</span>
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
        categories:[],
        total_created: 0,
        total_done: 0,
        total_verified: 0
    },
    counts:{
        date_counts: {},
        gender_counts : {},
        type_counts:{},
        status_counts:{},
        type_category_counts:{}
    },
    genders:{},
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
        if (this.search != "") {
            this.query = this.query + "&search=" + this.search;
        }
        let statuses_req = apiCall({url:this.url_prefix+"tests/statuses?"+this.query, method:"GET"})
        let genders_req = apiCall({url:this.url_prefix+"genders", method:"GET"})
        let types_req = apiCall({url:this.url_prefix+"tests/types?"+this.query, method:"GET"})
        let categories_req = apiCall({url:this.url_prefix+"tests/type-categories?"+this.query, method:"GET"})
        Promise.all([
            statuses_req.catch(error => {console.log(error.response)}),
            genders_req.catch(error => {console.log(error.response)}),
            types_req.catch(error => {console.log(error.response)}),
            categories_req.catch(error => {console.log(error.response)}),
        ]).then(values =>{
            Vue.set(this.tests, 'statuses', values[0])
            console.log("Test Statuses are ", this.tests.statuses)

            //  genders
            let genders = {}
            values[1].forEach(element => {
                genders[element.id] = {name:element.name, code:element.code}
            });
            Vue.set(this, 'genders', genders)
            console.log("Genders are ", this.genders)

            //  types and categories
            Vue.set(this.tests, 'types', values[2])
            Vue.set(this.tests, 'categories', values[3])
        })
        apiCall({url:this.url_prefix+"tests/totals?user_id="+this.$route.params.id, method:"GET"})
        .then(resp=>{
            Vue.set(this.tests, 'total_created', resp[0].total)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/done/totals?user_id="+this.$route.params.id, method:"GET"})
        .then(resp=>{
            Vue.set(this.tests, 'total_done', resp[0].total)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/verified/totals?user_id="+this.$route.params.id, method:"GET"})
        .then(resp=>{
            Vue.set(this.tests, 'total_verified', resp[0].total)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?user_id="+this.$route.params.id+"&by_status=true", method:"GET"})
        .then(resp=>{
            let status_count = {} 
            resp.forEach(element => {
                status_count[element.test_status_id] =  element.total
            });
            Vue.set(this.counts, 'status_counts', status_count)
            var ctx3 = document.getElementById("myChart3");
            var mydoughnutChart = new Chart(ctx3, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(status_count).map(x=>{
                                return this.tests.statuses.filter(y =>{
                                    return y.id == x
                                })[0].name
                            }),
                    datasets: [{
                            data: Object.values(status_count),
                            label: 'Total Test Per Status',
                            backgroundColor: basicBackgroundColors
                        }
                    ]
                }
            });
            console.log("Status counts are ", status_count)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?user_id="+this.$route.params.id+"&by_date=true", method:"GET"})
        .then(resp=>{
            let date_count = {} 
            resp.forEach(element => {
                date_count[element.timing] =  element.total
            });
            let ordered_date_counts = {};
            Object.keys(date_count).sort().forEach(function(key) {
                ordered_date_counts[key] = date_count[key];
            });
            Vue.set(this.counts, 'date_counts', ordered_date_counts)

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
            console.log("Date counts are ", ordered_date_counts)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?user_id="+this.$route.params.id+"&by_category=true", method:"GET"})
        .then(resp=>{
            let category_count = {} 
            resp.forEach(element => {
                category_count[element.ttc_id] =  element.total
            });
            let ordered_type_category_counts = {};
            Object.keys(category_count).sort().forEach(function(key) {
                ordered_type_category_counts[key] = category_count[key];
            });
            Vue.set(this.counts, 'type_category_counts', ordered_type_category_counts)

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
            console.log("Category counts are ", category_count)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?user_id="+this.$route.params.id+"&by_gender=true", method:"GET"})
        .then(resp=>{
            let gender_count = {} 
            resp.forEach(element => {
                if(this.genders){
                    gender_count[this.genders[element.gender_id].code] =  element.total
                }
                else{
                    gender_count[element.gender_id] =  element.total
                }
            });
            Vue.set(this.counts, 'gender_counts', gender_count)
            var ctx = document.getElementById("myChart");
            var myRadarChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(gender_count),
                    datasets: [{
                            data: Object.values(gender_count),
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
            console.log("Gender counts are ", gender_count)
        })
        .catch(error => {
            console.log(error.response)
        })
    }
  }
};
</script>