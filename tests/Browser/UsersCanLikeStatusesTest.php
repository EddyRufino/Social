<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Status;
use App\User;

class UsersCanLikeStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *@test
     * @return void
     */
    public function users_can_like_statuses()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use($user, $status) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->waitForText($status->body)
                    ->press('@like-btn')
                    ->waitForText('TE GUSTA')
                    ->assertSee('TE GUSTA');
        });
    }
}
