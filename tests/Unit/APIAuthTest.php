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

class AddressTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->registrationData=array(
			"name"=>'Anthony Ereng',
			"email"=>'aereng@gmail.com',
			"password"=>'password',
		);

		$this->loginData=array(
			"email"=>'admin@blis.local',
			"password"=>'password',
		);
	}
// api/register
// api/login
// api/logout
	public function testRegister()
	{
		$response=$this->post('/api/register',$this->registrationData);
		$this->assertEquals(201,$response->getStatusCode());
	}

	public function testLogin()
	{
		$response=$this->post('/api/login',$this->loginData);
		$this->assertEquals(200,$response->getStatusCode());
	}

	/*public function testLogOut()
	{
		$response=$this->post('/api/address',$this->addressData);
		$response=$this->get('/api/address/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("period",$response->original);
	}*/
}