<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReferralRequestTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->referralrequestData=array(
        
			"based_on"=>1,
			"replaces"=>1,
			"group_identifier"=>1,
			"status"=>1,
			"type"=>1,
			"service_requested"=>'Sample String',
			"subject"=>1,
			"requester"=>1,
			"specialty"=>1,
			"recipient"=>1,
			"reason_code"=>1,
			"reason_reference"=>'Sample String',
			"supporting_info"=>'Sample String',
			"description"=>'Sample String',
			"note"=>'Sample String',

        );
    	$this->updatedreferralrequestData=array(
        
			"based_on"=>1,
			"replaces"=>1,
			"group_identifier"=>1,
			"status"=>1,
			"type"=>1,
			"service_requested"=>'Sample updated String',
			"subject"=>1,
			"requester"=>1,
			"specialty"=>1,
			"recipient"=>1,
			"reason_code"=>1,
			"reason_reference"=>'Sample updated String',
			"supporting_info"=>'Sample updated String',
			"description"=>'Sample updated String',
			"note"=>'Sample updated String',

        );
	}

	public function testStoreReferralRequest()
	{
		$response=$this->json('POST', '/api/referralrequest',$this->referralrequestData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testListReferralRequest()
	{
		$response=$this->json('GET', '/api/referralrequest');
		$response->assertStatus(200);
		
	}

	public function testShowReferralRequest()
	{
		$this->json('POST', '/api/referralrequest',$this->referralrequestData);
		$response=$this->json('GET', '/api/referralrequest/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testUpdateReferralRequest()
	{
		$this->json('POST', '/api/referralrequest',$this->referralrequestData);
		$response=$this->json('PUT', '/api/referralrequest/1',$this->updatedreferralrequestData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testDeleteReferralRequest()
	{
		$this->json('POST', '/api/referralrequest',$this->referralrequestData);
		$response=$this->delete('/api/referralrequest/1');
		$response->assertStatus(200);
		
	}

}