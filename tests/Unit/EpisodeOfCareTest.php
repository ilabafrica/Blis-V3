<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EpisodeOfCareTest extends TestCase
{
    public function testStoreEpisodeOfCare(){

    	$episode=array(
    		'status'=>10,
    		'type'=>1,
    		'patient'=>1,
    		'managing_organization'=>1,
    		'type'=>1,
    		'period'=>1,
    		'care_manager'=>1,
    		'team'=>1,
    		);
    	$response=$this->post('/api/episode_of_care',$episode);

    	$this->assertEquals(200,$response->getStatusCode());
    }

    public function testListEpisodeOfCare(){

    	$response=$this->get('/api/episode_of_care');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertArrayHasKey('patient', $data);
    }

    public function testListEpisodeOfCares(){

    	$response=$this->get('/api/episode_of_care/1');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('patient', $data);
    }

    public function testUpdateEpisodeOfCare(){

    	$episode=array(
    		'status'=>10,
    		'type'=>1,
    		'patient'=>1,
    		'managing_organization'=>1,
    		'type'=>1,
    		'period'=>1,
    		'care_manager'=>1,
    		'team'=>1,
    		);
    	$response=$this->put('/api/episode_of_care/1',$episode);
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('id', $data);
    }

    public function testDeleteEpisodeOfCare(){
    	
    	$response=$this->delete('/api/episode_of_care/1');
    	$this->assertEquals(200,$response->getStatusCode());
    }
}
