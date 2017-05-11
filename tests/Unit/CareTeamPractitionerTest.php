<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CareTeamPractitionerTest extends TestCase
{
   public function testStoreCareTeamPractitioner(){

    	$care_team=array(
    		'team_id'=>1,
    		'practitioner_id'=>1
    		);
    	$response=$this->post('/api/care_team_practitioner',$care_team);

    	$this->assertEquals(200,$response->getStatusCode());
    }

    public function testListCareTeamPractitioners(){

    	$response=$this->get('/api/care_team_practitioner');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertArrayHasKey('team_id', $data);
    }

    public function testListCareTeamPractitioner(){

    	$response=$this->get('/api/care_team_practitioner/1');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('team_id', $data);
    }

  

    public function testDeleteCareTeamPractitioner(){
    	
    	$response=$this->delete('/api/care_team_practitioner/1');
    	$this->assertEquals(200,$response->getStatusCode());
    }
}