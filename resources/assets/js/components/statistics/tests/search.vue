<template>
    <div>
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
            </v-container>
        </v-slide-y-transition>
        <v-layout row wrap>
            <v-flex>
                <v-btn @click.native="searching()" color="success">Search</v-btn>
            </v-flex>
            {{total_tests}}
        </v-layout>
        
    </div>
</template>

<script>
import apiCall from "../../../utils/api";
import Chart from "chart.js";
export default {
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
    users:[],
    user_id_filter: null,
    tested_by_filter:null,
    locations:[],
    location_id_filter: null,  
    categories:[],  
    category_id_filter: null,    
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
            Vue.set(this, 'toggle_filter_options', false)            
        })
        .catch(error => {
            console.log(error.response)
        })
    }
  }
};
</script>