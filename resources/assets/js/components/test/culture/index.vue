<template>
  <div>
    <organism ref="organismForm"></organism>
    <antibiotic ref="antibioticForm"></antibiotic>
    <v-card-title>
      Culture and Sensitvity
      <v-spacer></v-spacer>
      <v-btn
        outline
        small
        title="Add Isolated Organism"
        color="red"
        flat
        @click="organism()">
        Add Isolated Organism
        <v-icon right dark>bug_report</v-icon>
      </v-btn>
    </v-card-title>

    <v-data-table
      :headers="organismHeaders"
      :items="tests"
      hide-actions
      class="elevation-1">
      <template slot="items" slot-scope="props">
        <td>{{ props.item.created_at }}</td>
        <td class="justify-left layout px-0">
          <v-btn
            outline
            small
            title="Add Antibiotic"
            color="green"
            flat
            @click="antibiotic(props.item)">
            Add Antibiotic
            <v-icon right dark>format_color_fill</v-icon>
          </v-btn>
          <v-btn
            outline
            small
            title="Delete"
            color="pink"
            flat
            @click="delete(props.item)">
            Delete Organism
            <v-icon right dark>delete</v-icon>
          </v-btn>
        </td>
      </template>
    </v-data-table>
<!-- 
organism
antibiotic
zone_diameter
result
 -->    
    <v-data-table
      :headers="headers"
      :items="tests"
      hide-actions
      class="elevation-1">
      <template slot="items" slot-scope="props">
        <td class="text-xs-left">{{ props.item.test_type.name }}</td>
        <td class="text-xs-right">{{ props.item.test_type.name }}</td>
        <td class="text-xs-right">{{ props.item.encounter.identifier }}</td>
        <td class="text-xs-right">{{ props.item.test_status.name }}</td>
        <td class="justify-left layout px-0">
          <v-btn
            outline
            small
            title="Edit"
            color="teal"
            flat
            @click="antibiotic(props.item)">
            Edit
            <v-icon right dark>edit</v-icon>
          </v-btn>
          <v-btn
            outline
            small
            title="Delete"
            color="pink"
            flat
            @click="delete(props.item)">
            Delete
            <v-icon right dark>delete</v-icon>
          </v-btn>
        </td>
      </template>
    </v-data-table>
  </div>
</template>
<script>
  import { EventBus } from './../../../app.js';
  import apiCall from '../../../utils/api'
  import organism from './organism'
  import antibiotic from './antibiotic'

  export default {
    components: {
      organism,
      antibiotic,
    },
    data: () => ({
      search: '',
      query: '',
      organismHeaders: [
        { text: 'Organism', value: 'organism' },
        { text: 'Actions', value: 'actions', sortable: false }
      ],
      headers: [
        { text: 'Organism', value: 'organism' },
        { text: 'Antibiotic', value: 'antibiotic' },
        { text: 'Zone Diameter', value: 'zone_diameter' },
        { text: 'Result', value: 'result' },
        { text: 'Actions', value: 'actions', sortable: false }
      ],
      tests: []
    }),

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

        apiCall({url: '/api/organism/' + this.query, method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.tests = resp.data;
        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/api/test/' + this.query, method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.tests = resp.data;
        })
        .catch(error => {
          console.log(error.response)
        })
      },

      organism (test) {
        this.$refs.organismForm.modal(test);
      },

      antibiotic (test) {
        this.$refs.antibioticForm.modal(test);
      },

    }
  }
</script>