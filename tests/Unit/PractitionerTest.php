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

class PractitionerTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->practitionerData=array(
			"active"=>'Sample String',
			"created_by"=>1,
			"name"=>'Sample String',
			"telecom"=>'Sample String',
			"address"=>'Sample String',
			"gender_id"=>1,
			"birth_date"=>'2017:12:12 15:30:00',
			"photo"=>'Sample String',
			"qualification"=>'Sample String',
		);
		$this->updatedPractitionerData=array(
			"active"=>'Sample updated String',
			"created_by"=>1,
			"name"=>'Sample updated String',
			"telecom"=>'Sample updated String',
			"address"=>'Sample updated String',
			"gender_id"=>1,
			"birth_date"=>'2016:12:12 15:30:00',
			"photo"=>'Sample updated String',
			"qualification"=>'Sample updated String',
		);
	}

	public function testStorePractitioner()
	{
		$response=$this->post('/api/practitioner',$this->practitionerData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("qualification",$response->original);
	}

	public function testListPractitioner()
	{
		$response=$this->get('/api/practitioner');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowPractitioner()
	{
		$response=$this->post('/api/practitioner',$this->practitionerData);
		$response=$this->get('/api/practitioner/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("qualification",$response->original);
	}

	public function testUpdatePractitioner()
	{
		$response=$this->post('/api/practitioner',$this->practitionerData);
		$response=$this->put('/api/practitioner/1',$this->updatedPractitionerData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("qualification",$response->original);
	}

	public function testDeletePractitioner()
	{
		$response=$this->post('/api/practitioner',$this->practitionerData);
		$response=$this->delete('/api/practitioner/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}