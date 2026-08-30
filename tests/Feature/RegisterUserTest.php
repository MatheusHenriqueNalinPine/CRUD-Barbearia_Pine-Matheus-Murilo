<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_register_page(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_user_can_register_successfully(): void
    {
        $response = $this->post('/register-submit', [
            'username' => 'novousuario',
            'email' => 'novo@teste.com',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'username' => 'novousuario',
            'email' => 'novo@teste.com',
        ]);
    }
}
