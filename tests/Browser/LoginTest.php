<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *@test
     * @return void
     */
    public function registered_users_can_login()
    {
        factory(User::class)->create(['email' => 'eddyjaair@gmail.com']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'eddyjaair@gmail.com')
                    ->type('password', 'password')
                    ->press('#login-btn')
                    ->assertAuthenticated();
        });
    }
}
