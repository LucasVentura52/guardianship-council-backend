<?php

namespace Database\Seeders;

use App\Models\Campanha;
use App\Models\Configuracao;
use App\Models\Noticia;
use App\Models\Pagina;
use App\Models\Sugestao;
use App\Models\TelefoneUtil;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@conselhotutelar.local'],
            ['name' => 'Administrador', 'password' => Hash::make('Admin1234'), 'is_admin' => true]
        );

        $agora = now();
        Pagina::upsert([
            ['titulo' => 'Sobre o Conselho Tutelar', 'slug' => 'sobre-o-conselho-tutelar', 'conteudo' => 'Órgão permanente e autônomo responsável por zelar pelos direitos de crianças e adolescentes.', 'status' => 'publicado', 'created_at' => $agora, 'updated_at' => $agora],
            ['titulo' => 'Sobre o ECA', 'slug' => 'sobre-o-eca', 'conteudo' => 'O Estatuto da Criança e do Adolescente estabelece a proteção integral e a prioridade absoluta.', 'status' => 'publicado', 'created_at' => $agora, 'updated_at' => $agora],
        ], ['slug'], ['titulo', 'conteudo', 'status', 'updated_at']);

        foreach ([
            ['Maio Laranja', 'maio-laranja', 'Combate ao abuso e à exploração sexual de crianças e adolescentes.'],
            ['Faça Bonito', 'faca-bonito', 'Proteja nossas crianças e adolescentes.'],
            ['Diga Não ao Trabalho Infantil', 'diga-nao-ao-trabalho-infantil', 'Toda criança merece brincar, estudar e sonhar.'],
        ] as [$titulo, $slug, $descricao]) {
            Campanha::updateOrCreate(['slug' => $slug], ['titulo' => $titulo, 'descricao_curta' => $descricao, 'conteudo' => $descricao, 'status' => 'publicado', 'destaque' => true, 'data_publicacao' => now()]);
        }

        foreach ([
            ['Ação educativa nas escolas', 'acao-educativa-nas-escolas'],
            ['Campanha mobiliza a comunidade', 'campanha-mobiliza-a-comunidade'],
            ['Rede de proteção realiza encontro', 'rede-de-protecao-realiza-encontro'],
        ] as [$titulo, $slug]) {
            Noticia::updateOrCreate(['slug' => $slug], ['titulo' => $titulo, 'resumo' => 'Atividade promove informação e fortalece a proteção integral.', 'conteudo' => 'O Conselho Tutelar realizou uma atividade aberta para orientar a comunidade.', 'status' => 'publicado', 'destaque' => true, 'data_publicacao' => now()]);
        }

        foreach ([
            ['Disque Direitos Humanos', '100', 'Canal nacional gratuito e confidencial.'],
            ['Polícia Militar', '190', 'Emergências e risco imediato.'],
        ] as [$titulo, $telefone, $descricao]) {
            TelefoneUtil::updateOrCreate(
                ['titulo' => $titulo],
                ['telefone' => $telefone, 'descricao' => $descricao, 'status' => 'publicado']
            );
        }

        Sugestao::firstOrCreate(['email' => 'comunidade@example.com'], ['nome' => 'Ana Paula', 'telefone' => null, 'assunto' => 'Atividade educativa', 'mensagem' => 'Sugiro uma roda de conversa sobre segurança digital.', 'status' => 'aprovada']);
        Configuracao::updateOrCreate(['chave' => 'nome_site'], ['valor' => 'Conselho Tutelar']);
        Configuracao::updateOrCreate(['chave' => 'telefone'], ['valor' => '(00) 1234-5678']);
        Configuracao::updateOrCreate(['chave' => 'email'], ['valor' => 'conselho@suacidade.gov.br']);
        Configuracao::updateOrCreate(['chave' => 'endereco'], ['valor' => 'Rua das Crianças, 123 - Centro']);
        Configuracao::updateOrCreate(['chave' => 'horario_atendimento'], ['valor' => 'Segunda a sexta, 8h às 17h']);
        Configuracao::updateOrCreate(['chave' => 'descricao'], ['valor' => 'Promovendo e defendendo os direitos de crianças e adolescentes.']);
    }
}
