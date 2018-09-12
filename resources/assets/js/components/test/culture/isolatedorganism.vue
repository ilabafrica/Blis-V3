<template>
  <div>
    <organism ref="organismForm"></organism>
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
      :headers="headers"
      :items="results"
      hide-actions
      class="elevation-1">
      <template slot="items" slot-scope="props">
        <td>{{ props.item.measure_range.display }}</td>
        <td class="justify-left layout px-0">
          <v-btn
            outline
            small
            title="Susceptibility"
            color="green"
            flat
            :to="{name:'TestCultureSusceptibility', params:{testId:props.item.test_id,resultId:props.item.id,measureId:props.item.measure_id,measureRangeId:props.item.measure_range_id}}"
            >
            Susceptibility
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
  </div>
</template>
<script>
  import { EventBus } from './../../../app.js';
  import apiCall from '../../../utils/api'
  import organism from './organism'

  export default {
    components: {
      organism,
    },
    data: () => ({
      search: '',
      query: '',
      headers: [
        { text: 'Organism', value: 'organism' },
        { text: 'Actions', value: 'actions', sortable: false }
      ],
      results: []
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
      // Listen for the update-isolated-organism-list event and its payload.
      EventBus.$on('update-isolated-organism-list', data => {
        console.log('update-isolated-organism-list')
        Object.assign(this.results[this.editedIndex], data)
      });
    },

    methods: {

      initialize () {

        apiCall({
          url: '/api/result?measure_id=' + this.$route.params.measureId+'&&test_id=' + this.$route.params.testId,
          method: 'GET' 
        }).then(resp => {
          console.log(resp)
          this.results = resp;
        })
        .catch(error => {
          console.log(error.response)
        })

      },

      organism () {
        this.$refs.organismForm.modal(this.$route.params.measureId,this.$route.params.testId);
      },
    }
  }
</script>