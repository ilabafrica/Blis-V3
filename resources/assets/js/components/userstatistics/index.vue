<template>
    <div>
        <v-layout>
            

        </v-layout>
        <v-layout>
            <v-flex sm6>
                <canvas id="myChart" width="400" height="400"></canvas>
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
    date_counts: {},
    gender_counts : {'1':{}, '2':{}, '3':{},'4':{}}
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

        // apiCall({ url: "/api/tests-verified?" + this.query, method: "GET" })
        // .then(resp => {
        //     console.log(resp);

        //     this.tests = resp;
        //     var ctx = document.getElementById("myChart");
            
        //     console.log("data is",resp)
        //     let totals = this.tests.map(x=> x.total)
        //     let dates = this.tests.map(x=> x.timing)

        //     console.log(dates)
        //     console.log(totals)
        //     var ctx2 = document.getElementById("myChart2");
        //     var myLineChart = new Chart(ctx2, {
        //         type: 'line',
        //         data: {
        //             labels: dates,
        //             datasets:[
        //                 {
        //                     label: "Counts",
        //                     data: totals
        //                 }
        //             ]
        //         }
        //     });
        //     //this.pagination.total = resp.total;
        // })
        // .catch(error => {
        //     console.log(error.response);
        // });

        apiCall({url:"/api/tests-done/full?"+this.query, method:"GET"})
        .then(resp=>{
            console.log(resp)            
            let uniqueDates = resp.map(x=> x.test_started_at).filter((v, i, a) => a.indexOf(v) === i)
            console.log(uniqueDates)
            // let gender_counts = {'1':0, '2':0, '3':0,'4':0}
            let gender_counts = {'1':{}, '2':{}, '3':{},'4':{}}
            let date_counts = {}
            let status_counts = {}
            resp.map(x =>{
                // For each iteration check if a gender index has been instanitated matching the current gender id and add 1 to it else assign the new gender count index a value of 1 
                // gender_counts[x.gender_id] = gender_counts[x.gender_id] ? gender_counts[x.gender_id] + 1 : 1;
                gender_counts[x.gender_id].total = gender_counts[x.gender_id].total ? gender_counts[x.gender_id].total + 1 : 1;
                gender_counts[x.gender_id][x.test_status_id]  = gender_counts[x.gender_id][x.test_status_id] ? gender_counts[x.gender_id][x.test_status_id] + 1 : 1                

                date_counts[x.test_started_at] = date_counts[x.test_started_at] ? date_counts[x.test_started_at] + 1 : 1 
                status_counts[x.test_status_id] = status_counts[x.test_status_id] ? status_counts[x.test_status_id] + 1 : 1 
            })
            console.log("Gender Counts are" ,gender_counts)
            console.log("Date Counts are",date_counts)
            console.log("Status Counts are",status_counts)
            this.gender_counts = gender_counts
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

    getAge(birthday) {
      return ~~((Date.now() - Date.parse(birthday)) / 31557600000);
    }
  }
};
</script>