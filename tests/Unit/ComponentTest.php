<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ComponentTest extends TestCase
{
    use DatabaseMigrations; //Run and drop migrations on all tests

    public function setup(){
        parent::setup();
        $this->setVariables();
    }
    
    public function setVariables()
    {
        $this->componentData = [
            'observation_id' => 1,
            'performed_by' => 1,
            'result' => "Jordan",
            ];

        $this->componentUpdateData = [
            'observation_id' => 2,
            'performed_by' => 2,
            'result' => "Peter",
            ];
    }

    public function testListComponent()
    {
        factory(\App\Models\Component::class)->create($this->componentData);
        $response = $this->json('GET', 'api/component/1');

        $this->assertDatabaseHas('components', $this->componentData);
        $response->assertStatus(200)->assertHasKey($this->componentData);
    }

    public function testListComponents()
    {
        factory(\App\Models\Component::class)->create($this->componentData);
        $response = $this->json('GET', 'api/component');

        $this->assertDatabaseHas('components', $this->componentData);
        $response->assertStatus(200)->assertArrayHasKey($this->componentData);
    }

    public function testStoreComponent()
    {
        $faker = \Faker\Factory::create();
        $componentData = array(
            'observation_id' => 1,
            'performed_by' => 1,
            'result' => "Jordan",
        );
        $response = $this->json('POST', 'api/component', $componentData);
        $this->assertDatabaseHas('components', $componentData);

        $response->assertStatus(200);
    }

    public function testUpdateComponent()
    {
        factory(\App\Models\Component::class)->create($this->componentData);
        $this->put('api/component/1', $this->componentUpdateData);
        $this->assertDatabaseHas('components', $this->componentUpdateData);
    }

    public function testDeleteComponent()
    {
        factory(\App\Models\Component::class)->create();
        $response=$this->delete('api/component/1');
        $response->assertStatus(200);
    }

}