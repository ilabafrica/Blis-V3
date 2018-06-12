<template>
  <div>
  <v-toolbar flat class="transparent">
    <v-list>
      <v-list-tile avatar>
        <v-list-tile-avatar>
          <img src="ILABLOGO1.jpg" >
        </v-list-tile-avatar>
        <v-list-tile-content>
          <v-list-tile-title>BLIS @iLabAfrica</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>
  </v-toolbar>
  <v-list dense>
    <v-list-tile>
      <v-list-tile-action>
        <v-icon>home</v-icon>
      </v-list-tile-action>
      <v-list-tile-title>Home</v-list-tile-title>
    </v-list-tile>
    <v-list-group prepend-icon="settings" value="true">
      <v-list-tile slot="activator">
        <v-list-tile-title>Lab Configuration</v-list-tile-title>
      </v-list-tile>
      <v-list-tile v-for="(lab_configuration, i) in lab_configurations" :key="i"
        :to="{path:lab_configuration.path}">
        <v-list-tile-action>
          <v-icon v-text="lab_configuration.icon"></v-icon>
        </v-list-tile-action>
        <v-list-tile-title v-text="lab_configuration.label"></v-list-tile-title>
      </v-list-tile>
    </v-list-group>
    <v-list-group prepend-icon="assignment" value="true">
      <v-list-tile slot="activator">
        <v-list-tile-title>Test Catalog</v-list-tile-title>
      </v-list-tile>
      <v-list-tile v-for="(test_catalog, i) in test_catalogs" :key="i"
        :to="{path:test_catalog.path}">
        <v-list-tile-action>
          <v-icon v-text="test_catalog.icon"></v-icon>
        </v-list-tile-action>
        <v-list-tile-title v-text="test_catalog.label"></v-list-tile-title>
      </v-list-tile>
    </v-list-group>
    <v-list-group prepend-icon="security" value="true">
      <v-list-tile slot="activator">
        <v-list-tile-title>Access Control</v-list-tile-title>
      </v-list-tile>
      <v-list-tile v-for="(access_control, i) in access_controls" :key="i"
        :to="{path:access_control.path}">
        <v-list-tile-action>
          <v-icon v-text="access_control.icon"></v-icon>
        </v-list-tile-action>
        <v-list-tile-title v-text="access_control.label"></v-list-tile-title>
      </v-list-tile>
    </v-list-group>
    <v-list-group prepend-icon="vertical_split" value="true">
      <v-list-tile slot="activator">
        <v-list-tile-title>Tests</v-list-tile-title>
      </v-list-tile>
      <v-list-tile v-for="(test, i) in tests" :key="i" :to="{path:test.path}">
        <v-list-tile-action>
          <v-icon v-text="test.icon"></v-icon>
        </v-list-tile-action>
        <v-list-tile-title v-text="test.label"></v-list-tile-title>
      </v-list-tile>
    </v-list-group>
  </v-list>
  </div>
</template>
<script>
  export default {
    data: () => ({
      lab_configurations: [
        {
          path: '/labconfiguration/healthunit',
          label: 'Health Units',
          icon: 'add_circle'
        },
        {
          path: '/',
          label: 'Barcode Settings',
          icon: 'build'
        },
        {
          path: '/',
          label: 'Interfaced Equipment',
          icon: 'devices'
        },
      ],
      test_catalogs: [
        {
          path: '/',
          label: 'Lab Sections',
          icon: 'dashboard'
        },
        {
          path: '/',
          label: 'Specimen Types',
          icon: 'assignment_turned_in'
        },
        {
          path: '/',
          label: 'Specimen Rejection',
          icon: 'assignment_late'
        },
        {
          path: '/',
          label: 'Test Types',
          icon: 'extension'
        },
        {
          path: '/',
          label: 'Drugs',
          icon: 'opacity'
        },
        {
          path: '/',
          label: 'Organisms',
          icon: 'bug_report'
        },
      ],
      access_controls: [
        {
          path: '/accesscontrol/useraccounts',
          label: 'User Accounts',
          icon: 'people'
        },
        {
          path: '/',
          label: 'Permission',
          icon: 'how_to_reg'
        },
        {
          path: '/',
          label: 'Role',
          icon: 'ballot'
        },
        {
          path: '/',
          label: 'Assign Roles',
          icon: 'verified_user'
        },
      ],
      tests: [
        {
          path: '/',
          label: 'Completed Tests',
          icon: 'done_all'
        },
        {
          path: '/',
          label: 'Samples Not Recieved',
          icon: 'report_problem'
        },
        {
          path: '/',
          label: 'Pending Tests',
          icon: 'hourglass_empty'
        },
        {
          path: '/',
          label: 'Tests Started',
          icon: 'sync'
        },
        {
          path: '/',
          label: 'Verified Tests',
          icon: 'check_box'
        },
      ]
    })
  }
</script>

