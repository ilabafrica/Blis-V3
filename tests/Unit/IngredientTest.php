<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IngredientTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->ingredientData=array(
        
			"substance"=>1,

        );
    	$this->updatedingredientData=array(
        
			"substance"=>1,

        );
	}

	public function testStoreIngredient()
	{
		$response=$this->json('POST', '/api/ingredient',$this->ingredientData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testListIngredient()
	{
		$response=$this->json('GET', '/api/ingredient');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowIngredient()
	{
		$this->json('POST', '/api/ingredient',$this->ingredientData);
		$response=$this->json('GET', '/api/ingredient/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdateIngredient()
	{
		$this->json('POST', '/api/ingredient',$this->updatedingredientData);
		$response=$this->json('PUT', '/api/ingredient');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeleteIngredient()
	{
		$this->json('POST', '/api/ingredient',$this->ingredientData);
		$response=$this->delete('/api/ingredient/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}