<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Status;
use Tests\TestCase;
use App\User;

class ListStatuse extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *@test
     * @return void
     */
    public function can_get_all_statuses()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $status1 = factory(Status::class)->create(['created_at' => now()->subDays(4)]);
        $status2 = factory(Status::class)->create(['created_at' => now()->subDays(3)]);
        $status3 = factory(Status::class)->create(['created_at' => now()->subDays(2)]);
        $status4 = factory(Status::class)->create(['created_at' => now()->subDays(1)]);

        // $statuses = factory(Status::class, 4)->create();

        $response = $this->getJson(route('statuses.index'));

        // dd($response->content());

        $response->assertSuccessful();

        $response->assertJson([
            'total' => 4
        ]);

        $response->assertJsonStructure([
            'data', 'total', 'first_page_url', 'last_page_url'
        ]);

        // dd($response->json('data'));

        $this->assertEquals(
            $status4->id,
            $response->json('data.0.id')

        );
    }
}
