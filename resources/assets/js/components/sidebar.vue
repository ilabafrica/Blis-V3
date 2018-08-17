<template>
  <div>
  <v-toolbar flat class="transparent">
    <v-list>
      <v-list-tile avatar>
        <v-list-tile-avatar>
          <img src="ILABLOGO1.jpg" >
        </v-list-tile-avatar>
        <v-list-tile-content>
          <v-list-tile-title> @iLabAfrica</v-list-tile-title>
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
    <v-list-tile to="/patients/patient">
      <v-list-tile-action>
        <v-icon>assignment_ind</v-icon>
      </v-list-tile-action>
      <v-list-tile-title>Patients</v-list-tile-title>
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
    <v-list-tile to="/test/index">
      <v-list-tile-action>
        <v-icon>vertical_split</v-icon>
      </v-list-tile-action>
      <v-list-tile-title>
          Tests
      </v-list-tile-title>
    </v-list-tile>
    <v-list-group prepend-icon="sync_problem" value="true">
      <v-list-tile slot="activator">
        <v-list-tile-title>Quality Controls</v-list-tile-title>
      </v-list-tile>
      <v-list-tile v-for="(quality_control, i) in quality_control" :key="i" :to="{path:quality_control.path}">
        <v-list-tile-action>
          <v-icon v-text="quality_control.icon"></v-icon>
        </v-list-tile-action>
        <v-list-tile-title v-text="quality_control.label"></v-list-tile-title>
      </v-list-tile>
    </v-list-group>
    <v-list-group prepend-icon="dashboard" value="true">
      <v-list-tile slot="activator">
        <v-list-tile-title>Statistics</v-list-tile-title>
      </v-list-tile>
      <v-list-tile v-for="(stat, i) in stats" :key="i" :to="{path:stat.path}">
        <v-list-tile-action>
          <v-icon v-text="stat.icon"></v-icon>
        </v-list-tile-action>
        <v-list-tile-title v-text="stat.label"></v-list-tile-title>
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
          path: '/labconfiguration/facility',
          label: 'Facility',
          icon: 'domain'
        },
        {
          path: '/labconfiguration/interfacedequipment',
          label: 'Interfaced Equipment',
          icon: 'devices'
        },
      ],
      test_catalogs: [
        {
          path: '/testcatalog/testtypecategory',
          label: 'Lab Sections',
          icon: 'dashboard'
        },
        {
          path: '/testcatalog/specimentype',
          label: 'Specimen Types',
          icon: 'assignment_turned_in'
        },
        {
          path: '/',
          label: 'Specimen Rejection',
          icon: 'assignment_late'
        },
        {
          path: '/testcatalog/testtype',
          label: 'Test Types',
          icon: 'extension'
        },
        {
          path: '/testcatalog/antibiotic',
          label: 'Antibiotics',
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
          path: '/accesscontrol/permissions',
          label: 'Permissions',
          icon: 'how_to_reg'
        },
        {
          path: '/accesscontrol/role',
          label: 'Role',
          icon: 'ballot'
        },
        {
          path: '/accesscontrol/roleusers',
          label: 'Assign Roles',
          icon: 'verified_user'
        },
      ],
      quality_control: [
        {
          path: '/qualitycontrol/lot',
          label: 'Lots',
          icon: 'layers'
        },
        {
          path: '/qualitycontrol/controltest',
          label: 'Tests',
          icon: 'assessment'
        },
      ],
      stats: [
        {
          path: '/stats/users',
          label: 'User Stats',
          icon: 'people'
        },
        {
          path: '/stats/tests',
          label: 'Test Stats',
          icon: 'assessment'
        },
        {
          path: '/stats/specimen',
          label: 'Specimen Stats',
          icon: 'assignment_turned_in'
        },
      ]
    })
  }
</script>

