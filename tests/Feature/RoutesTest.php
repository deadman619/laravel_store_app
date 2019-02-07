<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoutesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRoutes()
    {
    	$this->assertGuest($guard = null);
        $this->get('/')->assertStatus(200);
    	$this->get('/products')->assertStatus(200);
    	$this->get('/login')->assertStatus(200);
    	$this->get('/register')->assertStatus(200);
    	$this->get('/admin_panel')->assertRedirect();
    	$this->post('/admin_panel')->assertRedirect();
    	$this->post('/admin_panel/delete')->assertRedirect();
    }
}
