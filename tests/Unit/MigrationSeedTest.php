<?php
namespace Tests\Unit;
/**
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MigrationSeedTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		\Artisan::call('migrate');
		\Artisan::call('db:seed');
	}

	public function testJust()
	{
		$this->assertEquals(200,200);
	}

}