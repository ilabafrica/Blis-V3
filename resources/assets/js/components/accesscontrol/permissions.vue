<template>
  <div>
    <v-card-title>
      Permissions
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
      :items="permissions"
      hide-actions
      class="elevation-1">

      <template slot="items" slot-scope="row">
        <tr :key="row.item.id">
          <td>{{row.item.display_name}}</td>
          <td
            v-for="role in roles"
            :key="role.id">
              <v-checkbox
                v-model="permissionRoleIds"
                :value="getAssignment(row.item,role)"
                v-on:click="toggleAssignment(row.item,role)">
              </v-checkbox>
            </td>
          </tr>
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
      search: '',
      query: '',
      headers: [
        { text: 'Permissions', value: 'permissions' },
      ],
      pagination: {
        page: 1,
        per_page: 0,
        total: 0,
        visible: 10
      },
      permissionsroles: [],
      permissionRoleIds: [],
      permissions: [],
      roles: [],
    }),

    computed: {

      length: function() {
        return Math.ceil(this.pagination.total / this.pagination.per_page);
      },
    },

    beforeCreate() {
      apiCall({url: '/api/role', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.roles = resp;
          for (var i = 0; i < resp.length; i++) {
            this.headers.push({
              text: resp[i].name,
              value: resp[i].name
            })
          }
        })
        .catch(error => {
          console.log(error.response)
        })

        apiCall({url: '/api/permissionrole', method: 'GET' })
        .then(resp => {
          console.log(resp)
          this.permissionsroles = resp;
          this.permissionRoleIds = _.map(this.permissionsroles, 'id');
        })
        .catch(error => {
          console.log(error.response)
        })
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

        apiCall({url: '/api/permission?' + this.query, method: 'GET' })
        .then(resp => {
          console.log(resp.data)
          this.permissions = resp.data;
          this.pagination.total = resp.total;
          this.pagination.per_page = resp.per_page;
        })
        .catch(error => {
          console.log(error.response)
        })
      },

      getAssignment (permission, role) {
          var value = 0;
          for (var i = this.permissionsroles.length - 1; i >= 0; i--) {
            if (permission.id == this.permissionsroles[i].permission_id &&
              role.id == this.permissionsroles[i].role_id) {

              value = this.permissionsroles[i].id;
              break;
            }else{
              value = permission.id+'_'+role.id;
            }
          }
          return value;
      },

      toggleAssignment (permission,role) {

        this.query = 'permission_id='+ permission.id+'&&role_id='+ role.id;

        var permissionRoleId = this.getAssignment(permission, role);
        // if attached
        if (_.includes(this.permissionRoleIds, permissionRoleId)) {

          console.log('dettach permission-role')
          // detach
          apiCall({
            url: '/api/permissionrole/detach?'+this.query,
            method: 'GET'
          })
          .then(response => {
            console.log(response)
            _.remove(this.permissionRoleIds, item => item === permissionRoleId);
          })
          .catch(error => {
            console.log(error.response)
          })
        } else {

          console.log('attach permission-role')
          // attach
          apiCall({
            url: '/api/permissionrole/attach?'+this.query,
            method: 'GET'
          })
          .then(response => {
            console.log(response)
            this.permissionRoleIds.push(response.id);
          })
          .catch(error => {
            console.log(error.response)
          })

        }
      },

    }
  }
</script>