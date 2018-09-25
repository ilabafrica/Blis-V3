<template>
    <div>
        <v-layout row wrap>   
            <p class="flex xs12" style="font-size:2rem; font-weight:100">System Statistics</p>
        </v-layout>
        <v-layout row wrap>   
            <div v-if="logins" class="flex blis-stats-card-parent xs12 sm6 md4 lg3">
                <v-card >
                    <v-card-title class="headline blue-text">
                        <span class="grey--text">Registered Users: </span>{{counts.user_counts.total}} 
                    </v-card-title>
                    <v-card-text>
                        <p v-for="role in counts.user_counts.by_role" :key=role.id>
                            <span class="grey--text"># of {{role.name}}s: </span> {{role.total}}
                        </p>
                    </v-card-text>
                    <v-card-actions style="padding:0">                        
                        <v-btn :to="{name:'user_stats'}" block class="blue--text white" style="margin:0">View All</v-btn>
                    </v-card-actions>                    
                </v-card>
            </div>
            <div v-if="logins" class="flex blis-stats-card-parent xs12 sm6 md4 lg3">
                <v-card >
                    <v-card-title class="headline blue-text">
                        <span class="grey--text">Tests Recorded: </span> {{tests.total}}
                    </v-card-title>
                    <v-card-text>
                        <canvas id="ttChart" width="400" height="400"></canvas>
                    </v-card-text>
                    <v-card-actions style="padding:0">                        
                        <v-btn :to="{name:'tests_stats'}" block class="blue--text white" style="margin:0">View All</v-btn>
                    </v-card-actions>                    
                </v-card>
            </div>
            
            
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
    users:{},
    logins:[],
    tests: {
        cur:[],
        statuses:[],
        types:[],
        categories:[],
        total:0
    },
    counts:{
        user_counts:{},
        date_counts: {},
        status_counts: {},
        gender_counts : {},
        type_counts:{},
        type_category_counts:{}
    },
    oldest_patient_tested:{},
    youngest_patient_tested:{},
    basicBackgroundColors:['#1976d2', '#a6e1fa', '#0a2472', '#395C6B', '#EAD2AC', '#D1DEDE','#1D201F']
  }),

  computed: {
    length: function() {
        return Math.ceil(this.pagination.total / this.pagination.visible);
    },
    filteredUsers(){
        let filteredUser ={}
        if(this.users){
            for (const key in this.users) {
                if (this.users.hasOwnProperty(key)) {                
                    if(this.users[key].name.match(this.search)){
                        filteredUser[key]= this.users[key]
                    }
                }
            }
        }
        return filteredUser
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
        apiCall({url:this.url_prefix+"users/count", method:"GET"})
        .then(resp=>{
            Vue.set(this.counts.user_counts, 'total', resp)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"users/count?by_role=true", method:"GET"})
        .then(resp=>{
            Vue.set(this.counts.user_counts, 'by_role', resp)
        })
        .catch(error => {
            console.log(error.response)
        })
        let statuses_req = apiCall({url:this.url_prefix+"tests/statuses", method:"GET"})
        let totals_by_status_req = apiCall({url:this.url_prefix+"tests/totals?by_status=true", method:"GET"})

        Promise.all([statuses_req,totals_by_status_req])
        .then(values=>{
            Vue.set(this.tests, 'statuses', values[0])
            console.log("Statuses ",this.tests.statuses)

            let status_count = {} , total = 0
            values[1].forEach(element => {
                status_count[element.test_status_id] =  element.total
                total += element.total
            });
            
            Vue.set(this.tests, 'total', total)
            Vue.set(this.counts, 'status_counts', status_count)
            console.log("Status counts are ", status_count)
            this.generateStatusCountsGraph(status_count)
        }).catch(error => {
            console.log(error.response)
        })
        
    },
    generateStatusCountsGraph(status_count){
        var ctx_ttChart = document.getElementById("ttChart");
        var my_ttChart = new Chart(ctx_ttChart, {
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
                        backgroundColor: this.basicBackgroundColors
                    }
                ]
            }
        });
    }
  }
};
</script>