<?php

use Illuminate\Database\Seeder;

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
        factory(App\User::class)->create(['username' => 'admin@blis.local',
            'email' => 'admin@blis.local', ]);
        factory(App\User::class, 100)->create();

        //Patients table
        factory(App\Models\Patient::class, 100)->create();

        // todo: only for installation not, test seeding, slows seeding down
        // \Artisan::call('passport:install');
    }
}
