<?php

namespace Tests\Feature;

use App\DB\HumanName;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HumanTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    /**Test*/
    public function setVariables()
    {
    	$this->HumannameData = array
    	(
    		'user_id' => factory(User::class)->create()->id,
            'use' => \Faker\Factory::create()->randomElement(['usual', 'official', 'temp', 'nickname', 'anonymous', 'old', 'maiden']),
            'text' => 'text_name',
            'family' => 'family_name',
            'given' => 'given_name',
            'prefix' => 'name_prefix',
            'suffix' => 'name_suffix',
            'period' => \Faker\Factory::create()->date()
    		);
    	$this->HumannameDataUpdate = array
    	(

    		 'use' => \Faker\Factory::create()->randomElement(['usual', 'official', 'temp', 'nickname', 'anonymous', 'old', 'maiden']),
            'text' => 'text_name',
            'family' => 'family_name',
            'given' => 'given_name',
            'prefix' => 'name_prefix',
            'suffix' => 'name_suffix',
            'period' => \Faker\Factory::create()->date()
            );
    }
     public function testStoreHumannames()
    {

        $this->post('/api/humanname/', $this->HumannameData);

        $this->assertDatabaseHas('human_names',$humannamesArray);
    }
    public function testUpdateHumanename()
    {
        $Humanname = factory(HumanName::class,3)->make();
        $this->post('api/humanname',$Humanname);

        $HumannameSaved = HumanName::orderBy('id','desc')->take(1)->get()->toArray();
        $HumannameUpdated = $this->update(
        	$this->HumannameDataUpdate,$HumannameSaved[0]['id']);
        $this->put('api/HumanName',$HumannameUpdated);
       
    }

    public function testHumannamesDelete()
    {
    	factory(HumanName::class,3)->make();
    	$humanname = HumanName::orderBy('id','desc')->take(1)->get()->toArray();
    	$HumannameDeleted = $humanname->delete('api/HumanName',$humanname[0]['id']);
    }
    public function testShowHumanName()
    {
    	$HumanNames = factory(HumanName::class,3)->create();
    	$HumanName = $this->json('GET','api/HumanName',$HumanNames)
    			->seeJson([
    				'result'=>true]);
    $array = json_decode($HumanName);
    $result = false;

    if ($result[0]->id==1)
    {
    	$result = true;
    }
    $this->assertEquals(true, $result);
    }
}
