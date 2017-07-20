<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CodingTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->codingData=array(
        
			"uri"=>'Sample String',
			"version"=>'Sample String',
			"code"=>'Sample String',
			"display"=>'Sample String',

        );
    	$this->updatedcodingData=array(
        
			"uri"=>'Sample updated String',
			"version"=>'Sample updated String',
			"code"=>'Sample updated String',
			"display"=>'Sample updated String',

        );
	}

	public function testStoreCoding()
	{
		$response=$this->json('POST', '/api/coding',$this->codingData);
		$response->assertStatus(200);
		//$this->assertArrayHasKey("display",$response->original);
	}

	public function testListCoding()
	{
		$response=$this->json('GET', '/api/coding');
		$response->assertStatus(200);
		
	}

	public function testShowCoding()
	{
		$this->json('POST', '/api/coding',$this->codingData);
		$response=$this->json('GET', '/api/coding/1');
		$response->assertStatus(200);
		//$this->assertArrayHasKey("display",$response->original);
	}

	public function testUpdateCoding()
	{
		$this->json('POST', '/api/coding',$this->codingData);
		$response=$this->json('PUT', '/api/coding/1',$this->updatedcodingData);
		$response->assertStatus(200);
		//$this->assertArrayHasKey("display",$response->original);
	}

	public function testDeleteCoding()
	{
		$this->json('POST', '/api/coding',$this->codingData);
		$response=$this->delete('/api/coding/1');
		$response->assertStatus(200);
		
	}

}