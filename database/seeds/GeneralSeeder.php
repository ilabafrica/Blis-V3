<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Patient;
use App\Models\MeasureType;
use App\Models\TestPhase;
use App\Models\TestStatus;
use App\Models\SpecimenStatus;
use App\Models\Permission;
use App\Models\Role;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User table
        factory(App\User::class)->create([
            'username' => 'admin@blis.local',
            'email' => 'admin@blis.local',
            'password' =>  bcrypt('password'),
        ]);
        factory(App\User::class, 20)->create();
        factory(App\Models\Location::class, 100)->create();

        //Patients table
        factory(App\Models\Patient::class, 20)->create();


        $this->command->info('users seeded');

        /* Measure Types */
        $measureTypes = [
            ["id" => "1", "name" => "Numeric"],
            ["id" => "2", "name" => "Alphanumeric"],
            ["id" => "3", "name" => "Multi Alphanumeric"],
            ["id" => "4", "name" => "Free Text"],
        ];

        foreach ($measureTypes as $measureType)
        {
            MeasureType::create($measureType);
        }
        $this->command->info('measure_types seeded');

        /* Test Phase table */
        $test_phases = [
          ["id" => "1", "name" => "Pre-Analytical"],
          ["id" => "2", "name" => "Analytical"],
          ["id" => "3", "name" => "Post-Analytical"],
        ];
        foreach ($test_phases as $test_phase)
        {
            TestPhase::create($test_phase);
        }
        $this->command->info('test_phases seeded');

        /* Test Status table */
        $test_statuses = [
          ["id" => "1","name" => "not-received","test_phase_id" => "1"],//Pre-Analytical
          ["id" => "2","name" => "pending","test_phase_id" => "1"],//Pre-Analytical
          ["id" => "3","name" => "started","test_phase_id" => "2"],//Analytical
          ["id" => "4","name" => "completed","test_phase_id" => "3"],//Post-Analytical
          ["id" => "5","name" => "verified","test_phase_id" => "3"],//Post-Analytical
        ];
        foreach ($test_statuses as $test_status)
        {
            TestStatus::create($test_status);
        }
        $this->command->info('test_statuses seeded');

        /* Specimen Status table */
        $specimen_statuses = [
          ["id" => "1", "name" => "specimen-not-collected"],
          ["id" => "2", "name" => "specimen-accepted"],
          ["id" => "3", "name" => "specimen-rejected"],
        ];
        foreach ($specimen_statuses as $specimen_status)
        {
            SpecimenStatus::create($specimen_status);
        }
        $this->command->info('specimen_statuses seeded');

        /* Permissions table */
        $permissions = [
            // system configurations
            ["name" => "manage_configurations", "display_name" => "Can manage configurations"],

            // manage test menu
            ["name" => "manage_test_catalog", "display_name" => "Can manage test catalog"],

            // user management
            ["name" => "manage_users", "display_name" => "Can manage users"],

            // patient data management
            ["name" => "manage_patients", "display_name" => "Can add patients"],
            ["name" => "view_patient_names", "display_name" => "Can view patient names"],

            // routine and reference testing
            ["name" => "request_test", "display_name" => "Can request new test"],// includes external systems
            ["name" => "accept_test_specimen", "display_name" => "Can accept test specimen"],
            ["name" => "reject_test_specimen", "display_name" => "Can reject test specimen"],
            ["name" => "change_test_specimen", "display_name" => "Can change test specimen"],
            ["name" => "start_test", "display_name" => "Can start tests"],
            ["name" => "enter_test_results", "display_name" => "Can enter tests results"],
            ["name" => "edit_test_results", "display_name" => "Can edit test results"],
            ["name" => "verify_test_results", "display_name" => "Can verify test results"],
            ["name" => "refer_test_specimens", "display_name" => "Can refer specimens"],
            ["name" => "manage_quality_control", "display_name" => "Can manage Quality Control"],

            // reporting
            ["name" => "view_reports", "display_name" => "Can view reports"],

            // inventory and equipment
            ["name" => "manage_inventory", "display_name" => "Can manage inventory"],
            ["name" => "request_topup", "display_name" => "Can request top-up"],
            ["name" => "manage_equipment", "display_name" => "Can manage equipment"],

            // biosafty and biosecurity
            ["name" => "manage_biosafty_biosecurity", "display_name" => "Can manage biosafty-biosecurity"],

            // biosafty and biosecurity
            ["name" => "manage_blood_bank", "display_name" => "Can manage blood bank"],
            ["name" => "view_blood_bank", "display_name" => "Can view blood bank"],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        $this->command->info('Permissions table seeded');

        /* Roles table */
        $roles = [
            ["name" => "Superadmin"],
            ["name" => "Technologist"],
            ["name" => "Receptionist"],
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }
        $this->command->info('Roles table seeded');

        $superUser = User::find(1);
        $superAdmin = Role::find(1);
        $permissions = Permission::all();

        //Assign all permissions to role Superadmin
        foreach ($permissions as $permission) {
            $superAdmin->attachPermission($permission);
        }
        //Assign role Superadmin to user_id=1
        $superUser->attachRole($superAdmin);
    }
}
