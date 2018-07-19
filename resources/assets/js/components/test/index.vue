<template>
  <div>
    <v-card-title>
      Tests
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Search"
        single-line
        v-on:keyup.enter="initialize"
        hide-details>
      </v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="tests"
      hide-actions
      class="elevation-1">
      <template slot="items" slot-scope="props">
        <td>{{ props.item.created_at }}</td>
        <td class="text-xs-right">
          <div v-if="props.item.encounter.patient.name">
            {{ props.item.encounter.patient.name.text }}
          </div>
            ({{ getGender(props.item.encounter.patient.gender.code) }},
            {{ getAge(props.item.encounter.patient.birth_date) }})
        </td>
        <td class="text-xs-right">
          <div v-if="props.item.specimen">
            {{ props.item.specimen.specimen_type.name }}
          </div>
        </td>
        <td class="text-xs-right">{{ props.item.test_type.name }}</td>
        <td class="text-xs-right">{{ props.item.encounter.identifier }}</td>
        <td class="text-xs-right">{{ props.item.test_status.name }}</td>
        <td class="justify-center layout px-0">

<!-- 
Details(Verify)
Start
Enter Results
Edit Results
Reject
Refer
Verify(Details)








 -->





<div class="text-xs-center d-flex align-center">
          <v-tooltip @click="detail(props.item)" top>
            <v-icon slot="activator" color="green">eye</v-icon>
            <span>Details</span>
          </v-tooltip>
          <v-tooltip @click="detail(props.item)" top>
            <v-icon slot="activator" color="deep-purple">test-tube-empty</v-icon>
            <span>Collect Specimen</span>
          </v-tooltip>
          <v-tooltip @click="edit(props.item)" top>
            <v-icon slot="activator" color="blue">play-circle-outline</v-icon>
            <span>Start</span>
          </v-tooltip>
          <v-tooltip @click="edit(props.item)" top>
            <v-icon slot="activator" color="light-blue">subtitle-outline</v-icon>
            <span>Enter Results</span>
          </v-tooltip>
          <v-tooltip @click="edit(props.item)" top>
            <v-icon slot="activator" color="teal">edit</v-icon>
            <span>Edit</span>
          </v-tooltip>
          <v-tooltip @click="reject(props.item)" top>
            <v-icon slot="activator" color="red">close-box-outline</v-icon>
            <span>Reject</span>
          </v-tooltip>
          <v-tooltip @click="refer(props.item)" top>
            <v-icon slot="activator" color="amber">subdirectory-arrow-right</v-icon>
            <span>Refer</span>
          </v-tooltip>
          <v-tooltip @click="verify(props.item)" top>
            <v-icon slot="activator" color="pink">check-all</v-icon>
            <span>Verify</span>
          </v-tooltip>
</div>
        </td>
      </template>
    </v-data-table>
    <div class="text-xs-center">
      <v-pagination
        :length="length"
        :total-visible="pagination.visible"
        v-model="pagination.page"
        @input="initialize"
        circle>
      </v-pagination>
    </div>
  </div>
</template>
<script>
  import apiCall from '../../utils/api'
  export default {
    data: () => ({
      search: '',
      query: '',
      pagination: {
        page: 1,
        per_page: 0,
        total: 0,
        visible: 10
      },
      headers: [
        { text: 'Time Ordered', value: 'created_at' },
        { text: 'Patient', value: 'patient' },
        { text: 'Specimen ID', value: 'specimen_id' },
        { text: 'Test', value: 'test_type' },
        { text: 'Visit', value: 'encounter' },
        { text: 'Status', value: 'test_status' },
        { text: 'Actions', value: 'actions', sortable: false }
      ],
      tests: []
    }),

    computed: {

      length: function() {
        return Math.ceil(this.pagination.total / this.pagination.visible);
      },
    },

    created () {
      this.initialize()
    },

    methods: {

      initialize () {

        this.query = 'page='+ this.pagination.page;
        if (this.search != '') {
            this.query = this.query+'&search='+this.search;
        }

        apiCall({url: '/api/test?' + this.query, method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.tests = resp.data;
          this.pagination.total = resp.total;
        })
        .catch(error => {
          console.log(error.response)
        })
      },

      getAge (birthday) {
          return ~~((Date.now() - Date.parse(birthday)) / (31557600000));
      },

      getGender (code) {
        if (code == 'male') {

          return 'M';
        }else if (code == 'female') {

          return 'F';
        }else{

          return '';
        }

          return ~~((Date.now() - Date.parse(birthday)) / (31557600000));
      }
    }
  }
</script>