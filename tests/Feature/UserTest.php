<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;

class UserTest extends TestCase
{   
    
    /**
     * Test if user can be resgistred.
     */
    public function test_if_user_can_be_registred(): void
    {
        $faker = Faker::create();

        $response = $this->post(
            '/api/register',
            [
                "name"=>$faker->name(),
                "email"=>$faker->email(),
                "password"=>"123456",
                "password_confirmation"=>"123456"
            ]
        );
        $response->assertStatus(201);
    }

    /**
     * Test if user can autenticate.
     */
    public function test_if_user_can_be_login(): void
    {

        $userTest = User::first();
        $response = $this->post(
            '/api/login',
        [
            "email"=>$userTest->email,
            "password"=>123456,
        ]);

        $response->assertStatus(200);
    }
}
