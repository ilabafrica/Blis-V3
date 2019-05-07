<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThirdpartyAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * @grant_type password|implicit|client_credentials|authorization_code
         */
        Schema::create('third_party_access', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->nullable();
            $table->uuid('third_party_app_id')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('grant_type')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_id')->nullable();
            $table->string('client_secret')->nullable();
            $table->string('login_url')->nullable();
            $table->string('result_url')->nullable();
            $table->string('access_token', 1200)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('third_party_access');
    }
}
