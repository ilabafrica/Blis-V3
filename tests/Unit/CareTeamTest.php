<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CareTeamTest extends TestCase
{
   public function testStoreCareTeam(){

    	$care_team=array(
    		'identifiers'=>"pablo",
    		'status'=>1,
    		'category'=>1,
    		'name'=>"Sanyore",
    		'subject'=>1,
    		'context'=>1,
    		'period'=>10,
    		'reason_code'=>1,
    		'reason_reference'=>"n/a",
    		'managing_organization'=>1,
    		'comment'=>"n/a"
    		);
    	$response=$this->post('/api/care_team',$care_team);

    	$this->assertEquals(200,$response->getStatusCode());
    }

    public function testListCareTeams(){

    	$response=$this->get('/api/care_team');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertArrayHasKey('subject', $data);
    }

    public function testListCareTeam(){

    	$response=$this->get('/api/care_team/1');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('subject', $data);
    }

    public function testUpdateCareTeam(){

    	$care_team=array(
    		'identifiers'=>"pablo",
    		'status'=>1,
    		
    		'reason_reference'=>"n/a",
    		'managing_organization'=>1,
    		'comment'=>"n/a"
    		);
    	$response=$this->put('/api/care_team/1',$care_team);
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('id', $data);
    }

    public function testDeleteCareTeam(){
    	
    	$response=$this->delete('/api/care_team/1');
    	$this->assertEquals(200,$response->getStatusCode());
    }
}
