<?php

namespace Tests\Unit\Http\Resources;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Resources\StatusResource;
use App\Models\Status;
use Tests\TestCase;

class StatusResourceTest extends TestCase
{
	use RefreshDatabase;

    /**
     * A basic unit test example.
     *@test
     * @return void
     */
    public function a_status_resources_must_have_the_necesary_fields()
    {
        $status = factory(Status::class)->create();

        $statusResource = StatusResource::make($status)->resolve();

        $this->assertEquals(
            $status->id,
            $statusResource['id']
        );

        $this->assertEquals(
            $status->body,
            $statusResource['body']
        );

        $this->assertEquals(
            $status->user->name,
            $statusResource['user_name']
        );

        $this->assertEquals(
            'https://aprendible.com/images/default-avatar.jpg',
            $statusResource['user_avatar']
        );

        $this->assertEquals(
            $status->created_at->diffForHumans(),
            $statusResource['ago']
        );

        $this->assertEquals(
            false,
            $statusResource['is_liked']
        );
    }
}
