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
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
php artisan serve
```

Configure o MySQL no `.env` antes das migrations. A API ficará disponível em `http://localhost:8000/api`.

## Produção

- Domínio da API: `https://guardianshipcouncil.x10.mx/`
- Frontend autorizado no CORS: `https://siteconselhotutelar.vercel.app/`
- Use `.env.production.example` como base para o ambiente de produção
- O servidor precisa rodar PHP 8.2 ou superior, compatível com Laravel 12
- Após configurar o servidor, execute `php artisan storage:link` para servir imagens públicas corretamente
- O `APP_URL` precisa apontar para o domínio da API para gerar links de `storage` e URLs absolutas corretas
