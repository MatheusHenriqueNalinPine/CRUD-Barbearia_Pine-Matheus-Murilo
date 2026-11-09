<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PerfilTest extends TestCase
{
    use RefreshDatabase;

    public function test_logged_in_user_can_open_their_profile_page(): void
    {
        $user = User::factory()->create();
        $this->withSession(['user' => ['id' => $user->id, 'username' => $user->username]]);

        $this->get(route('perfil.edit'))
            ->assertOk()
            ->assertSee($user->username)
            ->assertSee($user->email);
    }

    public function test_logged_in_user_can_update_their_own_profile_and_session(): void
    {
        $user = User::factory()->create();
        $this->withSession(['user' => ['id' => $user->id, 'username' => $user->username]]);

        $this->post(route('perfil.update'), [
            'username' => 'novo-usuario',
            'email' => 'novo@email.com',
            'password' => 'nova-senha-123',
            'password_confirmation' => 'nova-senha-123',
        ])->assertRedirect(route('perfil.edit'))
            ->assertSessionHas('success')
            ->assertSessionHas('user.username', 'novo-usuario')
            ->assertSessionHas('user.email', 'novo@email.com');

        $user->refresh();
        $this->assertSame('novo-usuario', $user->username);
        $this->assertSame('novo@email.com', $user->email);
        $this->assertTrue(Hash::check('nova-senha-123', $user->password));
    }

    public function test_profile_edit_requires_a_logged_in_user(): void
    {
        $this->get(route('perfil.edit'))->assertRedirect(route('login'));
    }
}
