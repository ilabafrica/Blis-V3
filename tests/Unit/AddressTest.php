<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddressTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->addressData=array(
        
			"use"=>1,
			"type"=>1,
			"text"=>'Sample String',
			"line"=>'Sample String',
			"city"=>'Sample String',
			"district"=>'Sample String',
			"state"=>'Sample String',
			"postal_code"=>'Sample String',
			"country"=>'Sample String',
			"period"=>'2017:12:12 15:30:00',
        );
    	$this->updatedaddressData=array(
        
			"use"=>1,
			"type"=>1,
			"text"=>'Sample updated String',
			"line"=>'Sample updated String',
			"city"=>'Sample updated String',
			"district"=>'Sample updated String',
			"state"=>'Sample updated String',
			"postal_code"=>'Sample updated String',
			"country"=>'Sample updated String',
			"period"=>'2016:12:12 15:30:00',
        );
	}

	public function testStoreAddress()
	{
		$response=$this->json('POST', '/api/address',$this->addressData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("district",$response->original);
	}

	public function testListAddress()
	{
		$response=$this->json('GET', '/api/address');
		$response->assertStatus(200);
		
	}

	public function testShowAddress()
	{
		$this->json('POST', '/api/address',$this->addressData);
		$response=$this->json('GET', '/api/address/1');
		$response->assertStatus(200);
		
	}

	public function testUpdateAddress()
	{
		$this->json('POST', '/api/address',$this->addressData);
		$response=$this->json('PUT', '/api/address/1',$this->updatedaddressData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("district",$response->original);
	}

	public function testDeleteAddress()
	{
		$this->json('POST', '/api/address',$this->addressData);
		$response=$this->delete('/api/address/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/address/1');
		$this->assertEquals(500, $response->getStatusCode());
		
	}

	public function testDeleteAddressFail()
	{
		$response=$this->delete('/api/address/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}