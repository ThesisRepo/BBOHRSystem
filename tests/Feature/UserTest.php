<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     * 
     * @test
     * 
     * @return void
     */
    public function only_logged_in_users_can_see_the_dashboard()
    {
        $response = $this->get('/home')->assertRedirect('/login');
    }
}
