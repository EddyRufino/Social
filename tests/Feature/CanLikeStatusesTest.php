<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Status;
use Tests\TestCase;
use App\User;

class CanLikeStatusesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_users_can_not_like_statuses()
    {
      $status = factory(Status::class)->create();

      $response = $this->post(route('statuses.likes.store', $status));

      $response->assertRedirect('login');

    }

    /** @test */
    public function an_authenticated_user_can_like_statuses()
    {
      $this->withoutExceptionHandling();

      $user = factory(User::class)->create();
      $status = factory(Status::class)->create();

      $this->actingAs($user)->postJson(route('statuses.likes.store', $status));

      $this->assertDatabaseHas('likes', [
        'user_id' => $user->id,
        'status_id' => $status->id
        ]);
     }
}
