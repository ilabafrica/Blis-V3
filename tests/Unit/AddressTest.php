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
		$this->addressData=array(
			"patient_id"=>1,
			"text"=>'Sample String',
			"line"=>'Sample String',
			"city"=>'Sample String',
			"district"=>'Sample String',
			"state"=>'Sample String',
			"postal_code"=>'Sample String',
			"country"=>'Sample String',
			"period"=>'Sample String',
		);
		$this->updatedAddressData=array(
			"patient_id"=>1,
			"text"=>'Sample updated String',
			"line"=>'Sample updated String',
			"city"=>'Sample updated String',
			"district"=>'Sample updated String',
			"state"=>'Sample updated String',
			"postal_code"=>'Sample updated String',
			"country"=>'Sample updated String',
			"period"=>'Sample updated String',
		);
	}

	public function testStoreAddress()
	{
		$response=$this->post('/api/address',$this->addressData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("period",$response->original);
	}

	public function testListAddress()
	{
		$response=$this->get('/api/address');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowAddress()
	{
		$response=$this->post('/api/address',$this->addressData);
		$response=$this->get('/api/address/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("period",$response->original);
	}

	public function testUpdateAddress()
	{
		$response=$this->post('/api/address',$this->addressData);
		$response=$this->put('/api/address/1',$this->updatedAddressData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("period",$response->original);
	}

	public function testDeleteAddress()
	{
		$response=$this->post('/api/address',$this->addressData);
		$response=$this->delete('/api/address/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}