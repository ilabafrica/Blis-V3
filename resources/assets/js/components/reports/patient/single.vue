<template>
    <div>
        <v-layout row wrap>
            <p class="flex xs12 md9" style="font-size:2rem; font-weight:100">Patient Report</p>
            <v-btn @click.native="getPDF()">Get PDF</v-btn>
        </v-layout>
        <v-layout row wrap ma-4 v-if="patient.name">
            <v-flex md-4>
                Patient Name: {{patient.name.family}}, {{patient.name.given}}
            </v-flex>
            <v-flex md-4>
                Gender: {{patient.gender.display}}
            </v-flex>
            <v-flex md-4>
                Age: {{patient.birth_date}}
            </v-flex>
        </v-layout>
        <v-layout row white wrap ma-4 pt-2 v-if="patient.tests" v-for="test in patient.tests" :key="test.id">
            <v-flex md6 title pa-2>Test Num: {{test.id}}</v-flex>
            <v-flex md6 title pa-2>Test Ordered: {{test.created_at}}</v-flex>
            <v-flex md12 white>
                <table class="table text-md-right" v-if="test.specimen.id">
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
                <table class="table text-md-right" md12 v-if="test.results">
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
        apiCall({url:this.url_prefix+"results/patient?pdf=true&id="+this.$route.params.id, method:"GET"})
        .then(resp=>{
            // console.log(resp)
            // let bl = resp.substring(resp.lastIndexOf('.pdf"')+5)
            // window.open("data:application/pdf;base64," + resp.substring(resp.lastIndexOf('.pdf"')+5));
            // const file = new Blob([resp], {type: 'application/pdf'});
            // //build a url from the file
            // const fileURL = URL.createObjectURL(file);
            // //open the url on new window
            // window.open(fileURL);
        })
        .catch(error => {
            console.log(error.response)
        })
        
    }
  }
};
</script>