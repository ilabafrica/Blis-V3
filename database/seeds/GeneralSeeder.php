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

        //Patients table
        factory(App\Models\Patient::class, 100)->create();
    }
}
