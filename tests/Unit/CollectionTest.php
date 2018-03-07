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

class CollectionTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
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
		$response=$this->post('/api/collection',$this->collectionData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("collection_date_time",$response->original);
	}

	public function testListCollection()
	{
		$response=$this->get('/api/collection');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowCollection()
	{
		$response=$this->post('/api/collection',$this->collectionData);
		$response=$this->get('/api/collection/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("collection_date_time",$response->original);
	}

	public function testUpdateCollection()
	{
		$response=$this->post('/api/collection',$this->collectionData);
		$response=$this->put('/api/collection/1',$this->updatedCollectionData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("collection_date_time",$response->original);
	}

	public function testDeleteCollection()
	{
		$response=$this->post('/api/collection',$this->collectionData);
		$response=$this->delete('/api/collection/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}