<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testViewLogin()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testViewRegistration()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }
}
