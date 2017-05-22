<?php

namespace Tests\Unit;


use App\User;
use App\UserType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */#
    public function testUserStore()
    {
        $userData = array
        (
            'type' => factory(UserType::class)->create()->id,
            'email' => 'test@example.com',
            'password' => '1234678'
        );

        $this->post('/user/', $userData);

        $this->assertDatabaseHas('users',$userData);
    }
    public function testUserUpdate()
    {
        $userDataUpdate = array 
        (
            'email' => 'testUser@example.com',
            'password' => '87654321'
            
        );
        $user = factory(User::class,3)->make();
        $this->post('api/user',$user);

        $userSaved = User::orderBy('id','desc')->take(1)->get()->toArray();#
        $userUpdated = $this->update(
        	$userDataUpdate,$userSaved[0]['id']);
        
        $this->put('api/user',$userUpdated);

    }

    public function testUserDelete()
    {
    	factory(User::class,3)->make();
    	$user = User::orderBy('id','desc')->take(1)->get()->toArray();
    	$userDeleted = $user->delete('api/user',$user[0]['id']);

    }

    public function testShowUser()
    {
    	$users = factory (User::class,3)->make();

    	$user = $this->json('GET','api/user',$users);
    	
    	$array = json_decode($user);
    	
    	$result = false;
    	
    	if($array[0]->id == 1)
    	{
    		$result =true;
    	}
    	$this->assertEquals(true, $result);
    }
}
