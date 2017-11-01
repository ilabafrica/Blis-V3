<?php
namespace Tests\Unit;

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
        
			"collector"=>1,
			"collection_time"=>'2017:12:12 15:30:00',
			"quantity_id"=>1,
			"method"=>1,
			"body_site"=>1,

        );
    	$this->updatedcollectionData=array(
        
			"collector"=>1,
			"collection_time"=>'2017:12:12 16:30:00',
			"quantity_id"=>1,
			"method"=>1,
			"body_site"=>1,

        );
	}

	public function testStoreCollection()
	{
		$response=$this->json('POST', '/api/collection',$this->collectionData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("method",$response->original);
	}

	public function testListCollection()
	{
		$response=$this->json('GET', '/api/collection');
		$response->assertStatus(200);
		
	}

	public function testShowCollection()
	{
		$this->json('POST', '/api/collection',$this->collectionData);
		$response=$this->json('GET', '/api/collection/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("method",$response->original);
	}

	public function testUpdateCollection()
	{
		$this->json('POST', '/api/collection',$this->collectionData);
		$response=$this->json('PUT', '/api/collection/1',$this->updatedcollectionData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("method",$response->original);
	}

	public function testDeleteCollection()
	{
		$this->json('POST', '/api/collection',$this->collectionData);
		$response=$this->delete('/api/collection/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/collection/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}
	public function testDeleteCollectionFail()
	{
		$response=$this->delete('/api/collection/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}