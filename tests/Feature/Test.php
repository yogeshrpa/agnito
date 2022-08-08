<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Test extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_page_view()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }
    public function test_rgister_page_view()
    {
        $response = $this->get('/register');

        $response->assertSuccessful();
        $response->assertViewIs('auth.register');
    }
    public function test_login_page_view_after_login()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/home');
        $user->delete();
    }
    public function test_login_with_password()
    {
        $password = 'agnitoTest';
        $user = User::factory()->create([
            'password' => bcrypt($password),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
        $user->delete();
    }
}
