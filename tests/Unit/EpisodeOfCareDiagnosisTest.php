<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EpisodeOfCareDiagnosisTest extends TestCase
{
    public function testStoreEpisodeOfCareDiagnosis(){

    	$episode_of_care_diagnosis=array(
    		'condition'=>"Discharged",
    		'role'=>"Discharged",
    		'rank'=>"Discharged",
    		'episode_of_care_id'=>1,
    		);
    	$response=$this->post('/api/episode_of_care_diagnosis',$episode_of_care_diagnosis);

    	$this->assertEquals(200,$response->getStatusCode());
    }

    public function testListEpisodeOfCareDiagnoses(){

    	$response=$this->get('/api/episode_of_care_diagnosis');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertArrayHasKey('episode_of_care_id', $data);
    }

    public function testListEpisodeOfCareDiagnosis(){

    	$response=$this->get('/api/episode_of_care_diagnosis/1');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('episode_of_care_id', $data);
    }

    public function testUpdateEpisodeOfCareDiagnosis(){

    	$episode_of_care_diagnosis=array(
    		'condition'=>"Discharged",
    		'role'=>"Discharged",
    		'rank'=>"Discharged",
    		'episode_of_care_id'=>1,
    		);
    	$response=$this->put('/api/episode_of_care_diagnosis/1',$episode_of_care_diagnosis);
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('id', $data);
    }

    public function testDeleteEpisodeOfCareDiagnosis(){
    	
    	$response=$this->delete('/api/episode_of_care_diagnosis/1');
    	$this->assertEquals(200,$response->getStatusCode());
    }
}
