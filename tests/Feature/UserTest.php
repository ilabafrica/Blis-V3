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
        $user = factory(User::class,3)->make($userDataUpdate);

        $this->post('api/user',$userDataUpdate);

        $userSaved = User::orderBy('id','desc')->take(1)->get()->toArray();#
        
        $this->put('api/user',$userDataUpdate);

    }

    public function testUserDelete()
    {
    	factory(User::class,3)->make();
    	$user = User::orderBy('id','desc')->take(1)->get()->toArray();
    	$userDeleted = $this->post('api/user',$user);

    }

    public function testShowUser()
    {
        //Todo
    }
}
