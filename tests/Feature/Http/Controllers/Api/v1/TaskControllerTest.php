<?php

namespace Tests\Feature\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Task;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Task $task;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory(1)->create()->firstOrFail();
        $this->task = Task::create([
            "title" => "lkdsjflsj",
            "description" => "sjejhfsjdf",
            "color" => "#ffffff",
            "user_id" => $this->user->id,
            "starts_at" => now()
        ]);
        $this->seed(DatabaseSeeder::class);
    }


    public function testIndexAllTasks()
    {
        $response = $this->actingAs($this->user)->getJson(route('task.index'));
        $response->assertSuccessful()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("success", true)
                ->where("error", null)
                ->where("apiVersion", ApiController::API_VERSION)
                ->has("result")
                ->has("result.data")
                ->etc()
            );
    }


    public function testCreateNewTask()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route("task.store"), [
                "title" => "gsdg",
                "description" => "lskdfjlkf",
                "color" => "#ffffff",
                "starts_at" => now()->format("Y-m-d H:i:s"),
            ]);
        $response->assertCreated()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("success", true)
                ->where("apiVersion", ApiController::API_VERSION)
                ->where("error", null)
                ->has("result")
                ->has("result.title")
                ->has("result.description")
                ->has("result.color")
                ->has("result.starts_at")
                ->has("result.id")
                ->etc()
            );
    }

    public function testUpdateTask()
    {
        $response = $this->actingAs($this->user)
            ->patchJson(route("task.update", $this->task->id), [

                "title" => "lkdsjflsj",
                "description" => "sjejhfsjdf",
                "color" => "#fffffc",
                "starts_at" => now()->format("Y-m-d H:i:s")
            ]);
        $response->assertStatus(202)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("success", true)
                ->where("apiVersion", ApiController::API_VERSION)
                ->where("error", null)
                ->where("result", null)
                ->has("message")

            );
    }

    public function testShowTask()
    {
        $response = $this->actingAs($this->user)
            ->getJson(route("task.show", $this->task->id));
        $response->assertSuccessful()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("success", true)
                ->has("result")
                ->has("error")
                ->where("apiVersion", ApiController::API_VERSION)
                ->etc()
            );
    }


    public function testDeleteTask()
    {
        $response = $this->actingAs($this->user)
            ->deleteJson(route('task.destroy', $this->task->id));

        $response->assertStatus(202)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("success", true)
                ->has("message")
                ->where("apiVersion", ApiController::API_VERSION)
                ->where("error", null)
                ->etc()
            );
    }
}
