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
      <v-list-tile v-for="(lab_configuration, i) in lab_configurations" :key="i" @click="">
        <v-list-tile-action>
          <v-icon v-text="lab_configuration.icon"></v-icon>
        </v-list-tile-action>
        <v-list-tile-title v-text="lab_configuration.label"></v-list-tile-title>
      </v-list-tile>
    </v-list-group>
    <v-list-group prepend-icon="account_circle" value="true">
      <v-list-tile slot="activator">
        <v-list-tile-title>Test Catalog</v-list-tile-title>
      </v-list-tile>
      <v-list-tile v-for="(test_catalog, i) in test_catalogs" :key="i" @click="">
        <v-list-tile-action>
          <v-icon v-text="test_catalog.icon"></v-icon>
        </v-list-tile-action>
        <v-list-tile-title v-text="test_catalog.label"></v-list-tile-title>
      </v-list-tile>
    </v-list-group>
    <v-list-group prepend-icon="account_circle" value="true">
      <v-list-tile slot="activator">
        <v-list-tile-title>Access Control</v-list-tile-title>
      </v-list-tile>
      <v-list-tile v-for="(access_control, i) in access_controls" :key="i" @click="">
        <v-list-tile-action>
          <v-icon v-text="access_control.icon"></v-icon>
        </v-list-tile-action>
        <v-list-tile-title v-text="access_control.label"></v-list-tile-title>
      </v-list-tile>
    </v-list-group>
    <v-list-group prepend-icon="account_circle" value="true">
      <v-list-tile slot="activator">
        <v-list-tile-title>Tests</v-list-tile-title>
      </v-list-tile>
      <v-list-tile v-for="(test, i) in tests" :key="i" @click="">
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
          path: '/',
          label: 'Health Units',
          icon: 'settings'
        },
        {
          path: '/',
          label: 'Barcode Settings',
          icon: 'settings'
        },
        {
          path: '/',
          label: 'Interfaced Equipment',
          icon: 'settings'
        },
      ],
      test_catalogs: [
        {
          path: '/',
          label: 'Lab Sections',
          icon: 'settings'
        },
        {
          path: '/',
          label: 'Specimen Types',
          icon: 'settings'
        },
        {
          path: '/',
          label: 'Specimen Rejection',
          icon: 'settings'
        },
        {
          path: '/',
          label: 'Test Types',
          icon: 'settings'
        },
        {
          path: '/',
          label: 'Drugs',
          icon: 'settings'
        },
        {
          path: '/',
          label: 'Organisms',
          icon: 'settings'
        },
      ],
      access_controls: [
        {
          path: '/',
          label: 'User Accounts',
          icon: 'settings'
        },
        {
          path: '/',
          label: 'Permission',
          icon: 'settings'
        },
        {
          path: '/',
          label: 'Role',
          icon: 'settings'
        },
        {
          path: '/',
          label: 'Assign Roles',
          icon: 'settings'
        },
      ],
      tests: [
        {
          path: '/',
          label: 'Completed Tests',
          icon: 'settings'
        },
        {
          path: '/',
          label: 'Samples Not Recieved',
          icon: 'settings'
        },
        {
          path: '/',
          label: 'Pending Tests',
          icon: 'settings'
        },
        {
          path: '/',
          label: 'Tests Started',
          icon: 'settings'
        },
        {
          path: '/',
          label: 'Verified Tests',
          icon: 'settings'
        },
      ]
    })
  }
</script>

<!-- 




 -->