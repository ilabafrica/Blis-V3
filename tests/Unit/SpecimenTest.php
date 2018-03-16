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

class SpecimenTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->specimenData=array(
			"identifier"=>'Sample String',
			"accession_identifier"=>'Sample String',
			"specimen_type_id"=>1,
			"parent_id"=>1,
			"specimen_status_id"=>1,
			"received_by"=>1,
			"time_collected"=>'Sample String',
			"received_time"=>'Sample String',
		);
		$this->updatedSpecimenData=array(
			"identifier"=>'Sample updated String',
			"accession_identifier"=>'Sample updated String',
			"specimen_type_id"=>1,
			"parent_id"=>1,
			"specimen_status_id"=>1,
			"received_by"=>1,
			"time_collected"=>'Sample updated String',
			"received_time"=>'Sample updated String',
		);
	}

	public function testStoreSpecimen()
	{
		$response=$this->post('/api/specimen',$this->specimenData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("received_time",$response->original);
	}

	public function testListSpecimen()
	{
		$response=$this->get('/api/specimen');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowSpecimen()
	{
		$response=$this->post('/api/specimen',$this->specimenData);
		$response=$this->get('/api/specimen/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("received_time",$response->original);
	}

	public function testUpdateSpecimen()
	{
		$response=$this->post('/api/specimen',$this->specimenData);
		$response=$this->put('/api/specimen/1',$this->updatedSpecimenData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("received_time",$response->original);
	}

	public function testDeleteSpecimen()
	{
		$response=$this->post('/api/specimen',$this->specimenData);
		$response=$this->delete('/api/specimen/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}