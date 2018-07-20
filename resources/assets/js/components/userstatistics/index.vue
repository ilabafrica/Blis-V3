<template>
    <div>
        <v-layout v-if="counts.date_counts">
            <v-flex sm4 md3 l2 class="blis-stats-card-parent">
                <div class="elevation-1 blis-grid blis-stats-card">
                    <span class="blis-stats-num"> {{total_tests_done()}} </span>
                    <span class="blis-stats-num-label">Total Tests Done</span>
                </div>
            </v-flex>

        </v-layout>
        <v-layout style="margin:20px;">
            <v-flex sm6 style="padding:10px;">
                <v-card>
                    <v-card-title class="headline grey lighten-2" primary-title>
                        Total Tests Done
                    </v-card-title>
                    <v-card-text>
                        <canvas id="myChart" width="400" height="400"></canvas>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex sm6>
                <canvas id="myChart2" width="400" height="400"></canvas>
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
    tests: [],
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

        apiCall({url:"/api/tests-done/full?"+this.query, method:"GET"})
        .then(resp=>{
            console.log(resp)            
            let uniqueDates = resp.map(x=> x.test_started_at).filter((v, i, a) => a.indexOf(v) === i)
            console.log(uniqueDates)
            // let gender_counts = {'1':0, '2':0, '3':0,'4':0}
            let gender_counts = {}
            let date_counts = {}
            let status_counts = {}
            resp.map(x =>{
                // For each iteration check if a gender index has been instanitated matching the current gender id and add 1 to it else assign the new gender count index a value of 1 
                // gender_counts[x.gender_id] = gender_counts[x.gender_id] ? gender_counts[x.gender_id] + 1 : 1;
                gender_counts[x.gender_id] ? true : gender_counts[x.gender_id]={}
                gender_counts[x.gender_id].total = gender_counts[x.gender_id].total ? gender_counts[x.gender_id].total + 1 : 1;
                gender_counts[x.gender_id][x.test_status_id]  = gender_counts[x.gender_id][x.test_status_id] ? gender_counts[x.gender_id][x.test_status_id] + 1 : 1                

                date_counts[x.test_started_at] = date_counts[x.test_started_at] ? date_counts[x.test_started_at] + 1 : 1 
                status_counts[x.test_status_id] = status_counts[x.test_status_id] ? status_counts[x.test_status_id] + 1 : 1 
            })
            console.log("Gender Counts are" ,gender_counts)
            console.log("Date Counts are",date_counts)
            console.log("Status Counts are",status_counts)
            
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
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                } 
            });
        })
        .catch(error =>{
            console.log(error.response)
        })
    },

    total_tests_done(){
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
        return count;
    },
    getAge(birthday) {
      return ~~((Date.now() - Date.parse(birthday)) / 31557600000);
    }
  }
};
</script>