<template>
    <div>
        <specimencollection ref="specimenCollectionForm"></specimencollection>
        <result ref="resultForm"></result>
        <specimenrejection ref="specimenRejectionForm"></specimenrejection>
        <referral ref="referralForm"></referral>
        <testdetail ref="testDetailForm"></testdetail>
        <v-layout row wrap>
            <p class="flex xs11" style="font-size:2rem; font-weight:100">Test Search (<small class="grey--text">{{total_tests}} Tests Matched</small>)</p>            
            <v-btn icon @click="toggle_filter_options = !toggle_filter_options">
                <v-icon>{{ toggle_filter_options ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}</v-icon>
            </v-btn>
        </v-layout>
        <v-slide-y-transition>
            <v-container v-show="toggle_filter_options">
                <v-layout row wrap pl-4 pr-4 mt-4 style="border:1px solid #E3F2FD">
                    <v-flex xs12 style="margin-top:-20px">
                        <p class="blue lighten-5 pa-2">Created</p>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-menu
                            ref="picker_created_menu_after"
                            :close-on-content-click="false"
                            v-model="picker_created_menu_after"
                            :nudge-right="40"
                            :return-value.sync="picker.created.dates.after"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
                        >
                            <v-text-field
                            slot="activator"
                            v-model="picker.created.dates.after"
                            label="After Date"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="picker.created.dates.after" @input="$refs.picker_created_menu_after.save(picker.created.dates.after)"></v-date-picker>

                        </v-menu>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-menu
                            ref="picker_created_menu_before"
                            :close-on-content-click="false"
                            v-model="picker_created_menu_before"
                            :nudge-right="40"
                            :return-value.sync="picker.created.dates.before"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
                        >
                            <v-text-field
                            slot="activator"
                            v-model="picker.created.dates.before"
                            label="Before Date"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="picker.created.dates.before" @input="$refs.picker_created_menu_before.save(picker.created.dates.before)"></v-date-picker>

                        </v-menu>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-menu
                            ref="picker_created_menu_at"
                            :close-on-content-click="false"
                            v-model="picker_created_menu_at"
                            :nudge-right="40"
                            :return-value.sync="picker.created.dates.at"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
                        >
                            <v-text-field
                            slot="activator"
                            v-model="picker.created.dates.at"
                            label="At Date"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="picker.created.dates.at" @input="$refs.picker_created_menu_at.save(picker.created.dates.at)"></v-date-picker>

                        </v-menu>
                    </v-flex>
                </v-layout>                
                <v-layout row wrap pl-4 pr-4 mt-4 style="border:1px solid #E3F2FD">
                    <v-flex xs12 style="margin-top:-20px">
                        <p class="blue lighten-5 pa-2">Started</p>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-menu
                            ref="picker_started_menu_after"
                            :close-on-content-click="false"
                            v-model="picker_started_menu_after"
                            :nudge-right="40"
                            :return-value.sync="picker.started.dates.after"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
                        >
                            <v-text-field
                            slot="activator"
                            v-model="picker.started.dates.after"
                            label="After Date"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="picker.started.dates.after" @input="$refs.picker_started_menu_after.save(picker.started.dates.after)"></v-date-picker>

                        </v-menu>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-menu
                            ref="picker_started_menu_before"
                            :close-on-content-click="false"
                            v-model="picker_started_menu_before"
                            :nudge-right="40"
                            :return-value.sync="picker.started.dates.before"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
                        >
                            <v-text-field
                            slot="activator"
                            v-model="picker.started.dates.before"
                            label="Before Date"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="picker.started.dates.before" @input="$refs.picker_started_menu_before.save(picker.started.dates.before)"></v-date-picker>

                        </v-menu>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-menu
                            ref="picker_started_menu_at"
                            :close-on-content-click="false"
                            v-model="picker_started_menu_at"
                            :nudge-right="40"
                            :return-value.sync="picker.started.dates.at"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
                        >
                            <v-text-field
                            slot="activator"
                            v-model="picker.started.dates.at"
                            label="At Date"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="picker.started.dates.at" @input="$refs.picker_started_menu_at.save(picker.started.dates.at)"></v-date-picker>

                        </v-menu>
                    </v-flex>
                </v-layout>                
                <v-layout row wrap pl-4 pr-4 mt-4 style="border:1px solid #E3F2FD">
                    <v-flex xs12 style="margin-top:-20px">
                        <p class="blue lighten-5 pa-2">Completed</p>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-menu
                            ref="picker_completed_menu_after"
                            :close-on-content-click="false"
                            v-model="picker_completed_menu_after"
                            :nudge-right="40"
                            :return-value.sync="picker.completed.dates.after"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
                        >
                            <v-text-field
                            slot="activator"
                            v-model="picker.completed.dates.after"
                            label="After Date"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="picker.completed.dates.after" @input="$refs.picker_completed_menu_after.save(picker.completed.dates.after)"></v-date-picker>

                        </v-menu>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-menu
                            ref="picker_completed_menu_before"
                            :close-on-content-click="false"
                            v-model="picker_completed_menu_before"
                            :nudge-right="40"
                            :return-value.sync="picker.completed.dates.before"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
                        >
                            <v-text-field
                            slot="activator"
                            v-model="picker.completed.dates.before"
                            label="Before Date"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="picker.completed.dates.before" @input="$refs.picker_completed_menu_before.save(picker.completed.dates.before)"></v-date-picker>

                        </v-menu>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-menu
                            ref="picker_completed_menu_at"
                            :close-on-content-click="false"
                            v-model="picker_completed_menu_at"
                            :nudge-right="40"
                            :return-value.sync="picker.completed.dates.at"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
                        >
                            <v-text-field
                            slot="activator"
                            v-model="picker.completed.dates.at"
                            label="At Date"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="picker.completed.dates.at" @input="$refs.picker_completed_menu_at.save(picker.completed.dates.at)"></v-date-picker>

                        </v-menu>
                    </v-flex>
                </v-layout>                
                <v-layout row wrap>
                    <v-flex xs12 sm6 d-flex pa-4>
                        <v-select
                            :items="users"
                            label="Created By User"
                            outline v-model="user_id_filter"
                        ></v-select>
                    </v-flex>
                    <v-flex xs12 sm6 d-flex pa-4>
                        <v-select
                            :items="users"
                            label="Tested By User"
                            outline v-model="tested_by_filter"
                        ></v-select>
                    </v-flex>            
                    <v-flex xs12 sm6 d-flex pa-4>
                        <v-select
                            :items="locations"
                            label="By Location"
                            outline v-model="location_id_filter"
                        ></v-select>
                    </v-flex>
                    <v-flex xs12 sm6 d-flex pa-4>
                        <v-select
                            :items="categories"
                            label="By Category"
                            outline v-model="category_id_filter"
                        ></v-select>
                    </v-flex>
                </v-layout>
                <v-flex>
                    <v-btn @click.native="searching()" color="success">Search</v-btn>
                </v-flex>
            </v-container>
        </v-slide-y-transition>
        <v-layout row wrap>
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
                    @input="fetchTests"
                    circle>
                </v-pagination>
                </div>
        </v-layout>
    </div>
</template>

<script>
import apiCall from "../../../utils/api";
import Chart from "chart.js";
import specimencollection from '../../test/specimencollection'
import specimenrejection from '../../test/specimenrejection'
import testdetail from '../../test/testdetail'
import referral from '../../test/referral'
import result from '../../test/result'
export default {
    components: {
        specimencollection,
        result,
        specimenrejection,
        referral,
        testdetail,
    },
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
    headers: [
        { text: 'Time Ordered', value: 'created_at' },
        { text: 'Patient', value: 'patient' },
        { text: 'Specimen ID', value: 'specimen_id' },
        { text: 'Test', value: 'test_type' },
        { text: 'Visit', value: 'encounter' },
        { text: 'Status', value: 'test_status' },
        { text: 'Actions', value: 'actions', sortable: false }
      ],
    toggle_filter_options:true,
    picker:{
        started:{
            dates:{
                after: null,
                before: null,
                at: null,
            },
        },
        created:{
            dates:{
                after: null,
                before: null,
                at: null,
            },
        },
        completed:{
            dates:{
                after: null,
                before: null,
                at: null,
            }
        }
    },
    picker_created_menu_after:null,
    picker_created_menu_before:null,
    picker_created_menu_at:null,
    picker_started_menu_after:null,
    picker_started_menu_before:null,
    picker_started_menu_at:null,
    picker_completed_menu_after:null,
    picker_completed_menu_before:null,
    picker_completed_menu_at:null,
    total_tests: null,
    test_ids: null,
    users:[],
    user_id_filter: null,
    tested_by_filter:null,
    locations:[],
    location_id_filter: null,  
    categories:[],  
    category_id_filter: null,   
    
    tests:[],
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
               
        // if (this.search != "") {
        //     this.query = this.query + "&search=" + this.search;
        // }
        apiCall({url:this.url_prefix+"users", method:"GET"})
        .then(resp=>{
            let users = []
            console.log("User request response is, ",resp)
            resp.forEach(element => {
                users.push({'text':element.name, 'value':element.id})
            });
            Vue.set(this, 'users', users)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:"/api/location", method:"GET"})
        .then(resp=>{
            let locations = []
            console.log("Location request response is, ",resp)
            resp.data.forEach(element => {
                locations.push({'text':element.name, 'value':element.id})
            });
            Vue.set(this, 'locations', locations)
        })
        .catch(error => {
            console.log(error.response)
        })
        apiCall({url:"/api/testtypecategory", method:"GET"})
        .then(resp=>{
            let categories = []
            console.log("Categories request response is, ",resp)
            resp.data.forEach(element => {
                categories.push({'text':element.name, 'value':element.id})
            });
            Vue.set(this, 'categories', categories)
        })
        .catch(error => {
            console.log(error.response)
        })
    },
    searching(){
        let search_query = ""
        if (this.picker.created.dates.after) {
            search_query += "&created_after_date=" +this.picker.created.dates.after
        }
        if (this.picker.created.dates.before) {
            search_query += "&created_before_date=" +this.picker.created.dates.before
        }
        if (this.picker.created.dates.at) {
            search_query += "&created_at_date=" +this.picker.created.dates.at
        }
        if (this.picker.started.dates.after) {
            search_query += "&started_after_date=" +this.picker.started.dates.after
        }
        if (this.picker.started.dates.before) {
            search_query += "&started_before_date=" +this.picker.started.dates.before
        }
        if (this.picker.started.dates.at) {
            search_query += "&started_at_date=" +this.picker.started.dates.at
        }
        if (this.picker.completed.dates.after) {
            search_query += "&completed_after_date=" +this.picker.completed.dates.after
        }
        if (this.picker.completed.dates.before) {
            search_query += "&completed_before_date=" +this.picker.completed.dates.before
        }
        if (this.picker.completed.dates.at) {
            search_query += "&completed_at_date=" +this.picker.completed.dates.at
        }
        if (this.user_id_filter) {
            search_query += "&user_id=" +this.user_id_filter
        }
        if (this.tested_by_filter) {
            search_query += "&tested_by=" +this.tested_by_filter
        }
        if (this.location_id_filter) {
            search_query += "&location_id=" +this.location_id_filter
        }
        if (this.category_id_filter) {
            search_query += "&category_id=" +this.category_id_filter
        }
        apiCall({url:this.url_prefix+"tests/totals?"+search_query.substring(1)+"&with_ids=true", method:"GET"})
        .then(resp=>{
            let total = 0
            let ids = []
            resp.forEach(element => {
                total += element.total
                let array_of_ids = JSON.parse("[" + element.ids + "]") // convert the string element into an array
                ids = ids.concat(array_of_ids)  // merge the arrays

            });
            console.log("Ids are ", ids)
            Vue.set(this, 'total_tests', total)
            Vue.set(this, 'test_ids', ids)
            Vue.set(this, 'toggle_filter_options', false)               
            Vue.set(this, 'tests', [])               
            this.pagination.page = 1 //sets the value without refreshing the view
            this.fetchTests()
        })
        .catch(error => {
            console.log(error.response)
        })
    },
    fetchTests(){
        if(this.total_tests && this.test_ids && this.total_tests>0){ // make sure there actually is something to be fetched
            apiCall({url:this.url_prefix+"tests/fetch?test_ids="+this.test_ids.join()+"&page="+this.pagination.page, method:"GET"})
            .then(resp=>{
                console.log("Tests fetched request response is, ",resp)
                Vue.set(this, 'tests', resp.data)
                Vue.set(this.pagination, 'total', resp.total)
            })
            .catch(error => {
                console.log(error.response)
            })
        }
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
        this.editedIndex = this.tests.indexOf(test)
        this.$refs.resultForm.modal(test);
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
};
</script>