<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomepageTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testHomepageLoggedOut()
    {
        $user = factory(User::class)->create();
        
        $response = $this->get(route('home'))
                         ->assertStatus(200);
        
        $response->assertSee('Login');
        $response->assertSee('Register');
        $response->assertSee('You are a visitor');
        $response->assertDontSee('Profile');
        $response->assertDontSee('Logout');
        $response->assertDontSee('You are logged in');
    }
    
    public function testHomepageLoggedIn()
    {
        $user = factory(User::class)->create();
    
        $response = $this->actingAs($user)
                         ->get(route('home'))
                         ->assertStatus(200);
    
        $this->seeIsAuthenticated();
        $response->assertDontSee('Login');
        $response->assertDontSee('Register');
        $response->assertDontSee('You are a visitor');
        $response->assertSee('Profile');
        $response->assertSee('Logout');
        $response->assertSee('You are logged in');
    }
}
