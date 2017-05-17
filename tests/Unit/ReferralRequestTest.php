<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReferralRequestTest extends TestCase
{
   public function testStoreReferralRequest(){

    	$referral_request=array(
    		'based_on'=>1,
    		'replaces'=>1,
    		'group_identifier'=>1,
    		'status'=>1,
    		'type'=>1,
    		'priority'=>1,
    		'subject'=>1,
    		'service_requested'=>"Discharge",
    		'occurence'=>"2012-12-12 12:00:00",
    		'requester'=>1,
    		'specialty'=>1,
    		'recipient'=>1,
    		'reason_code'=>1,
    		'reason_reference'=>"",
    		'supporting_info'=>"",
    		'description'=>"referral from nandi",
    		'note'=>"n/a"
    		);
    	$response=$this->post('/api/referral_request',$referral_request);

    	$this->assertEquals(200,$response->getStatusCode());
    }

    public function testListReferralRequests(){

    	$response=$this->get('/api/referral_request');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertArrayHasKey('subject', $data);
    }

    public function testListReferralRequest(){

    	$response=$this->get('/api/referral_request/1');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('subject', $data);
    }

    public function testUpdateReferralRequest(){

    	$referral_request=array(
    		'based_on'=>1,
    		'replaces'=>1,
    		'group_identifier'=>1,
      		'reason_code'=>1,
    		'reason_reference'=>"",
    		'supporting_info'=>"",
    		'description'=>"referral from nandi",
    		'note'=>"n/a"
    		);
    	$response=$this->put('/api/referral_request/1',$referral_request);
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('id', $data);
    }

    public function testDeleteReferralRequest(){
    	
    	$response=$this->delete('/api/referral_request/1');
    	$this->assertEquals(200,$response->getStatusCode());
    }
}
