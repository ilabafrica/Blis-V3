<template>
  <div>
    <specimencollection ref="specimenCollectionForm"></specimencollection>
    <result ref="resultForm"></result>
    <specimenrejection ref="specimenRejectionForm"></specimenrejection>
    <referral ref="referralForm"></referral>
    <testdetail ref="testDetailForm"></testdetail>
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
              <v-btn
                outline
                small
                title="Details"
                color="green"
                flat
                @click="detail(props.item)">
                Details
                <v-icon right dark>visibility</v-icon>
              </v-btn>
              <v-btn
                outline
                small
                title="Collect Specimen"
                color="deep-purple"
                flat
                v-if="!props.item.specimen && $can('accept_test_specimen')"
                @click="collectSpecimen(props.item)">
                Collect
                <v-icon right dark>gradient</v-icon>
              </v-btn>
              <v-btn
                outline
                small
                title="Start"
                color="blue"
                flat
                v-if="props.item.test_status.code === 'pending' && $can('start_test')"
                @click="start(props.item)">
                Start
                <v-icon right dark>play_arrow</v-icon>
              </v-btn>
              <v-btn
                outline
                small
                title="Enter"
                color="light-blue"
                flat
                v-if="props.item.test_status.code === 'started' && $can('enter_test_result')"
                @click="enterResults(props.item)">
                Enter
                <v-icon right dark>library_books</v-icon>
              </v-btn>
              <v-btn
                outline
                small
                title="Edit"
                color="teal"
                flat
                v-if="props.item.test_status.code === 'completed' && $can('enter_test_result')"
                @click="enterResults(props.item)">
                Edit
                <v-icon right dark>edit</v-icon>
              </v-btn>
              <v-btn
                outline
                small
                title="Reject"
                color="red"
                flat
                v-if="props.item.test_status.test_phase.code === 'analytical' && $can('reject_test_specimen')"
                @click="rejectSpecimen(props.item)">
                Reject
                <v-icon right dark>block</v-icon>
              </v-btn>
              <v-btn
                outline
                small
                title="Refer"
                color="amber"
                flat
                v-if="props.item.specimen && $can('refer_test_specimen')"
                @click="refer(props.item)">
                Refer
                <v-icon right dark>arrow_forward</v-icon>
              </v-btn>
              <v-btn
                outline
                small
                title="Verify"
                color="green"
                flat
                v-if="props.item.test_status.code === 'completed' && $can('verify_test_result')"
                @click="detail(props.item)">
                Verify
                <v-icon right dark>check_circle_outline</v-icon>
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
  import { EventBus } from './../../app.js';
  import apiCall from '../../utils/api'
  import specimencollection from './specimencollection'
  import specimenrejection from './specimenrejection'
  import testdetail from './testdetail'
  import referral from './referral'
  import result from './result'

  export default {
    components: {
      specimencollection,
      result,
      specimenrejection,
      referral,
      testdetail,
    },
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

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    created () {
      this.initialize()
    },

    mounted() {
      // Listen for the update-test-list event and its payload.
      EventBus.$on('update-test-list', data => {
        console.log('update-test-list')
        Object.assign(this.tests[this.editedIndex], data)
      });
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
          this.pagination.per_page = resp.per_page;
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
      },

      collectSpecimen (test) {
        this.$refs.specimenCollectionForm.modal(test);
      },

      start (test) {

        apiCall({url: '/api/test/start/' + test.id, method: 'GET' })
        .then(resp => {
          console.log(resp)
          Object.assign(this.tests[this.editedIndex], resp)
        })
        .catch(error => {
          console.log(error.response)
        })

      },

      verify (test) {

        apiCall({url: '/api/test/verify/' + test.id, method: 'GET' })
        .then(resp => {
          console.log(resp)
          Object.assign(this.tests[this.editedIndex], resp)
        })
        .catch(error => {
          console.log(error.response)
        })
      },

      enterResults (test) {
        if (test.test_type.culture == 1) {
console.log(test)
console.log('This should happen')
          this.$router.push({name:'TestCulture',params:{id:test.id}})
        }else{
          this.$refs.resultForm.modal(test);
        }
      },

      rejectSpecimen (test) {
        this.$refs.specimenRejectionForm.modal(test);
      },

      refer (test) {
        this.$refs.referralForm.modal(test);
      },

      detail (test) {
        this.$refs.testDetailForm.modal(test);
      },
    }
  }
</script>