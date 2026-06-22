<?php

namespace Tests\Feature;

use App\Models\Sugestao;
use App\Models\User;
use App\Models\Visita;
use App\Notifications\AdminPasswordResetNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
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
            ->assertJsonPath('data.0.nome', 'Aprovada')
            ->assertJsonMissingPath('data.0.email')
            ->assertJsonMissingPath('data.0.telefone')
            ->assertJsonMissingPath('data.0.resposta_admin');
    }

    public function test_rotas_administrativas_exigem_autenticacao(): void
    {
        $this->getJson('/api/admin/dashboard')->assertUnauthorized();
    }

    public function test_site_registra_apenas_visitas_publicas(): void
    {
        $this->postJson('/api/visitas', ['caminho' => '/noticias/exemplo?origem=home'])
            ->assertNoContent();
        $this->postJson('/api/visitas', ['caminho' => '/admin'])
            ->assertNoContent();

        $this->assertDatabaseHas('visitas', ['caminho' => '/noticias/exemplo']);
        $this->assertDatabaseCount('visitas', 1);
        $this->assertSame(1, Visita::count());
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
            ->assertJsonStructure([
                'resumo',
                'sugestoes_por_status',
                'atividade_ultimos_7_dias' => [
                    '*' => ['data', 'rotulo', 'sugestoes', 'mensagens', 'total'],
                ],
                'acessos_ultimos_7_dias' => [
                    '*' => ['data', 'rotulo', 'total'],
                ],
            ])
            ->assertJsonCount(7, 'atividade_ultimos_7_dias')
            ->assertJsonCount(7, 'acessos_ultimos_7_dias');

        $this->assertNotEmpty($user->fresh()->tokens);
    }

    public function test_slug_automatico_duplicado_retorna_erro_de_validacao(): void
    {
        $user = User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => 'Senha1234',
            'is_admin' => true,
        ]);
        $token = $user->createToken('api-token')->plainTextToken;
        $dados = [
            'titulo' => 'Campanha de Proteção',
            'descricao_curta' => 'Descrição da campanha.',
            'conteudo' => 'Conteúdo da campanha.',
            'status' => 'publicado',
            'destaque' => false,
        ];

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/admin/campanhas', $dados)
            ->assertCreated()
            ->assertJsonPath('data.slug', 'campanha-de-protecao');

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/admin/campanhas', $dados)
            ->assertUnprocessable()
            ->assertJsonValidationErrors('slug');
    }

    public function test_recuperacao_de_senha_nao_revela_se_email_existe(): void
    {
        Notification::fake();

        $this->postJson('/api/esqueci-senha', [
            'email' => 'inexistente@example.com',
        ])->assertOk()->assertJsonStructure(['message']);

        Notification::assertNothingSent();
    }

    public function test_administrador_recebe_link_de_recuperacao(): void
    {
        Notification::fake();
        $user = User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => 'Senha1234',
            'is_admin' => true,
        ]);

        $this->postJson('/api/esqueci-senha', [
            'email' => $user->email,
        ])->assertOk();

        Notification::assertSentTo($user, AdminPasswordResetNotification::class);
    }

    public function test_administrador_pode_redefinir_senha_com_token_valido(): void
    {
        $user = User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => 'Senha1234',
            'is_admin' => true,
        ]);
        $token = Password::createToken($user);

        $this->postJson('/api/redefinir-senha', [
            'email' => $user->email,
            'token' => $token,
            'password' => 'NovaSenha123',
            'password_confirmation' => 'NovaSenha123',
        ])->assertOk();

        $this->assertTrue(Hash::check('NovaSenha123', $user->fresh()->password));
    }

    public function test_administrador_pode_trocar_senha_e_revogar_sessoes(): void
    {
        $user = User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => 'Senha1234',
            'is_admin' => true,
        ]);
        $token = $user->createToken('api-token')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->putJson('/api/admin/senha', [
                'current_password' => 'Senha1234',
                'password' => 'SenhaNova123',
                'password_confirmation' => 'SenhaNova123',
            ])->assertOk();

        $this->assertTrue(Hash::check('SenhaNova123', $user->fresh()->password));
        $this->assertCount(0, $user->fresh()->tokens);
    }
}
