<?php

namespace Tests\Feature;

use App\Models\Sugestao;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_comunidade_pode_enviar_sugestao(): void
    {
        $response = $this->postJson('/api/sugestoes', [
            'nome' => 'Pessoa Teste',
            'email' => 'pessoa@example.com',
            'assunto' => 'Atividade',
            'mensagem' => 'Sugestão para a comunidade.',
        ]);

        $response->assertSuccessful()->assertJsonPath('data.status', 'pendente');
        $this->assertDatabaseHas('sugestoes', [
            'email' => 'pessoa@example.com',
            'status' => 'pendente',
        ]);
    }

    public function test_mural_exibe_apenas_sugestoes_aprovadas(): void
    {
        Sugestao::create([
            'nome' => 'Aprovada',
            'email' => 'aprovada@example.com',
            'assunto' => 'Assunto',
            'mensagem' => 'Mensagem',
            'status' => 'aprovada',
        ]);
        Sugestao::create([
            'nome' => 'Pendente',
            'email' => 'pendente@example.com',
            'assunto' => 'Assunto',
            'mensagem' => 'Mensagem',
            'status' => 'pendente',
        ]);

        $this->getJson('/api/sugestoes-aprovadas')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.nome', 'Aprovada');
    }

    public function test_rotas_administrativas_exigem_autenticacao(): void
    {
        $this->getJson('/api/admin/dashboard')->assertUnauthorized();
    }

    public function test_administrador_pode_autenticar_e_acessar_dashboard(): void
    {
        $user = User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => 'Senha1234',
            'is_admin' => true,
        ]);

        $login = $this->postJson('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'Senha1234',
        ])->assertOk();

        $token = $login->json('token');
        $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/admin/dashboard')
            ->assertOk()
            ->assertJsonStructure(['resumo', 'sugestoes_por_status']);

        $this->assertNotEmpty($user->fresh()->tokens);
    }
}
