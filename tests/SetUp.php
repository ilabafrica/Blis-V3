<?php

namespace Tests;

use GuzzleHttp\Client;
use Laravel\Passport\Passport;
use Illuminate\Contracts\Console\Kernel;

trait SetUp
{
    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function setup(){
        parent::Setup();
        \Artisan::call('db:seed');

        $this->setVariables();
        \Laravel\Passport\Passport::actingAs(\App\User::find(1),['create-servers']);
    }
}
