# Backend Laravel

API REST da Plataforma Conselho Tutelar, construída com Laravel 12.

## Recursos

- Autenticação por token com Laravel Sanctum
- CRUD de campanhas, notícias, páginas e telefones úteis
- Moderação de sugestões e mensagens
- Upload e biblioteca de imagens
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
