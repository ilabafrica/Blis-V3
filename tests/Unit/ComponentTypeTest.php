<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ComponentTypeTest extends TestCase
{
    use DatabaseMigrations; //Run and drop migrations on all tests

    public function setup(){
        parent::setup();
        $this->setVariables();
    }
    
    public function setVariables()
    {
        $this->componentTypeData = [
            'code_id' => 1,
            'result_type_id' => 1,
            'reference_range_id' => 1,
            ];

        $this->componentTypeUpdateData = [
            'code_id' => 2,
            'result_type_id' => 2,
            'reference_range_id' => 2,
            ];
    }

    public function testListComponentType()
    {
        factory(\App\Models\ComponentType::class)->create($this->componentTypeData);
        $response = $this->json('GET', 'api/componenttype/1');

        $this->assertDatabaseHas('component_types', $this->componentTypeData);
        $response->assertStatus(200);
        $this->assertArrayHasKey("result_type_id", $response->original);
    }

    public function testListComponentTypes()
    {
        factory(\App\Models\ComponentType::class)->create($this->componentTypeData);
        $response = $this->json('GET', 'api/componenttype');

        $this->assertDatabaseHas('component_types', $this->componentTypeData);
        $response->assertStatus(200);
    }

    public function testStoreComponentType()
    {
        $faker = \Faker\Factory::create();
        $componentTypeData = array(
            'code_id' => 1,
            'result_type_id' => 1,
            'reference_range_id' => 1,
        );
        $response = $this->json('POST', 'api/componenttype', $componentTypeData);
        $this->assertDatabaseHas('component_types', $componentTypeData);

        $response->assertStatus(200);
        $this->assertArrayHasKey("result_type_id", $response->original);
    }

    public function testUpdateComponentType()
    {
        factory(\App\Models\ComponentType::class)->create($this->componentTypeData);
        $response = $this->json('PUT', 'api/componenttype/1', $this->componentTypeUpdateData);
        $this->assertDatabaseHas('component_types', $this->componentTypeUpdateData);
        $this->assertArrayHasKey("result_type_id", $response->original);
    }

    public function testDeleteComponentType()
    {
        factory(\App\Models\ComponentType::class)->create();
        $response=$this->json('DELETE', 'api/componenttype/1');
        $response->assertStatus(200);
        $this->assertArrayHasKey("result_type_id", $response->original);
    }

}