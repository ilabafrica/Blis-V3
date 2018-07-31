<template>
    <div>
        <v-layout row wrap>   
            <p class="flex xs12" style="font-size:2rem; font-weight:100">System Statistics</p>
        </v-layout>
        <v-layout row wrap>   
            <div v-if="logins" class="flex blis-stats-card-parent xs12 sm6 md4 lg3">
                <v-card >
                    <v-card-title class="headline blue-text">
                        {{users.length}} Registered Users
                    </v-card-title>
                    <v-card-text>
                        <span class="grey--text">Account Created: </span> {{"N/A"}} <br>                      
                    </v-card-text>
                    <v-card-actions style="padding:0">                        
                        <v-btn :to="{name:'user_stats'}" block class="blue--text white" style="margin:0">View All</v-btn>
                    </v-card-actions>                    
                </v-card>
            </div>
            <div v-if="logins" class="flex blis-stats-card-parent xs12 sm6 md4 lg3">
                <v-card >
                    <v-card-title class="headline blue-text">
                        {{counts.status_counts.total}}<span class="grey--text"> Tests</span>
                    </v-card-title>
                    <v-card-text>
                        <span  v-for="status in tests.statuses" :key=status.id>
                            <span class="grey--text">Tests {{status.name || ""}}: </span> {{counts.status_counts[status.id]||0}} <br>
                        </span>
                    </v-card-text>
                    <v-card-actions style="padding:0">                        
                        <v-btn :to="{name:'user_stats'}" block class="blue--text white" style="margin:0">View All</v-btn>
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
        categories:[]
    },
    counts:{
        date_counts: {},
        status_counts: {},
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
        apiCall({url:this.url_prefix+"tests/statuses", method:"GET"})
        .then(resp=>{
            Vue.set(this.tests, 'statuses', resp)
            console.log("Statuses ",this.tests.statuses)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?by_status=true", method:"GET"})
        .then(resp=>{
            let status_count = {} , total = 0
            resp.forEach(element => {
                status_count[element.test_status_id] =  element.total
                total += element.total
            });
            status_count.total=total
            Vue.set(this.counts, 'status_counts', status_count)
            
            console.log("Status counts are ", status_count)
        })
        .catch(error => {
            console.log(error.response)
        })
    }
  }
};
</script>