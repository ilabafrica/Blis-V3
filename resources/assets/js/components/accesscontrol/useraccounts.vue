<template>
  <div>
    <v-dialog v-model="dialog" max-width="500px">
      <v-btn slot="activator" color="primary" dark class="mb-2">New User</v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-form ref="form" v-model="valid" lazy-validation>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="editedItem.username"
                  :rules="[v = !!v || 'Username is Required']"
                  label="Username">    
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="editedItem.name"
                  :rules="[v => !!v || 'Name is Required']"
                  label="Name">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field
                  v-model="editedItem.email"
                  :rules="[v => !!v || 'Email is Required']"
                  label="Email Address">
                </v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
          <v-btn color="blue darken-1" :disabled="!valid" flat @click.native="save">Save</v-btn>
        </v-card-actions>
      </v-form>
      </v-card>
    </v-dialog>
  <v-data-table
    :headers="headers"
    :items="user"
    hide-actions
    class="elevation-1"
  >
    <template slot="items" slot-scope="props">
      <td>{{ props.item.username }}</td>
      <td class="text-xs-left">{{ props.item.name }}</td>
      <td class="text-xs-left">{{ props.item.email }}</td>
      <td class="justify-left layout px-0">
        <v-btn icon class="mx-0" @click="editItem(props.item)">
           <v-icon color="teal">edit</v-icon>
        </v-btn>
        <v-btn icon class="mx-0" @click="deleteItem(props.item)">
           <v-icon color="pink">delete</v-icon>
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
      valid: true,
      dialog: false,
      delete: false,
      pagination: {
        page: 1,
        per_page: 0,
        total: 0,
        visible: 10
      },
      headers: [
        { text: 'Username', align: 'left', value: 'username' },
        { text: 'Name', value: 'name' },
        { text: 'Email Address', value: 'email' },
        { text: 'Actions', sortable: false, value: 'action' }
      ],
      user: [],
      editedIndex: -1,
      editedItem: {
        username: '',
        name: '',
        email: ''
      },
      defaultItem: {
        username: '',
        name: '',
        email: ''
      }
    }),
    created () {
      this.initialize()
    },

    computed: {
      formTitle() {
        if(this.editedIndex === -1){
          this.resetDialogRefs();
          return 'New User'
        }else{
          return 'Edit User'
        }
      },
      length: function() {
        return Math.ceil(this.pagination.total / 10);
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    methods: {
      initialize () {
        apiCall({url: '/api/user?page=' + this.pagination.page, method: 'GET' })
        .then(resp => {
          console.log(resp.data)
          this.user = resp.data;
          this.pagination.total = resp.total;
        })
        .catch(error => {
          console.log(error.response)
        })
      },
      editItem (item) {
        this.editedIndex = this.user.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        confirm('Are you sure you want to delete this user?') && (this.delete = true)
        if (this.delete) {
          const index = this.user.indexOf(item)
          this.user.splice(index, 1)
          apiCall({url: '/api/user/'+item.id, method: 'DELETE' })
          .then(resp => {
            console.log(resp.data)
          })
          .catch(error => {
            console.log(error.response)
          })
        }

      },

      close () {
        this.dialog = false
      },

      resetDialogRefs() {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      },

      save () {
        // update
        if (this.editedIndex > -1) {
          apiCall({url: '/api/user/'+this.editedItem.id, data: this.editedItem, method: 'PUT' })
          .then(resp => {
            Object.assign(this.user[this.editedIndex], this.editedItem)
            console.log(resp)
            console.log('success')
            this.resetDialogRefs();
          })
          .catch(error => {
            console.log('fail')
            console.log(error.response)
          })

        // store
        } else {

          apiCall({url: '/api/user/', data: this.editedItem, method: 'POST' })
          .then(resp => {
            this.user.push(this.editedItem)
            console.log(resp)
            this.resetDialogRefs();
          })
          .catch(error => {
            console.log(error.response)
          })
        }
        this.close()
      }
    },
  }
</script>