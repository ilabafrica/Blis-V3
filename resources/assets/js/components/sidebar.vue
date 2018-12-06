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
    <v-list-tile to="/">
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
    <v-list-group prepend-icon="settings" no-action>
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
    <v-list-group prepend-icon="assignment" no-action>
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
    <v-list-group prepend-icon="security" no-action>
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
    <v-list-tile to="/encounter/index">
      <v-list-tile-action>
        <v-icon>directions_walk</v-icon>
      </v-list-tile-action>
      <v-list-tile-title>
          Visits
      </v-list-tile-title>
    </v-list-tile>
    <v-list-tile to="/test/index">
      <v-list-tile-action>
        <v-icon>vertical_split</v-icon>
      </v-list-tile-action>
      <v-list-tile-title>
          Tests
      </v-list-tile-title>
    </v-list-tile>
    <v-list-group prepend-icon="sync_problem" no-action>
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
    <v-list-group prepend-icon="horizontal_split" no-action>
      <v-list-tile slot="activator">
        <v-list-tile-title>Inventory</v-list-tile-title>
      </v-list-tile>
      <v-list-tile v-for="(inventory, i) in inventory" :key="i" :to="{path:inventory.path}">
        <v-list-tile-action>
          <v-icon v-text="inventory.icon"></v-icon>
        </v-list-tile-action>
        <v-list-tile-title v-text="inventory.label"></v-list-tile-title>
      </v-list-tile>
    </v-list-group>
    <v-list-group prepend-icon="assessment" no-action>
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
    <v-list-group prepend-icon="dashboard" no-action>
      <v-list-tile slot="activator">
        <v-list-tile-title>Reports</v-list-tile-title>
      </v-list-tile>
      <v-list-tile v-for="(report, i) in reports" :key="i" :to="{path:report.path}">
        <v-list-tile-action>
          <v-icon v-text="report.icon"></v-icon>
        </v-list-tile-action>
        <v-list-tile-title v-text="report.label"></v-list-tile-title>
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
          path: '/labconfiguration/organization',
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
          path: '/testcatalog/specimenrejectionreason',
          label: 'Rejection Reason',
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
        }
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
      inventory: [
        {
          path: '/inventory/supplier',
          label: 'Suppliers',
          icon: 'folder'
        },
        {
          path: '/inventory/item',
          label: 'Items',
          icon: 'widgets'
        },
        {
          path: '/inventory/request',
          label: 'Requests',
          icon: 'launch'
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
          icon: 'dashboard'
        },
        {
          path: '/stats/tests/type',
          label: 'Test Type',
          icon: 'layers'
        },
        {
          path: '/stats/specimen',
          label: 'Specimen Stats',
          icon: 'assignment_turned_in'
        },
      ],
      reports: [
        {
          path: '/reports/infection',
          label: 'Infection Report',
          icon: 'assignment_turned_in'
        },
        {
          path: '/reports/patients',
          label: 'Patients',
          icon: 'people'
        },
      ]
    })
  }
</script>

