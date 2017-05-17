<?php

namespace Tests\Feature;

use App\DB\Address;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

 //Address for the contact person.
class AddressesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */

    public function setVariables()
    {
    	$this->AddressData = array
    	(
         'use' =>  \Faker\Factory::create()->randomElement(['home', 'work', 'temp', 'old']),
            'type' =>  \Faker\Factory::create()->randomElement(['postal', 'physical', 'both']),
            'text' => \Faker\Factory::create()->word,
            'line' => \Faker\Factory::create()->word,
            'city' => \Faker\Factory::create()->word,
            'district' => \Faker\Factory::create()->word,
            'state' => \Faker\Factory::create()->word,
            'postal_code' => \Faker\Factory::create()->word,
            'country' => \Faker\Factory::create()->word,
            'period' => \Faker\Factory::create()->date(),
    		);
    	$this->AddressDataUpdate = array (
            
             'text' => \Faker\Factory::create()->word,
            'line' => \Faker\Factory::create()->word,
            'city' => \Faker\Factory::create()->word,
            'district' => \Faker\Factory::create()->word,
            'state' => \Faker\Factory::create()->word,
            'postal_code' => \Faker\Factory::create()->word,
            'country' => \Faker\Factory::create()->word,
    		);
    }
    public function testStoreAddresses()
    {
        $Addresses = $this->AddressData;

        $this->post('/api/address', $Addresses);

        $this->assertDatabaseHas('addresses',$AddressesArray);
    }
    public function testUpdateAddresses()
    {
        $Address = factory(Address::clsss,3)->make();
        $AddressSaved = Address::orderBy('id','desc')->take(1)->get()->toArray();
        $AddressUpdated = $this->update($this->AddressDataUpdate,$AddressSaved[0],['id']);
        $Updated = $this->put('api/address',$AddressUpdated);

        $this->assertEquals(200, $Updated );
    }

    public function testDeleteAddress()
    {
    	factory(Address::class,3)->make();
    	$Address = Address::orderBy('id','desc')
    	              ->take(1)->get()->toArray();
    	$AddressDeleted = $Address
    	->delete('api/address',$Address[0]['id']);
        
       $this->assertEquals(200, $AddressDeleted->getStatusCode());
    }
    public function testShowAddress()
    {
      $Addresses = factory(Address::class,3)->create();
     $Address = $this->json('GET','api/address',$Addresses)
     					->seeJson([
     						'result'=>true]);

     $array = json_decode($Address);
     $result = false;

     if($array[0]->id ==1)
     {
     	$result = true;
     }

     $this->assertEquals(true,$result);
     
    }
}
