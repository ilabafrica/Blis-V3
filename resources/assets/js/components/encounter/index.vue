<template>
  <div>
    <specimencollection ref="specimenCollectionForm"></specimencollection>
    <encounterdetail ref="encounterDetailForm"></encounterdetail>
    <v-card-title>
      Visits
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
      :items="encounters"
      hide-actions
      class="elevation-1">
      <template slot="items" slot-scope="props">
        <td>{{ props.item.created_at }}</td>
        <td class="text-xs-right">
            {{ props.item.patient.identifier }}
        </td>
        <td class="text-xs-right">
            {{ props.item.patient.ulin }}
        </td>
        <td class="text-xs-right">
          <div v-if="props.item.patient.name">
            {{ props.item.patient.name.text }}
          </div>
            ({{ getGender(props.item.patient.gender.code) }},
            {{ getAge(props.item.patient.birth_date) }})
        </td>
        <td class="text-xs-right">{{ props.item.encounter_class }}</td>
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
                v-if="props.item.tests && $can('accept_test_specimen')"
                @click="collectSpecimen(props.item)">
                Collect
                <v-icon right dark>gradient</v-icon>
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
  import encounterdetail from './encounterdetail'

  export default {
    components: {
      specimencollection,
      encounterdetail,
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
        { text: 'Date', value: 'created_at' },
        { text: 'Patient Number', value: 'patient_number' },
        { text: 'Lab Number', value: 'ulin' },
        { text: 'Patient Name', value: 'patient_name' },
        { text: 'Visit Type', value: 'encounter_class' },
        { text: 'Actions', value: 'actions', sortable: false }
      ],
      encounters: []
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
      // Listen for the update-encounter-list event and its payload.
      EventBus.$on('update-encounter-list', data => {
        console.log('update-encounter-list')
        Object.assign(this.encounters[this.editedIndex], data)
      });
    },

    methods: {

      initialize () {

        this.query = 'page='+ this.pagination.page;
        if (this.search != '') {
            this.query = this.query+'&search='+this.search;
        }

        apiCall({url: '/api/encounter?' + this.query, method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.encounters = resp.data;
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

      collectSpecimen (encounter) {
        this.$refs.specimenCollectionForm.modal(encounter);
      },

      detail (encounter) {
        this.$refs.encounterDetailForm.modal(encounter);
      },
    }
  }
</script>