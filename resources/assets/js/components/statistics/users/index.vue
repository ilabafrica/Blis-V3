<template>
    <div>
        <v-layout row wrap>   
            <p class="flex xs12 md6 lg4" style="font-size:2rem; font-weight:100">User Statistics</p>
            <v-flex xs12 md6 lg8>
                <v-text-field
                    v-model="search"
                    append-icon="search"
                    label="Search"
                    single-line
                    hide-details>
                </v-text-field>
            </v-flex>
        </v-layout>
        <v-layout row wrap>   
            <div v-if="logins" class="flex blis-stats-card-parent xs12 sm6 md4 lg4" v-for="(x,i) in filteredUsers" :key ="i">
                <v-card >
                    <v-card-title class="headline blue-text">
                        {{x.name}}
                    </v-card-title>
                    <hr>
                    <v-card-text>
                        <span class="grey--text">Account Created: </span> {{x.created_at || "N/A"}} <br>
                        <span class="grey--text">First Logged Access: </span> {{x.first_login || "N/A"}}<br>
                        <span class="grey--text">Last Logged Access: </span> {{x.last_login || "N/A"}}<br>
                        <span class="grey--text">Total Logged Accesses: </span> {{x.total || "N/A"}} <br>                        
                        <span class="grey--text">Tests Done: </span> {{x.tests_done || "N/A"}} <br>                        
                        <span class="grey--text">Tests Verified: </span> {{x.tests_verified || "N/A"}} <br>                        
                    </v-card-text>
                    <v-card-actions style="padding:0">                        
                        <v-btn :to="{name:'single_user_stats', params:{id:i}}" block class="blue--text white" style="margin:0">View More</v-btn>
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

        apiCall({url:this.url_prefix+"users?"+this.query, method:"GET"})
        .then(resp=>{
            let users = {}
            resp.map(x => {
                users[x.id]={name:x.name, created_at:x.created_at}
            })
            Vue.set(this, 'users', users)

            //Getting users is the backbone of stats, so its request is "blocking" the thread
            apiCall({url:this.url_prefix+"logins?"+this.query, method:"GET"})
            .then(resp=>{
                resp.forEach(element => {
                    this.users[element.user_id] = Object.assign({},this.users[element.user_id],{...element})
                });
                Vue.set(this, 'logins', resp)
                console.log("Logins are ", this.logins)
                console.log("User Details are ", this.users)
            })
            apiCall({url:this.url_prefix+"tests/totals?by_tester=true", method:"GET"})
            .then(resp=>{
                resp.forEach(element => {
                    if(element.tested_by){
                        Vue.set(this.users[element.tested_by],'tests_done',element.total)  
                    }
                });
                console.log("User Details with tests done are ", this.users)
            })
            .catch(error => {
                console.log(error.response)
            })
            apiCall({url:this.url_prefix+"tests/totals?by_verifier=true", method:"GET"})
            .then(resp=>{
                resp.forEach(element => {
                    if(element.verified_by){
                        Vue.set(this.users[element.verified_by],'tests_verified',element.total) 
                    }
                });
                console.log("User Details with tests verified are ", this.users)
            })
            .catch(error => {
                console.log(error.response)
            })
        })
        .catch(error => {
            console.log(error.response)
        })
    },

    getAge(birthday) {
      return ~~((Date.now() - Date.parse(birthday)) / 31557600000);
    }
  }
};
</script>