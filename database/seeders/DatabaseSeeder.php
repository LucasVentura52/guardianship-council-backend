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
            [
                'titulo' => 'O que é o Conselho Tutelar?',
                'slug' => 'conselho-tutelar',
                'chamada' => 'Conheça nossa atuação',
                'resumo' => 'Órgão permanente e autônomo encarregado de zelar pelo cumprimento dos direitos da criança e do adolescente.',
                'icone' => 'users',
                'conteudo' => "## Proteção de direitos\nAtua quando direitos previstos no ECA são ameaçados ou violados, aplicando medidas de proteção e orientação.\n\n## Atendimento à comunidade\nAcolhe crianças, adolescentes, famílias e qualquer pessoa que procure orientação ou queira comunicar uma situação.\n\n## Trabalho em rede\nArticula serviços de saúde, educação, assistência social, segurança e Justiça para garantir proteção integral.\n\n## O que o Conselho faz\n- Atende e aconselha crianças, adolescentes, pais e responsáveis.\n- Aplica medidas de proteção previstas no ECA.\n- Requisita serviços públicos nas áreas de saúde, educação e assistência.\n- Encaminha situações ao Ministério Público e à Justiça quando necessário.\n\n## Importante saber\nO Conselho Tutelar não substitui a família, a escola, a polícia ou o Judiciário. Seu papel é garantir que todos cumpram suas responsabilidades.",
                'status' => 'publicado',
                'created_at' => $agora,
                'updated_at' => $agora,
            ],
            [
                'titulo' => 'Estatuto da Criança e do Adolescente',
                'slug' => 'eca',
                'chamada' => 'Lei nº 8.069/1990',
                'resumo' => 'O ECA reconhece crianças e adolescentes como sujeitos de direitos e estabelece a responsabilidade compartilhada por sua proteção integral.',
                'icone' => 'book',
                'conteudo' => "## Prioridade absoluta\nCrianças e adolescentes devem receber proteção e atendimento prioritários.\n\n## Proteção integral\nTodos os direitos fundamentais devem ser garantidos sem discriminação.\n\n## Responsabilidade compartilhada\nFamília, sociedade e Estado atuam juntos na garantia dos direitos.\n\n## Quem o ECA protege?\nConsidera-se criança a pessoa com até 12 anos incompletos e adolescente aquela entre 12 e 18 anos. Em situações previstas em lei, o Estatuto também se aplica a pessoas entre 18 e 21 anos.",
                'status' => 'publicado',
                'created_at' => $agora,
                'updated_at' => $agora,
            ],
            [
                'titulo' => 'Direitos da Criança e do Adolescente',
                'slug' => 'direitos',
                'chamada' => 'ECA na prática',
                'resumo' => 'Conheça os direitos fundamentais para um desenvolvimento digno, saudável e seguro.',
                'icone' => 'heart',
                'conteudo' => "## Direito à Vida e à Saúde\nToda criança e adolescente tem direito à vida e à saúde, mediante políticas sociais públicas.\n\n## Direito à Educação\nAcesso à educação de qualidade para o pleno desenvolvimento da pessoa.\n\n## Convivência Familiar e Comunitária\nDireito de conviver com sua família e comunidade em ambiente saudável e seguro.\n\n## Direito ao Respeito\nProteção contra negligência, discriminação, exploração e violência.\n\n## Liberdade e Dignidade\nLiberdade, respeito e dignidade como pessoas em desenvolvimento.",
                'status' => 'publicado',
                'created_at' => $agora,
                'updated_at' => $agora,
            ],
            [
                'titulo' => 'Como Acionar o Conselho Tutelar',
                'slug' => 'como-acionar',
                'chamada' => 'Busque orientação',
                'resumo' => 'Procure o Conselho sempre que os direitos de uma criança ou adolescente estiverem ameaçados ou violados.',
                'icone' => 'phone',
                'conteudo' => "## Em quais situações acionar?\n- Violência física ou psicológica\n- Abuso sexual\n- Negligência e abandono\n- Trabalho infantil\n- Uso de drogas\n- Discriminação\n- Evasão escolar\n- Outras violações de direitos\n\n## Antes de entrar em contato\nReúna as informações disponíveis sobre a situação. Não é necessário ter provas para pedir orientação ou comunicar uma suspeita.",
                'status' => 'publicado',
                'created_at' => $agora,
                'updated_at' => $agora,
            ],
            [
                'titulo' => 'Perguntas Frequentes',
                'slug' => 'faq',
                'chamada' => 'Tire suas dúvidas',
                'resumo' => 'Respostas objetivas sobre atendimento, denúncias e atuação do Conselho Tutelar.',
                'icone' => 'info',
                'conteudo' => "## O atendimento do Conselho Tutelar é gratuito?\nSim. Todo atendimento e orientação prestados pelo Conselho Tutelar são gratuitos.\n\n## Preciso me identificar para fazer uma denúncia?\nO Disque 100 aceita denúncias anônimas. No atendimento local, seus dados são tratados com sigilo.\n\n## O Conselho Tutelar pode retirar uma criança da família?\nO acolhimento institucional é uma medida excepcional. O Conselho atua conforme o ECA e comunica as autoridades competentes.\n\n## Qual a diferença entre Conselho Tutelar e Polícia?\nO Conselho aplica medidas de proteção e requisita serviços. A polícia atua na segurança pública e investigação de crimes.\n\n## Quando devo ligar para o 190?\nQuando houver risco imediato, violência em andamento ou uma emergência que exija intervenção policial.",
                'status' => 'publicado',
                'created_at' => $agora,
                'updated_at' => $agora,
            ],
            [
                'titulo' => 'Fale Conosco',
                'slug' => 'contato',
                'chamada' => 'Estamos aqui para orientar',
                'resumo' => 'Envie sua mensagem ou utilize um dos canais de atendimento. Em emergências, procure os serviços de segurança.',
                'icone' => 'email',
                'conteudo' => "## Envie uma mensagem\nUse o formulário para dúvidas, orientações ou propostas de parceria.\n\n## Privacidade\nAs mensagens recebidas são acessíveis apenas aos administradores autorizados da plataforma.",
                'status' => 'publicado',
                'created_at' => $agora,
                'updated_at' => $agora,
            ],
        ], ['slug'], ['titulo', 'chamada', 'resumo', 'icone', 'conteudo', 'status', 'updated_at']);

        Pagina::whereIn('slug', ['sobre-o-conselho-tutelar', 'sobre-o-eca'])->delete();

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
        Configuracao::updateOrCreate(['chave' => 'cidade_uf'], ['valor' => 'Sua Cidade - UF']);
        Configuracao::updateOrCreate(['chave' => 'disque_100_texto'], ['valor' => 'Atendimento gratuito, confidencial e disponível 24 horas.']);
        Configuracao::updateOrCreate(['chave' => 'emergencia_texto'], ['valor' => 'Em situação de perigo imediato ou violência em andamento, ligue para a Polícia Militar pelo 190.']);
        Configuracao::updateOrCreate(['chave' => 'facebook_url'], ['valor' => null]);
        Configuracao::updateOrCreate(['chave' => 'instagram_url'], ['valor' => null]);
        Configuracao::updateOrCreate(['chave' => 'youtube_url'], ['valor' => null]);
    }
}
