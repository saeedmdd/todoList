<?php

namespace Tests\Feature\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\BaseFeatureTest;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulRegister()
    {
        $response = $this->postJson(route('register'), [
            "email" => "a@a.com",
            "name" => "dfasdfasdf",
            "password" => "asdasdasd",
            "password_confirmation" => "asdasdasd"
        ]);
        $response->assertCreated()
            ->assertJson(fn(AssertableJson $json) => $json->where("success", true)
                ->where("error", null)
                ->where("apiVersion", ApiController::API_VERSION)
                ->has("result")
                ->has("result.token")
                ->where("result.name", "dfasdfasdf")
                ->where("result.email", "a@a.com")
                ->etc()
            );
    }


    public function testSuccessfulLogin()
    {
        User::create([
            "email" => "a@a.com",
            "password" => "asdasdasd",
            "name" => "asdasdasd"
        ]);
        $response = $this->postJson(route("login"), [
            "email" => "a@a.com",
            "password" => "asdasdasd"
        ]);
        $response->assertStatus(202)
            ->assertJson(fn(AssertableJson $json) => $json->where("success", true)
                ->where("error", null)
                ->where("apiVersion", ApiController::API_VERSION)
                ->has("result")
                ->has("result.token")
                ->where("result.email","a@a.com")
                ->where("result.name", "asdasdasd")
                ->etc()
            );
    }
}
