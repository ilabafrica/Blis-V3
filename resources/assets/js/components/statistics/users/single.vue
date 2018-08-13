<template>
    <div>
        <v-layout row wrap v-if="tests.cur">
            <v-flex xs12 sm8 md9 l10 class="blis-stats-card-parent">
                <v-card>
                    <v-card-title class="headline blue-text">
                        <span class="grey--text">Registered Name:  </span> {{user.name}}
                    </v-card-title>
                    <v-card-text>
                        <span class="grey--text">Account Created: </span> {{user.created_at || "N/A"}} <br>
                        <span class="grey--text">First Logged Access: </span> {{user.first_login || "N/A"}}<br>
                        <span class="grey--text">Last Logged Access: </span> {{user.last_login || "N/A"}}<br>
                        <span class="grey--text">Total Logged Accesses: </span> {{user.total || "N/A"}} <br>                       
                    </v-card-text>
                    <v-card-actions style="padding:0">                        
                        
                    </v-card-actions>                    
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout row wrap v-if="tests.cur">
            <v-flex xs12 sm4 md4 lg4 class="blis-stats-card-parent">
                <div class="elevation-1 blis-grid blis-stats-card">
                    <span class="blis-stats-num"> {{tests.total_created}} </span>
                    <span class="blis-stats-num-label">Total Tests requested</span>
                </div>
                <v-btn @click.native="setStats('created')" block class="blue--text white" style="margin:0">View Stats</v-btn>
            </v-flex>            
            <div class="flex blis-stats-card-parent xs12 sm4 md4 lg4">
                <div class="elevation-1 blis-grid blis-stats-card">
                    <span class="blis-stats-num"> {{tests.total_done||"N/A"}} </span>
                    <span class="blis-stats-num-label">Tests Done By This User</span>
                </div>
                <v-btn @click.native="setStats('done')" block class="blue--text white" style="margin:0">View Stats</v-btn>
            </div>
            <div class="flex blis-stats-card-parent xs12 sm4 md4 lg4">
                <div class="elevation-1 blis-grid blis-stats-card">
                    <span class="blis-stats-num"> {{tests.total_verified||"N/A"}} </span>
                    <span class="blis-stats-num-label">Tests Verified By This User</span>                                        
                </div>
                <v-btn @click.native="setStats('verified')" :to="{name:'single_user_stats'}" block class="blue--text white" style="margin:0">View Stats</v-btn>
            </div>
        </v-layout>
        <v-layout row wrap>
            <div v-if="counts.created.by_status" class="flex blis-stats-card-parent xs12 sm4 md4 lg3" v-for="status in tests.statuses" :key=status.id>
                <div class="elevation-1 blis-grid blis-stats-card">
                    <span class="blis-stats-num"> {{counts.created.by_status[status.id]||0}} </span>
                    <span class="blis-stats-num-label">Requested Tests {{status.name || ""}}</span>
                </div>
                <v-btn v-if="counts.created.by_status[status.id]>0" :to="{name:'single_user_stats'}" block class="green--text white" style="margin:0">View Tests</v-btn>
                <v-btn v-else block class="grey--text white" style="margin:0">View Tests</v-btn>
            </div>
        </v-layout>
        <v-layout row wrap style="margin:20px;">
            <v-dialog v-model="dialog" hide-overlay persistent width="300" >
                <v-card color="primary" dark >
                    <v-card-text>
                    Loading Stats, Please stand by
                    <v-progress-linear indeterminate color="white" class="mb-0" ></v-progress-linear>
                    </v-card-text>
                </v-card>
            </v-dialog>
            <v-flex xs12 sm6 md4 lg4 style="padding:10px;">
                <v-card>
                    <v-card-title class="headline grey lighten-2" primary-title>
                        Tests {{active_stats}} Per Category
                    </v-card-title>
                    <v-card-text>
                        <canvas id="cpcChart" width="400" height="400"></canvas>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md4 lg4 style="padding:10px;">
                <v-card>
                    <v-card-title class="headline grey lighten-2" primary-title>
                        Tests {{active_stats}} Per Day
                    </v-card-title>
                    <v-card-text>
                        <canvas id="cpdChart" width="400" height="400"></canvas>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md4 lg4 style="padding:10px;">
                <v-card>
                    <v-card-title class="headline grey lighten-2" primary-title>
                        Tests {{active_stats}} Per Status
                    </v-card-title>
                    <v-card-text>
                        <canvas id="cpsChart" width="400" height="400"></canvas>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md4 lg4 style="padding:10px;">
                <v-card>
                    <v-card-title class="headline grey lighten-2" primary-title>
                        Tests {{active_stats}} Per Gender
                    </v-card-title>
                    <v-card-text>
                        <canvas id="cpgChart" width="400" height="400"></canvas>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md4 lg4 style="padding:10px;">
                <v-card>
                    <v-card-title class="headline grey lighten-2" primary-title>
                        Tests {{active_stats}} Per Age Group
                    </v-card-title>
                    <v-card-text>
                        <canvas id="cpaChart" width="400" height="400"></canvas>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md4 lg4 style="padding:10px;">
                <v-card>
                    <v-card-title class="headline grey lighten-2" primary-title>
                        Turn Around Times Stats for Tests {{active_stats}} by User
                    </v-card-title>
                    <v-card-text>
                        <p>Calculation of TAT is only done on completed tests that fit within the rest of the parameters</p>
                        <div id="tat_stats"></div>
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
    dialog: false,
    pagination: {
      page: 1,
      per_page: 0,
      total: 0,
      visible: 10
    },
    user:{},
    tests: {
        cur:[],
        statuses:[],
        types:[],
        categories:[],
        total_created: 0,
        total_done: 0,
        total_verified: 0
    },
    active_stats:'Created',
    counts:{
        created:{
            total:0,
            by_date:{},
            by_gender:{},
            by_category:{},
            by_type:{},
            by_status:{}
        },
        done:{
            total:0,
            by_date:{},
            by_gender:{},
            by_category:{},
            by_type:{},
            by_status:{}
        },
        verified:{
            total:0,
            by_date:{},
            by_gender:{},
            by_category:{},
            by_type:{},
            by_status:{}
        },
        date_counts: {},
        gender_counts : {},
        type_counts:{},
        status_counts:{},
        type_category_counts:{}
    },
    genders:{},
    oldest_patient_tested:{},
    youngest_patient_tested:{},
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
        apiCall({url:this.url_prefix+"users?user_id="+this.$route.params.id, method:"GET"})
        .then(resp=>{
            console.log("User is ",resp[0])
            if(resp[0]){
                Vue.set(this.user,"name",resp[0].name)
                Vue.set(this.user,"created_at",resp[0].created_at)
            }
        })
        .catch(error=>{
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"logins?user_id="+this.$route.params.id, method:"GET"})
        .then(resp=>{
            console.log("Logins are ",resp[0])
            if(resp[0]){
                Vue.set(this.user,"total",resp[0].total)
                Vue.set(this.user,"last_login",resp[0].last_login)
                Vue.set(this.user,"first_login",resp[0].first_login)
            }
        })
        .catch(error=>{
            console.log(error.response)
        })
        let statuses_req = apiCall({url:this.url_prefix+"tests/statuses", method:"GET"})
        let genders_req = apiCall({url:this.url_prefix+"genders", method:"GET"})
        let types_req = apiCall({url:this.url_prefix+"tests/types", method:"GET"})
        let categories_req = apiCall({url:this.url_prefix+"tests/type-categories", method:"GET"})
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
        apiCall({url:this.url_prefix+"tests/totals?tested_by="+this.$route.params.id, method:"GET"})
        .then(resp=>{
            Vue.set(this.tests, 'total_done', resp[0].total)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?verified_by="+this.$route.params.id, method:"GET"})
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
            Vue.set(this.counts.created, 'by_status', status_count)
            this.generateStatusCountsGraph(status_count)
            console.log("Status counts are ", status_count)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?user_id="+this.$route.params.id+"&by_date_created=true", method:"GET"})
        .then(resp=>{
            let date_count = {} 
            resp.forEach(element => {
                date_count[element.test_created_at] =  element.total
            });
            Vue.set(this.counts.created, 'by_date', date_count)

            this.generateDateCountsGraph(this.counts.created.by_date)
            console.log("Date counts are ", this.counts.created.by_date)
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
            Vue.set(this.counts.created, 'by_category', category_count)
            this.generateCategoryCountsGraph(category_count)
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
            Vue.set(this.counts.created, 'by_gender', gender_count)
            this.generateGenderCountsGraph(gender_count)
            console.log("Gender counts are ", gender_count)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?user_id="+this.$route.params.id+"&by_age=true", method:"GET"})
        .then(resp=>{
            let ages_count = {} 
            resp.forEach(element => {
                ages_count["Under 5"] = element.under_5
                ages_count["5 to 20"] = element["5_to_20"]
                ages_count["Over 20"] = element["over_20"]
            });
            Vue.set(this.counts.created, 'by_patient_age', ages_count)
            this.generateAgeCountsGraph(ages_count)
            console.log("Gender counts are ", ages_count)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?user_id="+this.$route.params.id+"&with_tat=true", method:"GET"})
        .then(resp=>{
            let tat = this.extractWithTAT(resp)
            Vue.set(this.counts.created, 'tat', tat)
            this.displayTatStats(tat)
        })
        .catch(error => {
            console.log(error.response)
        })
    },
    setStats(status){
        Vue.set(this,"dialog",true)
        switch (status) {
            case "done":
                this.getTestsDone()                         
                this.active_stats = "Done"
                break;
        
            case "verified":
                this.getTestsVerified();
                this.active_stats = "Verified"
                break;
            case "created":                
                this.active_stats = "Created"
                let created_counts = this.counts.created
                this.generateStatusCountsGraph(created_counts.by_status)
                this.generateDateCountsGraph(created_counts.by_date)
                this.generateCategoryCountsGraph(created_counts.by_category)
                this.generateGenderCountsGraph(created_counts.by_gender)
                this.displayTatStats(created_counts.tat)
                Vue.set(this,"dialog",false)
                break;
        
            default:
                break;
        }
    },
    getTestsDone(){        
        apiCall({url:this.url_prefix+"tests/totals?tested_by="+this.$route.params.id+"&by_status=true", method:"GET"})
        .then(resp=>{
            let status_count = {} 
            resp.forEach(element => {
                status_count[element.test_status_id] =  element.total
            });
            Vue.set(this.counts.done, 'by_status', status_count)
            this.generateStatusCountsGraph(status_count)
            console.log("Status counts are ", status_count)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?tested_by="+this.$route.params.id+"&by_date_completed=true", method:"GET"})
        .then(resp=>{
            let date_count = {} 
            resp.forEach(element => {
                date_count[element.test_completed_at] =  element.total
            });
            Vue.set(this.counts.done, 'by_date', date_count)

            this.generateDateCountsGraph(this.counts.done.by_date)
            console.log("Date counts are ", this.counts.done.by_date)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?tested_by="+this.$route.params.id+"&by_category=true", method:"GET"})
        .then(resp=>{
            let category_count = {} 
            resp.forEach(element => {
                category_count[element.ttc_id] =  element.total
            });
            Vue.set(this.counts.created, 'by_category', category_count)
            this.generateCategoryCountsGraph(category_count)
            console.log("Category counts are ", category_count)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?tested_by="+this.$route.params.id+"&by_gender=true", method:"GET"})
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
            Vue.set(this.counts.done, 'by_gender', gender_count)
            this.generateGenderCountsGraph(gender_count)
            console.log("Gender counts are ", gender_count)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?tested_by="+this.$route.params.id+"&by_age=true", method:"GET"})
        .then(resp=>{
            let ages_count = {} 
            resp.forEach(element => {
                ages_count["Under 5"] = element.under_5
                ages_count["5 to 20"] = element["5_to_20"]
                ages_count["Over 20"] = element["over_20"]
            });
            Vue.set(this.counts.created, 'by_patient_age', ages_count)
            this.generateAgeCountsGraph(ages_count)
            console.log("Gender counts are ", ages_count)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?tested_by="+this.$route.params.id+"&with_tat=true", method:"GET"})
        .then(resp=>{
            let tat = this.extractWithTAT(resp)
            Vue.set(this.counts.done, 'tat', tat)
            this.displayTatStats(tat)
        })
        .catch(error => {
            console.log(error.response)
        })
    },
    getTestsVerified(){        
        apiCall({url:this.url_prefix+"tests/totals?verified_by="+this.$route.params.id+"&by_status=true", method:"GET"})
        .then(resp=>{
            let status_count = {} 
            resp.forEach(element => {
                status_count[element.test_status_id] =  element.total
            });
            Vue.set(this.counts.verified, 'by_status', status_count)
            this.generateStatusCountsGraph(status_count)
            console.log("Status counts are ", status_count)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?verified_by="+this.$route.params.id+"&by_date_verified=true", method:"GET"})
        .then(resp=>{
            let date_count = {} 
            resp.forEach(element => {
                date_count[element.test_verified_at] =  element.total
            });
            Vue.set(this.counts.verified, 'by_date', date_count)

            this.generateDateCountsGraph(this.counts.verified.by_date)
            console.log("Date counts are ", this.counts.verified.by_date)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?verified_by="+this.$route.params.id+"&by_category=true", method:"GET"})
        .then(resp=>{
            let category_count = {} 
            resp.forEach(element => {
                category_count[element.ttc_id] =  element.total
            });
            Vue.set(this.counts.created, 'by_category', category_count)
            this.generateCategoryCountsGraph(category_count)
            console.log("Category counts are ", category_count)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?verified_by="+this.$route.params.id+"&by_gender=true", method:"GET"})
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
            Vue.set(this.counts.verified, 'by_gender', gender_count)
            this.generateGenderCountsGraph(gender_count)
            console.log("Gender counts are ", gender_count)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?verified_by="+this.$route.params.id+"&by_age=true", method:"GET"})
        .then(resp=>{
            let ages_count = {} 
            resp.forEach(element => {
                ages_count["Under 5"] = element.under_5
                ages_count["5 to 20"] = element["5_to_20"]
                ages_count["Over 20"] = element["over_20"]
            });
            Vue.set(this.counts.created, 'by_patient_age', ages_count)
            this.generateAgeCountsGraph(ages_count)
            console.log("Gender counts are ", ages_count)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:this.url_prefix+"tests/totals?verified_by="+this.$route.params.id+"&with_tat=true", method:"GET"})
        .then(resp=>{
            let tat = this.extractWithTAT(resp)
            Vue.set(this.counts.verified, 'tat', tat)
            this.displayTatStats(tat)
        })
        .catch(error => {
            console.log(error.response)
        })
    },
    generateDateCountsGraph(date_count){        
        let ordered_date_counts = {};
        Object.keys(date_count).sort().forEach(function(key) {
            ordered_date_counts[key] = date_count[key];
        });
        let chartParent = document.getElementById("cpdChart").parentElement;
        // console.log(chartParent)
        chartParent.innerHTML ='<canvas id="cpdChart" width="400" height="400"></canvas>';
        var ctx_cpdChart = document.getElementById("cpdChart");
        var my_cpdChart = new Chart(ctx_cpdChart, {
            type: 'bar',
            data: {
                labels: Object.keys(ordered_date_counts),
                datasets: [{
                        data: Object.values(ordered_date_counts),
                        label: `Total ${this.active_stats} Per Date`
                    }
                ]
            },
            options: this.basicLineGraphOptions
        });
    },
    generateStatusCountsGraph(status_count){
        let chartParent = document.getElementById("cpsChart").parentElement;
        chartParent.innerHTML ='<canvas id="cpsChart" width="400" height="400"></canvas>';
        var ctx_cpsChart = document.getElementById("cpsChart");
        var my_cpsChart = new Chart(ctx_cpsChart, {
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
    },
    generateCategoryCountsGraph(category_count){            
        let ordered_type_category_counts = {};
        Object.keys(category_count).sort().forEach(function(key) {
            ordered_type_category_counts[key] = category_count[key];
        });    
        let chartParent = document.getElementById("cpcChart").parentElement;
        chartParent.innerHTML ='<canvas id="cpcChart" width="400" height="400"></canvas>';
        var ctx_cpcChart = document.getElementById("cpcChart");
        var my_cpcChart = new Chart(ctx_cpcChart, {
            type: 'doughnut',
            data: {
                labels: Object.keys(ordered_type_category_counts).map(x=>{
                            return this.tests.categories.filter(y =>{
                                return y.id == x
                            })[0].name
                        }),
                datasets: [{
                        data: Object.values(ordered_type_category_counts),
                        label: `Total ${this.active_stats} Per Category`,
                        backgroundColor: this.basicBackgroundColors
                    }
                ]
            }
        });
    },
    generateGenderCountsGraph(gender_count){
        let chartParent = document.getElementById("cpgChart").parentElement;
        chartParent.innerHTML ='<canvas id="cpgChart" width="400" height="400"></canvas>';
        var ctx_cpgChart = document.getElementById("cpgChart");
        var my_cpgChart = new Chart(ctx_cpgChart, {
            type: 'doughnut',
            data: {
                labels: Object.keys(gender_count),
                datasets: [{
                        data: Object.values(gender_count),
                        label: `Total ${this.active_stats} Per Gender`,
                        backgroundColor: this.basicBackgroundColors
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
    },
    generateAgeCountsGraph(ages_count){
        let chartParent = document.getElementById("cpaChart").parentElement;
        chartParent.innerHTML ='<canvas id="cpaChart" width="400" height="400"></canvas>';
        var ctx_cpaChart = document.getElementById("cpaChart");
        var my_cpaChart = new Chart(ctx_cpaChart, {
            type: 'doughnut',
            data: {
                labels: Object.keys(ages_count),
                datasets: [{
                        data: Object.values(ages_count),
                        label: `Total ${this.active_stats} Per Ages`,
                        backgroundColor: this.basicBackgroundColors.slice().reverse()
                    }
                ]
            }
        });
        Vue.set(this,"dialog",false)
    },
    extractWithTAT(resp){
        let tat = {}
        resp.forEach(element => {
            tat["# of Tests Used"] = element.total
            tat["Average TAT"] = element.avg_tat+" minutes"
            tat["# of Tests with TAT > 20 minutes"] = element.lte_20 
            tat["# of Tests with TAT between 20 to 60"] = element["20_to_60"]
            tat["# of Tests with TAT Over 60 minutes"] = element.gte_60
        });
        return tat;
    },
    displayTatStats(stats){
        let statsHTML = ''
        for (const key in stats) {
            if (stats.hasOwnProperty(key)) {
                const element = stats[key];
                statsHTML +=`<p><span class="grey--text">${key}:  </span>${stats[key]}</p>`
            }
        }
        document.getElementById("tat_stats").innerHTML = statsHTML;
    }
  }
};
</script>