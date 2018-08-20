<template>
    <div>
        <v-layout row wrap>
            <p class="flex xs12" style="font-size:2rem; font-weight:100">Specimen Statistics ({{specimen.total}} <small class="grey--text">Specimen Recorded</small>)</p>            
            <div v-if="counts.by_status" class="flex blis-stats-card-parent xs12 sm6 md3 lg3" v-for="status in specimen.statuses" :key=status.id>
                <div class="elevation-1 blis-grid blis-stats-card">
                    <span class="blis-stats-num"> {{counts.by_status[status.id]||0}} </span>
                    <span class="blis-stats-num-label">Specimen {{status.name || ""}}</span>
                </div>
                <v-btn v-if="counts.by_status[status.id]>0" block class="green--text white" style="margin:0">View Specimen</v-btn>
                <v-btn v-else block class="grey--text white" style="margin:0">View Specimen</v-btn>
            </div>
        </v-layout>
        <v-layout row wrap style="margin:20px;">
            <v-flex xs12 sm12 md6 lg6 style="padding:10px;">
                <v-card>
                    <v-card-title class="headline grey lighten-2" primary-title>
                        Specimen Collected Per Day
                    </v-card-title>
                    <v-card-text>
                        <canvas id="count_per_date_collected_chart" width="400" height="400"></canvas>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12 sm12 md6 lg6 style="padding:10px;">
                <v-card>
                    <v-card-title class="headline grey lighten-2" primary-title>
                        Specimen Received Per Day
                    </v-card-title>
                    <v-card-text>
                        <canvas id="count_per_date_received_chart" width="400" height="400"></canvas>
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
    user:{},
    specimen: {
        statuses:[],
        types:[],
        total:0   
    },
    counts:{
        by_status:{},
        by_type:{},
        by_date_collected:{},
        by_date_received:{},
    },
    basicLineGraphOptions:{
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    },
    basicBackgroundColors:['#1976d2', '#a6e1fa', '#0a2472', '#395C6B', '#EAD2AC', '#D1DEDE','#1D201F']
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
        let statuses_req = apiCall({url:this.url_prefix+"specimen/statuses?"+this.query, method:"GET"})
        let types_req = apiCall({url:this.url_prefix+"specimen/types?"+this.query, method:"GET"})
        Promise.all([
            statuses_req.catch(error => {console.log("Status Request error",error.response)}),
            types_req.catch(error => {console.log("Types Request error",error.response)}),
        ]).then(values =>{
            Vue.set(this.specimen, 'statuses', values[0])
            console.log("Specimen Statuses are ", this.specimen.statuses)            
            //  types and categories
            Vue.set(this.specimen, 'types', values[1])
            console.log("Specimen Types are ", this.specimen.types)     
        })
        apiCall({url:this.url_prefix+"specimen/totals", method:"GET"})
        .then(resp=>{
            Vue.set(this.specimen, 'total', resp[0].total)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"specimen/totals?by_status=true", method:"GET"})
        .then(resp=>{
            let status_count = {} 
            resp.forEach(element => {
                status_count[element.specimen_status_id] =  element.total
            });
            Vue.set(this.counts, 'by_status', status_count)
            // this.generateStatusCountsGraph(status_count)
            console.log("Status counts are ", status_count)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"specimen/totals?by_date_collected=true", method:"GET"})
        .then(resp=>{
            let date_count = {} 
            resp.forEach(element => {
                date_count[element.date_collected] =  element.total
            });
            Vue.set(this.counts, 'by_date_collected', date_count)
            this.generateDateCountsGraph("count_per_date_collected_chart",this.counts.by_date_collected)
            console.log("Date counts are ", this.counts.by_date_collected)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"specimen/totals?by_date_received=true", method:"GET"})
        .then(resp=>{
            let date_count = {} 
            resp.forEach(element => {
                date_count[element.specimen_received_at] =  element.total
            });
            Vue.set(this.counts, 'by_date_received', date_count)

            this.generateDateCountsGraph("count_per_date_received_chart",this.counts.by_date_received)
            console.log("Date counts are ", this.counts.by_date_received)
        })
        .catch(error => {
            console.log(error.response)
        })
    },
    generateDateCountsGraph(canvas_id,date_count){        
        let ordered_date_counts = {};
        Object.keys(date_count).sort().forEach(function(key) {
            ordered_date_counts[key] = date_count[key];
        });
        var ctx_cpdChart = document.getElementById(canvas_id);
        var my_cpdChart = new Chart(ctx_cpdChart, {
            type: 'bar',
            data: {
                labels: Object.keys(ordered_date_counts),
                datasets: [{
                        data: Object.values(ordered_date_counts),
                        label: 'Total Per Date'
                    }
                ]
            },
            options: this.basicLineGraphOptions
        });
    },
    generateStatusCountsGraph(status_count){
        var ctx_cpsChart = document.getElementById("cpsChart");
        var my_cpsChart = new Chart(ctx_cpsChart, {
            type: 'doughnut',
            data: {
                labels: Object.keys(status_count).map(x=>{
                            return this.specimen.statuses.filter(y =>{
                                return y.id == x
                            })[0].name
                        }),
                datasets: [{
                        data: Object.values(status_count),
                        label: 'Total Specimen Per Status',
                        backgroundColor: this.basicBackgroundColors
                    }
                ]
            }
        });
    }    
  }
};
</script>