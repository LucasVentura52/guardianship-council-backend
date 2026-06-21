# Backend Laravel

API REST da Plataforma Conselho Tutelar, construída com Laravel 12.

## Recursos

- Autenticação por token com Laravel Sanctum
- CRUD de campanhas, notícias, páginas e telefones úteis
- Moderação de sugestões e mensagens
- Upload e biblioteca de imagens
- Recuperação e alteração segura de senha administrativa
- Indicadores de acessos públicos e interações dos últimos sete dias
- Proteção dos dados pessoais nas respostas públicas
- Validação com Form Requests e respostas com API Resources
- Seed com administrador e conteúdo demonstrativo

## Instalação

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
php artisan serve
```

Configure o MySQL no `.env` antes das migrations. A API ficará disponível em `http://localhost:8000/api`.

## Recuperação de senha

Em desenvolvimento, `MAIL_MAILER=log` grava o link de redefinição em `storage/logs/laravel.log`.
Para enviar e-mails reais, configure `MAIL_MAILER=smtp` e as variáveis `MAIL_HOST`, `MAIL_PORT`,
`MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION` e `MAIL_FROM_ADDRESS`.

## Testes

Os testes usam SQLite em memória. Com `pdo_sqlite` habilitado, execute:

```bash
php vendor/bin/phpunit
```
