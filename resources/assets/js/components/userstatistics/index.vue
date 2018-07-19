<template>
    <v-layout>
        <v-flex sm6>
            <canvas id="myChart" width="400" height="400"></canvas>
        </v-flex>
        <v-flex sm6>
            <canvas id="myChart2" width="400" height="400"></canvas>
        </v-flex>
    </v-layout>
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
    tests: []
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

      apiCall({ url: "/api/tests-verified?" + this.query, method: "GET" })
        .then(resp => {
          console.log(resp);

          this.tests = resp;
          var ctx = document.getElementById("myChart");
          
          console.log("data is",resp)
          let totals = this.tests.map(x=> x.total)
          let dates = this.tests.map(x=> x.timing)

          console.log(dates)
          console.log(totals)
          var ctx2 = document.getElementById("myChart2");
          var myLineChart = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets:[
                        {
                            label: "Counts",
                            data: totals
                        }
                    ]
                }
            });
          //this.pagination.total = resp.total;
        })
        .catch(error => {
          console.log(error.response);
        });
    },

    getAge(birthday) {
      return ~~((Date.now() - Date.parse(birthday)) / 31557600000);
    }
  }
};
</script>