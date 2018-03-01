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
        factory(App\Models\User::class, 100)->create();
// todo: this User class is tobe removed and replaced with the above
        // factory(App\User::class)->create(['email' => 'admin@blis.local']);

        //Patients table
        factory(App\Models\Patient::class, 100)->create();
    }
}
