<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * 
     * @test
     * 
     * A basic test example.
     * 
     * @return void
     */
    public function only_logged_in_users_can_see_the_dashboard()
    {
        $response = $this->get('/home')->assertRedirect('/login');
    }
}
