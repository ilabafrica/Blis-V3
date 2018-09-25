<template>
  <div>
    <v-card-title>
      {{testType.name}}
    </v-card-title>
    <v-data-table
      :items="specimenTypes"
      hide-actions>
      <template slot="items" slot-scope="row">
        <tr :key="row.item.id">
          <td>{{row.item.name}}</td>
          <td>
            <v-checkbox
              v-model="specimenTypeIds"
              :value="row.item.id"
              v-on:click="toggleSpecimenAssignment(row.item)">
            </v-checkbox>
          </td>
        </tr>
      </template>
    </v-data-table>
  </div>
</template>
<script>
  import apiCall from '../../../utils/api'

  export default {
    data: () => ({
      testType: {},
      specimenTypes: [],
      search: '',
      query: '',
    }),

    created () {
      this.initialize()
    },

    methods: {

      initialize () {
      // get earger loaded test type

      apiCall({url: '/api/testtype/'+parseInt(this.$route.params.testTypeId), method: 'GET' })
        .then(resp => {
          console.log('Test Type')
          console.log(resp)
          this.testType = resp;

          this.measures = resp.measures;
          this.specimenTypeIds = _.map(resp.specimen_types, 'id');
          console.log('Specimen Type Ids')
          console.log(this.specimenTypeIds)

        })
        .catch(error => {
          console.log(error.response)

      })

        apiCall({url: '/api/specimentype', method: 'GET' })
          .then(resp => {
            console.log(resp)
            this.specimenTypes = resp.data;
          })
          .catch(error => {
            console.log(error.response)
        })

        apiCall({url: '/api/specimentype', method: 'GET' })
          .then(resp => {
            console.log(resp)
            this.specimenTypes = resp.data;
          })
          .catch(error => {
            console.log(error.response)
        })

      },

      updateTestType () {

        apiCall({url: '/api/testtype/'+parseInt(this.testType.id), method: 'GET' })
          .then(resp => {
            console.log('Test Type')
            console.log(resp)
            this.testType = resp;

            this.measures = resp.measures;
            this.specimenTypeIds = _.map(resp.specimen_types, 'id');
            console.log('Specimen Type Ids')
            console.log(this.specimenTypeIds)
          })
          .catch(error => {
            console.log(error.response)
        })
      },

      toggleSpecimenAssignment (specimenType) {

        this.query = 'specimen_type_id='+ specimenType.id+'&&test_type_id='+ this.testType.id;

        // if attached
        if (_.includes(this.specimenTypeIds, specimenType.id)) {

          console.log('dettach specimen_type-test-type')
          // detach
          apiCall({
            url: '/api/specimentypetesttype/detach?'+this.query,
            method: 'GET'
          })
          .then(resp => {
            console.log(resp)
            this.updateTestType();
          })
          .catch(error => {
            console.log(error.response)
          })
        } else {

          console.log('attach specimen_type-test-type')
          // attach
          apiCall({
            url: '/api/specimentypetesttype/attach?'+this.query,
            method: 'GET'
          })
          .then(resp => {
            console.log(resp)
            this.updateTestType();
          })
          .catch(error => {
            console.log(error.response)
          })
        }
      },
    }
  }
</script>