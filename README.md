# 🧪 Teste Técnico – Solução Laravel + Vue.js

Este projeto implementa um sistema simples de postagens, onde **apenas administradores** podem criar posts.
Desenvolvido com **Laravel 11**, **Vue 3**, **TailwindCSS** e **Laravel Sail (Docker)**.

---

## ⚙️ Funcionalidades

- Autenticação com Laravel Breeze
- Controle de acesso: apenas *admin* cria posts
- Relação `User hasMany Posts` / `Post belongsTo User`
- API REST:
  - `POST /api/posts` – Criação (somente admin)
  - `GET /api/posts?user_id=` – Listagem por usuário
- Frontend em Vue 3 (Vite)
  - `PostForm.vue` → formulário (admin)
  - `PostList.vue` → listagem com **scroll infinito** (mais posts carregados dinamicamente ao rolar a página)
- Interface responsiva com TailwindCSS

---

## 🚀 Execução com Sail

```bash
# Instalar dependências Laravel
docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html" laravelsail/php84-composer:latest composer install --ignore-platform-reqs

# Subir containers
./vendor/bin/sail up -d

# Instalar dependências frontend
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev

# Rodar migrations e seeders
./vendor/bin/sail artisan migrate --seed
```

---

## 👥 Usuários de Teste

| Tipo   | Email              | Senha    |
| ------ | ------------------ | -------- |
| Admin  | admin@example.com  | password |
| Leitor | reader@example.com | password |

> Apenas o admin verá o formulário de criação.

---

## 🧰 Stack

Laravel 11 · PHP 8.2 · Vue 3 · Vite · TailwindCSS · Docker (Sail)
