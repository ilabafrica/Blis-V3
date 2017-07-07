<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PanelTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->panelData=array(
        
			"panel_type_id"=>1,
			"performed_by"=>1,
			"specimen_id"=>1,
			"conclusion"=>'Sample String',
			"coded_diagnosis"=>1,
			"status_id"=>1,

        );
    	$this->updatedpanelData=array(
        
			"panel_type_id"=>1,
			"performed_by"=>1,
			"specimen_id"=>1,
			"conclusion"=>'Sample updated String',
			"coded_diagnosis"=>1,
			"status_id"=>1,

        );
	}

	public function testStorePanel()
	{
		$response=$this->json('POST', '/api/panel',$this->panelData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testListPanel()
	{
		$response=$this->json('GET', '/api/panel');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowPanel()
	{
		$this->json('POST', '/api/panel',$this->panelData);
		$response=$this->json('GET', '/api/panel/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdatePanel()
	{
		$this->json('POST', '/api/panel',$this->updatedpanelData);
		$response=$this->json('PUT', '/api/panel');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeletePanel()
	{
		$this->json('POST', '/api/panel',$this->panelData);
		$response=$this->delete('/api/panel/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}