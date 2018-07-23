<template>
    <div>
        <v-layout v-if="counts.date_counts">
            <v-flex sm4 md3 l2 class="blis-stats-card-parent">
                <div class="elevation-1 blis-grid blis-stats-card">
                    <span class="blis-stats-num"> {{totalTestsRequested()}} </span>
                    <span class="blis-stats-num-label">Total Tests requested</span>
                </div>
            </v-flex>
            <div class="flex blis-stats-card-parent sm4 md3 l2" v-for="status in tests.statuses" :key=status.id>
                <div class="elevation-1 blis-grid blis-stats-card">
                    <span class="blis-stats-num"> {{totalTestsStatus(status.id).length}} </span>
                    <span class="blis-stats-num-label">Total Tests {{status.name}}</span>
                </div>
            </div>
        </v-layout>
        <v-layout style="margin:20px;">
            <v-flex sm6 style="padding:10px;">
                <v-card>
                    <v-card-title class="headline grey lighten-2" primary-title>
                        Total Tests Done Per Gender
                    </v-card-title>
                    <v-card-text>
                        <canvas id="myChart" width="400" height="400"></canvas>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex sm6 style="padding:10px;">
                <v-card>
                    <v-card-title class="headline grey lighten-2" primary-title>
                        Total Tests Per Day
                    </v-card-title>
                    <v-card-text>
                        <canvas id="myChart2" width="400" height="400"></canvas>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </div>
</template>
<script>
import apiCall from "../../utils/api";
import Chart from "chart.js";
export default {
  data: () => ({
    search: "",
    query: "",
    pagination: {
      page: 1,
      per_page: 0,
      total: 0,
      visible: 10
    },
    headers: [
      { text: "Time Ordered", value: "created_at" },
      { text: "Patient", value: "patient" },
      { text: "Specimen ID", value: "specimen_id" },
      { text: "Test", value: "test_type" },
      { text: "Visit", value: "encounter" },
      { text: "Status", value: "test_status" },
      { text: "Actions", value: "actions", sortable: false }
    ],
    tests: {
        cur:[],
        statuses:[]
    },
    counts:{
        date_counts: {},
        gender_counts : {}
    }
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

        apiCall({url:"/api/test-statuses?"+this.query, method:"GET"})
        .then(resp=>{
            Vue.set(this.tests, 'statuses', resp)
        })
        .catch(error => {
            console.log(error.response)
        })

        apiCall({url:"/api/tests-done/full?"+this.query, method:"GET"})
        .then(resp=>{
            console.log(resp)   
            // let gender_counts = {'1':0, '2':0, '3':0,'4':0}
            let gender_counts = {}
            let date_counts = {}
            let status_counts = {}
            let youngest_patient_tested = {}, oldest_patient_tested = {}
            resp.map(x =>{
                // For each iteration check if a gender index has been instanitated matching the current gender id and add 1 to it else assign the new gender count index a value of 1 
                // gender_counts[x.gender_id] = gender_counts[x.gender_id] ? gender_counts[x.gender_id] + 1 : 1;
                gender_counts[x.gender_id] ? true : gender_counts[x.gender_id]={}
                gender_counts[x.gender_id].total = gender_counts[x.gender_id].total ? gender_counts[x.gender_id].total + 1 : 1;
                gender_counts[x.gender_id][x.test_status_id]  = gender_counts[x.gender_id][x.test_status_id] ? gender_counts[x.gender_id][x.test_status_id] + 1 : 1                

                date_counts[x.test_started_at] = date_counts[x.test_started_at] ? date_counts[x.test_started_at] + 1 : 1 
                status_counts[x.test_status_id] = status_counts[x.test_status_id] ? status_counts[x.test_status_id] + 1 : 1 
                
                // float comparison is buggy so Math.round(age *100) before comparison this means a calculated age comparison of (1.258>2.578) years would be calculated as (125>257) which would return false
                //console.log(x.age_at_test, youngest_patient_tested.age_at_test, oldest_patient_tested.age_at_test)
                if(typeof youngest_patient_tested.age_at_test === 'undefined' || Math.round(youngest_patient_tested.age_at_test * 100)>=Math.round(x.age_at_test * 100)){
                    youngest_patient_tested =  x
                }
                if(typeof oldest_patient_tested.age_at_test === 'undefined' || Math.round(oldest_patient_tested.age_at_test * 100)<=Math.round(x.age_at_test * 100)){
                    oldest_patient_tested =  x
                }
                
            })
            console.log("Gender Counts are" ,gender_counts)
            console.log("Date Counts are",date_counts)
            console.log("Status Counts are",status_counts)
            console.log("Youngest Patient Tested",youngest_patient_tested)
            console.log("Oldest Patient Tested",oldest_patient_tested)
            
            Vue.set(this.tests,'cur',resp)
            
            Vue.set(this.counts, 'gender_counts', gender_counts)
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
           
            var ctx = document.getElementById("myChart");
            var myRadarChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                            data: gender_count_totals,
                            label: 'Total Per Gender'
                        },{
                            data: gender_count_totals_done,
                            label: 'Total Active Per Gender'
                        }
                    ]
                },
                options: basicLineGraphOptions
            });

            let ordered_date_counts = {};
            Object.keys(date_counts).sort().forEach(function(key) {
                ordered_date_counts[key] = date_counts[key];
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
        console.log(this.tests.cur)
        return count;
    },

    totalTestsStatus(status){
        return this.tests.cur.filter((x)=>{
            return x.test_status_id===status
        })
    },
    getAge(birthday) {
      return ~~((Date.now() - Date.parse(birthday)) / 31557600000);
    }
  }
};
</script>