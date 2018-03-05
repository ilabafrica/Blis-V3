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

class CollectionTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->collectionData=array(
			"collector_id"=>1,
			"collection_date_time"=>'Sample String',
		);
		$this->updatedCollectionData=array(
			"collector_id"=>1,
			"collection_date_time"=>'Sample updated String',
		);
	}

	public function testStoreCollection()
	{
		$response=$this->json('POST', '/api/collection',$this->collectionData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("collection_date_time",$response->original);
	}

	public function testListCollection()
	{
		$response=$this->json('GET', '/api/collection');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowCollection()
	{
		$this->json('POST', '/api/collection',$this->collectionData);
		$response=$this->json('GET', '/api/collection/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("collection_date_time",$response->original);
	}

	public function testUpdateCollection()
	{
		$this->json('POST', '/api/collection',$this->collectionData);
		$response=$this->json('PUT', '/api/collection/1',$this->updatedCollectionData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("collection_date_time",$response->original);
	}

	public function testDeleteCollection()
	{
		$this->json('POST', '/api/collection',$this->collectionData);
		$response=$this->delete('/api/collection/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}