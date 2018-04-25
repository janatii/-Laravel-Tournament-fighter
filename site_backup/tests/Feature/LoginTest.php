<?php

namespace Tests\Feature;

use App\Exceptions\UserLockedException;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testLoginPageAccess()
    {
        $res = $this->get(route('login'))
                    ->assertStatus(200);
    }
    
    public function testLoginFailCauseNoAccount()
    {
        $this->get(route('login'))
             ->assertStatus(200);
        
        $response = $this->post(route('login'), [
            'email' => 'toto@example.net',
            'password' => 'secret',
        ]);
        
        $response->assertRedirect(route('login'));
    
        $response2 = $this->get(route('login'));
        $response2->assertSee('These credentials do not match our records');
    }
    
    public function testLoginFailCauseWrongEmail()
    {
        $user = factory(User::class)->create();
    
        $this->get(route('login'))
             ->assertStatus(200);
    
        $response = $this->post(route('login'), [
            'email' => $user->email . 'kdsqkqjs',
            'password' => 'secret',
        ]);
    
        $response->assertRedirect(route('login'));
        $this->dontSeeIsAuthenticated();
    }
    
    public function testLoginFailCauseWrongPassword()
    {
        $user = factory(User::class)->create();
    
        $this->get(route('login'))
            ->assertStatus(200);
    
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'secrett',
        ]);
    
        $response->assertRedirect(route('login'));
        $this->dontSeeIsAuthenticated();
    }
    
    public function testLoginFailCauseLock()
    {
        $user = factory(User::class)->create([
            'lock' => 1
        ]);
    
        $this->get(route('login'))
             ->assertStatus(200);
        
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'secret',
        ]);
    
        $response->assertStatus(500);
        $response->assertSee('UserLockedException');
        $this->dontSeeIsAuthenticated();
    }
    
    public function testLoginSuccess()
    {
        $user = factory(User::class)->create([
            'lock' => 0
        ]);
    
        $this->get(route('login'))
             ->assertStatus(200);
        
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'secret',
        ]);
        
        $response->assertRedirect(route('home'));
        $this->seeIsAuthenticatedAs($user);
    }
    
    public function testLogoutSuccess()
    {
        $user = factory(User::class)->create();
        
        $this->actingAs($user);
    
        $this->seeIsAuthenticatedAs($user);
        
        $this->post(route('logout'));
        
        $this->dontSeeIsAuthenticated();
    }
}
