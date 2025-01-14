<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use Tests\TestCase;
use Faker\Factory as Faker;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderTest extends TestCase
{

     static function getUserToken(){
        $user = User::first();
        $token = JWTAuth::fromUser($user);
        return $token;
    }

    /**
     * Test if user can create an order.
     */
    public function test_if_user_can_create_order(): void
    {
        $faker = Faker::create();
        $token = SELF::getUserToken();
        $response = $this->post(
            '/api/order',
            [
                "requester_name"=> $faker->name(),
                "destination"=> $faker->city(),
                "departure"=>"2024-12-01",
                "arrival"=>"2024-12-12",
                "status"=> Status::first()->id
            ],
            [
                'HTTP_AUTHORIZATION' => "Bearer {$token}",
                'HTTP_ACCEPT' => 'application/ld+json'
           ]);
        $response->assertStatus(201);
    }

    /**
     * Test if users can list their order.
     */
    public function test_if_user_can_list_order(): void
    {
        $token = SELF::getUserToken();
        $response = $this->get(
            '/api/order',
            [
                'HTTP_AUTHORIZATION' => "Bearer {$token}",
                'HTTP_ACCEPT' => 'application/ld+json'
           ]);

        $response->assertStatus(200);
    }

    /**
     * Test if users can view one order.
     */
    public function test_if_user_can_view_order(): void
    {
        $token = SELF::getUserToken();
        $orderTest = Order::first();
        $response = $this->get(
            "/api/order/$orderTest->id",
            [
                'HTTP_AUTHORIZATION' => "Bearer {$token}",
                'HTTP_ACCEPT' => 'application/ld+json'
           ]);

        $response->assertStatus(200);
    }

    /**
     * Test if users can cancel one order.
     */
    public function test_if_user_can_cancel_order(): void
    {
        $token = SELF::getUserToken();
        $orderTest = Order::first();
        $orderTest->update(["status_id"=>Status::APROVADO]);
        $response = $this->post(
            "/api/order/cancel",
            [
                "id"=> $orderTest->id
            ],
            [
                'HTTP_AUTHORIZATION' => "Bearer {$token}",
                'HTTP_ACCEPT' => 'application/ld+json'
           ]);

        $response->assertStatus(200);
    }

    /**
     * Test if users can update status one order.
     */
    public function test_if_user_can_update_status_order(): void
    {
        $token = SELF::getUserToken();
        $orderTest = Order::first();
        $response = $this->post(
            "/api/order/updatestatus",
            [
                "id"=> $orderTest->id,
                "status" => Status::APROVADO
            ],
            [
                'HTTP_AUTHORIZATION' => "Bearer {$token}",
                'HTTP_ACCEPT' => 'application/ld+json'
           ]);

        $response->assertStatus(200);
    }
}
