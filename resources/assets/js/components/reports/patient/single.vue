<template>
    <div>
        <v-layout row wrap align-center>
            <v-flex xs12 md6 pa-4 v-if="patient.name" style="font-size:1.4em;">
                <b>Patient Name:</b> {{patient.name.family}}, {{patient.name.given}}<br>
                <b>Gender:</b> {{patient.gender.display}} <br>
                <b>Date Of Birth:</b> {{patient.birth_date}}
            </v-flex>
            <v-flex xs12 md6 text-md-right pr-5>
                <p style="font-size:1.4rem; font-weight:100">Patient Report</p>
                <v-btn @click.native="getPDF()">Get PDF</v-btn>
            </v-flex>
        </v-layout>
        <v-layout row wrap ml-4 mr-4 align-center v-if="patient.tests" v-for="test in patient.tests" :key="test.id">
            <v-flex xs12 mt-4 mb-3>
                <v-divider></v-divider>
            </v-flex>
            <v-flex md6 title pa-2 style="color:#5c5c5c;"><b>Test Num:</b> {{test.id}}</v-flex>
            <v-flex md6 pa-2 subheading>
                <b>Test Type:</b> {{test.test_type.name}} <br>
                <b>Test Ordered:</b> {{test.created_at}} <br>
                <b>Test Status:</b> {{test.test_status.name}} <br>
            </v-flex>
            <v-flex md12 white>
                <table class="table text-md-right elevation-1" v-if="test.specimen.id">
                    <thead>
                        <tr>
                            <th>Specimen Type</th>
                            <th>Collected By</th>
                            <th>Date Collected</th>
                            <th>Date Received</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{test.specimen.specimen_type.name}}</td>
                            <td>{{test.specimen.collected_by.name}}</td>
                            <td>{{test.specimen.time_collected}}</td>
                            <td>{{test.specimen.time_received}}</td>
                            <td>{{test.specimen.status.name}}</td>
                        </tr>
                    </tbody>
                </table>
            </v-flex>
            <v-flex md12 pt-2>
                <table class="table text-md-right elevation-1" md12 v-if="test.results">
                    <thead>
                        <tr>
                            <th>Result</th>
                            <th>Measure</th>
                            <th>Result</th>
                            <th>Time Entered</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody v-if="result.id" v-for="result in test.results" :key="result.id">
                        <tr>
                            <td>{{result.id}}</td>
                            <td>{{result.measure.name}}</td>
                            <td>{{result.result}}</td>
                            <td>{{result.time_entered}}</td>
                            <td>{{test.specimen.status.name}}</td>
                        </tr>
                    </tbody>
                </table>
            </v-flex>
        </v-layout>
    </div>
</template>

<style scoped>
    th{
        background-color: #5c5c5c;
        color: white !important;
    }
    b{
        color: #5c5c5c;
    }
</style>


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
    toggle_filter_options:true,
    total_tests: null,
    test_ids: null,
    types: {},
    
    tests:[],
    formattedTests: [],
    patient:{}
  }),

  computed: {
    length: function() {
      return Math.ceil(this.pagination.total / this.pagination.visible);
    },
    
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
        this.query = "page=" + this.pagination.page;
               
        // if (this.search != "") {
        //     this.query = this.query + "&search=" + this.search;
        // }
        apiCall({url:this.url_prefix+"results/patient?id="+this.$route.params.id, method:"GET"})
        .then(resp=>{
            let patient = resp
            console.log("Patient request response is, ",resp)
            // resp.data.forEach(element => {
            //     categories.push({'text':element.name, 'value':element.id})
            // });
            Vue.set(this, 'patient', patient)
        })
        .catch(error => {
            console.log(error.response)
        })
    },
    getPDF(){
        apiCall({url:this.url_prefix+"results/patient?pdf=true&id="+this.$route.params.id, method:"GET", data:'PDF'})
        .then(resp=>{
            // console.log(resp)           
        })
        .catch(error => {
            console.log(error.response)
        })
        
    }
  }
};
</script>