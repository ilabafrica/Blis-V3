<?php
namespace Tests\Unit;
/**
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Tests\SetUp;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APIAuthTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->registrationData=array(
			"name"=>'Some Random Fellow',
			"email"=>'some@random.fellow',
			"password"=>'password',
		);

		$this->loginData=array(
			"username"=>'admin@blis.local',
			"password"=>'password',
		);
	}

	public function testRegister()
	{
		$response=$this->post('/api/register',$this->registrationData);
		$this->assertEquals(201,$response->getStatusCode());
	}
	/*
	 | Turns out terminal is an invalied client, until we have a solution
	 | this guy is commented
	 */
	 /*
	public function testLogin()
	{
		$response=$this->post('/api/login',$this->loginData);
		$this->assertEquals(200,$response->getStatusCode());
	}
	 */
}