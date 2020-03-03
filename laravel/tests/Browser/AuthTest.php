<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testUserAuth()
    {
        $this->browse(function (Browser $register, Browser $login) {
            $register->visit('/register')
                ->type('name', 'TEST')
                ->type('email', 'test@test.test')
                ->type('password', 1234567890)
                ->type('password_confirmation', 1234567890)
                ->press('Register')
                ->waitForLocation('/admin');

            $login->visit('/login')
                ->type('email', 'test@test.test')
                ->type('password', 1234567890)
                ->press('Войти')
                ->waitForLocation('/admin');
        });
    }
}
