<?php

namespace Tests\Feature;

use App\Models\Corte;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CortePdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_downloads_a_pdf_with_all_cuts_for_the_authenticated_user(): void
    {
        $user = User::factory()->create();
        $this->withSession([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
            ],
        ]);

        Corte::factory(12)->create([
            'user_id' => $user->id,
            'imagem' => null,
        ]);

        $response = $this->get(route('cortes.pdf', [
            'search' => '',
            'order' => 'oldest',
        ]));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF-', $response->getContent());
        $this->assertStringContainsString('lista-de-cortes.pdf', $response->headers->get('content-disposition'));
    }
}
