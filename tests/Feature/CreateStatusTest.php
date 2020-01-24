<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_users_can_not_create_statuses()
    {
        $response = $this->post(route('statuses.store'), ['body' => 'Mi primer status']);
        // dd($response->content());
        $response->assertRedirect('login');
    }

    /** @test */
    public function a_authenticated_user_can_create_status()
    {
        $this->withoutExceptionHandling();

        // 1. Given => Teniendo un usuario autenticado
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // 2. When => Cuando hace un post request a status
        $response = $this->post(route('statuses.store'), ['body' => 'Mi primer status']);

        $response->assertJson([
            'body' => 'Mi primer status'
        ]);

        // 3. Then => Entonces veo un nuevo estado en la bade de datos
        $this->assertDatabaseHas('statuses', [
            'user_id' => $user->id,
            'body' => 'Mi primer status'
        ]);
    }

    /** Test */
    public function a_status_requires_a_body()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => '']);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }

    /** Test */
    public function a_status_body_requires_a_minimum_length()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => 'qwser']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }
}
