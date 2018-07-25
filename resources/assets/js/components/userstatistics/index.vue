<template>
    <div>
        <v-layout row wrap>   
            <div v-if="logins" class="flex blis-stats-card-parent xs12 sm6 md4 lg3" v-for="x in getAggregateLogins()" :key ="x">
                <v-card>
                    <v-card-title class="headline grey lighten-2" >
                        {{x.details.name}}
                    </v-card-title>
                    <v-card-text>
                        Account Created: {{x.details.created_at}} <br>
                        First Logged Access: {{x.first_login}}<br>
                        Last Logged Access: {{x.last_login}}<br>
                        Total Logged Accesses: {{x.total}}
                    </v-card-text>
                </v-card>
            </div>
            
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
    users:{},
    logins:[],
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

        apiCall({url:"/api/stats/users?"+this.query, method:"GET"})
        .then(resp=>{
            for (const key in resp) {
                if (resp.hasOwnProperty(key)) {
                    resp[key] = {name: resp[key]}
                }
            }
            Vue.set(this, 'users', resp)
            
            apiCall({url:"/api/logins?"+this.query, method:"GET"})
            .then(resp=>{
                Vue.set(this, 'logins', resp)
                console.log("Logins are ", this.logins)
            })

            apiCall({url:"/api/test-statuses?"+this.query, method:"GET"})
            .then(resp=>{
                Vue.set(this.tests, 'statuses', resp)
                console.log("Test Statuses are ", this.tests.statuses)
            })
            .catch(error => {
                console.log(error.response)
            })
            apiCall({url:"/api/test-types?"+this.query, method:"GET"})
            .then(resp=>{
                Vue.set(this.tests, 'types', resp)
            })
            .catch(error => {
                console.log(error.response)
            })
            apiCall({url:"/api/test-type-categories?"+this.query, method:"GET"})
            .then(resp=>{
                Vue.set(this.tests, 'categories', resp)
            })
            .catch(error => {
                console.log(error.response)
            })
            apiCall({url:"/api/tests-done/total?"+this.query, method:"GET"})
            .then(resp=>{
                Vue.set(this.tests, 'categories', resp)
            })
            .catch(error => {
                console.log(error.response)
            })
        })
        .catch(error => {
            console.log(error.response)
        })
    },

    getAggregateLogins(){
        let counts={}
        this.logins.forEach(x => {
            if(counts[x.id]){
                counts[x.id].total += 1
                if(new Date(x.access_time)>new Date(counts[x.id].last_login)){
                    counts[x.id].last_login = x.access_time
                }
                if(new Date(x.access_time)<new Date(counts[x.id].first_login)){
                    counts[x.id].first_login = x.access_time
                }
            }else{
                counts[x.id] = {total: 1, details:x, first_login:x.access_time, last_login:x.access_time}
            }
        });
        return counts
    },

    getAge(birthday) {
      return ~~((Date.now() - Date.parse(birthday)) / 31557600000);
    }
  }
};
</script>