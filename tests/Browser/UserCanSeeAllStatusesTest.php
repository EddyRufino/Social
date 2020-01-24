<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Status;
use App\User;

class UserCanSeeAllStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *@test
     * @return void
     */
    public function users_can_see_all_statuses_on_the_homepage()
    {
        $user = factory(User::class)->create(['email' => 'eddyjaair@gmail.com']);

        $statuses = factory(Status::class, 3)->create();

        $this->browse(function (Browser $browser) use($statuses, $user) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->waitForText($statuses->first()->body);

            foreach ($statuses as $status)
            {
                $browser->assertSee($status->body);
            }
        });
    }
}
