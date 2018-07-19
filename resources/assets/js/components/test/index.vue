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
        <td class="justify-left layout px-0">
            <!-- Details(Verify) -->
              <v-btn
                outline
                small
                title="Details"
                color="green"
                @click="detail(props.item)">
                Details
              </v-btn>
              <v-btn
                outline
                small
                title="Collect"
                color="deep-purple"
                @click="collect(props.item)">
                Collect
              </v-btn>
              <v-btn
                outline
                small
                title="Start"
                color="blue"
                @click="start(props.item)">
                Start
              </v-btn>
              <v-btn
                outline
                small
                title="Enter"
                color="light-blue"
                @click="enter(props.item)">
                Enter
              </v-btn>
              <v-btn
                outline
                small
                title="Edit"
                color="teal"
                @click="edit(props.item)">
                Edit
              </v-btn>
              <v-btn
                outline
                small
                title="Reject"
                color="red"
                @click="reject(props.item)">
                Reject
              </v-btn>
              <v-btn
                outline
                small
                title="Refer"
                color="amber"
                @click="refer(props.item)">
                Refer
              </v-btn>
            <!-- Verify(Details) -->
              <v-btn
                outline
                small
                title="Verify"
                color="green"
                @click="verify(props.item)">
                Verify
              </v-btn>

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