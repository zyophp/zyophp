# ZyoPHP — Roadmap de Construção do Microframework MVC

> Microframework PHP com Composer, PSR-4, Blade Views, Segurança, Roteamento, Controllers e Models.

---

## Arquitetura: Separação Framework × Aplicação

O projeto usa **dois repositórios/pacotes** independentes:

| Camada        | Namespace | Diretório | Descrição                                               |
| ------------- | --------- | --------- | ------------------------------------------------------- |
| **Framework** | `Zyo\`    | `src/`    | Código reutilizável do framework (kernel, router, etc.) |
| **Aplicação** | `App\`    | `app/`    | Código do usuário (controllers, models, views, rotas)   |

```
zyophp/
│
├── src/                          # 🔧 FRAMEWORK (pacote Zyo)
│   ├── Core/                     #    Kernel, App, Container, ServiceProvider
│   ├── Http/                     #    Request, Response
│   ├── Routing/                  #    Router, Route, RouteGroup
│   ├── Controller/               #    BaseController
│   ├── Model/                    #    BaseModel, Database, QueryBuilder
│   ├── View/                     #    BladeEngine (wrapper)
│   ├── Security/                 #    CSRF, Auth, Validator, Middleware
│   └── Support/                  #    Helpers, Config, Session, Env
│
├── app/                          # 👤 APLICAÇÃO (código do usuário)
│   ├── Controllers/              #    HomeController, UserController...
│   ├── Models/                   #    User, Post...
│   ├── Middlewares/              #    AuthMiddleware, GuestMiddleware...
│   ├── Providers/                #    AppServiceProvider...
│   ├── Config/                   #    ⚙️ Configurações (app, database, security)
│   ├── Resources/                #    🎨 Assets e Views
│   │   └── views/
│   │       ├── layouts/
│   │       │   └── app.blade.php
│   │       ├── home.blade.php
│   │       └── errors/
│   │           ├── 404.blade.php
│   │           └── 500.blade.php
│   └── Database/                 #    🗄️ Migrations e Seeds
│       ├── migrations/
│       └── seeds/
│
├── routes/                       # 🛣️  Definição de rotas
│   ├── web.php
│   └── api.php
│
├── storage/                      # 📦 Cache, Logs, Views compiladas
│   ├── cache/
│   ├── logs/
│   └── views/
│
├── public/                       # 🌐 Document Root
│   ├── index.php                 #    Front controller
│   ├── .htaccess
│   └── assets/
│
├── tests/                        # 🧪 Testes
│   ├── Framework/                #    Testes do framework
│   └── App/                      #    Testes da aplicação
│
├── bin/                          # 🖥️  CLI
│   └── zyo
│
├── docs/                         # 📚 Documentação
├── composer.json
├── .env.example
├── .env
└── .gitignore
```

**composer.json — Autoload:**

```json
{
  "autoload": {
    "psr-4": {
      "Zyo\\": "src/",
      "App\\": "app/"
    },
    "files": ["src/Support/helpers.php"]
  }
}
```

---

## Fase 1 — Estrutura Base do Projeto ✅

- [x] Inicializar o projeto com `composer init`
- [x] Configurar autoload PSR-4 duplo: `Zyo\` → `src/` e `App\` → `app/`
- [x] Criar toda a árvore de diretórios (framework + aplicação)
- [x] Criar `public/index.php` (front controller)
- [x] Criar `.htaccess` para Apache (rewrite)
- [x] Criar `.gitignore` (vendor, .env, storage/views, storage/logs)

---

## Fase 2 — Kernel e Container de Dependências _(Framework)_

- [ ] Criar `Zyo\Core\App` — singleton, bootstrap da aplicação
- [ ] Implementar Container de DI simples (PSR-11 compatível)
- [ ] Criar `Zyo\Core\Kernel` — ciclo de vida: boot → request → response
- [ ] Criar `Zyo\Core\ServiceProvider` — classe base para registrar serviços
- [ ] Registrar bindings padrão (Router, Request, Response, Config)
- [ ] Carregar configurações de `config/*.php`

---

## Fase 3 — HTTP — Request e Response _(Framework)_

- [ ] `Zyo\Http\Request` — encapsula superglobais (`$_GET`, `$_POST`, `$_SERVER`, `$_FILES`)
  - Métodos: `input()`, `query()`, `method()`, `path()`, `isMethod()`, `header()`, `file()`
  - Sanitização automática de inputs
- [ ] `Zyo\Http\Response`
  - Métodos: `json()`, `redirect()`, `status()`, `header()`, `send()`
  - Suporte a status codes HTTP

---

## Fase 4 — Sistema de Roteamento _(Framework)_

- [ ] `Zyo\Routing\Router`
  - Métodos HTTP: `GET`, `POST`, `PUT`, `PATCH`, `DELETE`
  - Closures e referência a controllers (`Controller@method`)
  - Parâmetros dinâmicos (`/users/{id}`) e opcionais (`/posts/{slug?}`)
  - Regex para parâmetros (`->where('id', '[0-9]+')`)
  - Grupos com prefixo e middleware
  - Rotas nomeadas (`->name('users.show')`)
- [ ] `Zyo\Routing\Route` — representação individual de rota
- [ ] Dispatcher — resolve rota e invoca handler

### Aplicação:

- [ ] Criar `routes/web.php` com rotas de exemplo
- [ ] Criar `routes/api.php` com prefixo `/api`

---

## Fase 5 — Controllers

### Framework:

- [ ] `Zyo\Controller\BaseController`
  - Injeção de dependências automática
  - Helpers: `view()`, `json()`, `redirect()`
  - Suporte a middlewares por controller (`$middlewares`)

### Aplicação:

- [ ] `App\Controllers\HomeController` — controller de exemplo
- [ ] `App\Controllers\UserController` — CRUD de exemplo

---

## Fase 6 — Views com Blade

### Framework:

- [ ] Instalar `jenssegers/blade` via Composer
- [ ] `Zyo\View\BladeEngine` — wrapper de configuração
- [ ] Diretórios: views em `resources/views/`, cache em `storage/views/`
- [ ] Suporte: `@extends`, `@section`, `@yield`, `@include`
- [ ] Variáveis: `{{ $var }}` (escaped) e `{!! $var !!}` (raw)
- [ ] Helper global `view($template, $data)`

### Aplicação:

- [ ] `resources/views/layouts/app.blade.php` — layout base
- [ ] `resources/views/home.blade.php` — página inicial
- [ ] `resources/views/errors/404.blade.php`
- [ ] `resources/views/errors/500.blade.php`

---

## Fase 7 — Models e Banco de Dados

### Framework:

- [ ] `Zyo\Model\Database` — conexão PDO singleton
- [ ] `Zyo\Model\QueryBuilder` — query builder fluente
  - `select()`, `where()`, `orderBy()`, `limit()`, `join()`
  - `get()`, `first()`, `count()`, `insert()`, `update()`, `delete()`
  - Prepared statements obrigatórios
- [ ] `Zyo\Model\BaseModel` — Active Record simples
  - Props: `$table`, `$fillable`, `$hidden`
  - Métodos: `find()`, `all()`, `create()`, `update()`, `delete()`, `toArray()`, `toJson()`

### Aplicação:

- [ ] `App\Models\User` — model de exemplo
- [ ] `config/database.php` — configuração de conexão

---

## Fase 8 — Middlewares

### Framework:

- [ ] `Zyo\Security\MiddlewareInterface` — `handle(Request, Closure)`
- [ ] Pipeline de middlewares (chain of responsibility)
- [ ] Suporte: global, por grupo, por rota

### Aplicação:

- [ ] `App\Middlewares\AuthMiddleware`
- [ ] `App\Middlewares\GuestMiddleware`
- [ ] Registrar middlewares no kernel

---

## Fase 9 — Segurança

### 9.1 — CSRF _(Framework)_

- [ ] `Zyo\Security\CsrfProtection` — gerar/validar tokens
- [ ] Middleware `VerifyCsrfToken`
- [ ] Diretiva Blade `@csrf`
- [ ] Exclusão de rotas (webhooks)

### 9.2 — Autenticação _(Framework + Aplicação)_

- [ ] `Zyo\Security\Auth` — `password_hash`/`password_verify`, sessões seguras
- [ ] Métodos: `user()`, `check()`, `login()`, `logout()`
- [ ] `App\Middlewares\AuthMiddleware` — proteger rotas
- [ ] `App\Middlewares\GuestMiddleware` — rotas públicas

### 9.3 — Validação _(Framework)_

- [ ] `Zyo\Security\Validator`
- [ ] Regras: `required`, `string`, `integer`, `email`, `min`, `max`, `unique`, `confirmed`
- [ ] Erros formatados + integração com controllers (`validate()`)

### 9.4 — Headers de Segurança _(Framework)_

- [ ] Middleware `SecurityHeaders`
  - `X-Content-Type-Options`, `X-Frame-Options`, `X-XSS-Protection`
  - `Referrer-Policy`, `Content-Security-Policy`

---

## Fase 10 — Sessões e Flash Messages _(Framework)_

- [ ] `Zyo\Support\Session` — `get()`, `set()`, `has()`, `forget()`, `flash()`, `getFlash()`
- [ ] Flash messages (success, error, warning, info)
- [ ] Integração com Blade para exibir mensagens

---

## Fase 11 — Tratamento de Erros _(Framework + Aplicação)_

### Framework:

- [ ] `Zyo\Core\ExceptionHandler` — handler global
- [ ] Modo dev: stack trace detalhado
- [ ] Modo prod: páginas de erro amigáveis
- [ ] Logging em `storage/logs/error.log`
- [ ] Exceções HTTP: `NotFoundException`, `ForbiddenException`

### Aplicação:

- [ ] Views de erro: `resources/views/errors/404.blade.php`, `500.blade.php`

---

## Fase 12 — Helpers _(Framework)_

- [ ] `src/Support/helpers.php` — funções globais:
  - `app()`, `config()`, `view()`, `redirect()`, `route()`
  - `csrf_token()`, `old()`, `dd()`, `dump()`, `env()`
- [ ] Registrar no Composer (`"files": ["src/Support/helpers.php"]`)

---

## Fase 13 — Variáveis de Ambiente

- [ ] Instalar `vlucas/phpdotenv`
- [ ] Criar `.env.example` com variáveis padrão
- [ ] Carregar `.env` no bootstrap
- [ ] Proteger `.env` no `.gitignore`

---

## Fase 14 — CLI _(Opcional / Framework)_

- [ ] `bin/zyo` — entry point CLI
- [ ] Comandos:
  - `zyo serve` — servidor embutido PHP
  - `zyo make:controller Nome`
  - `zyo make:model Nome`
  - `zyo clear:cache`
  - `zyo routes:list`

---

## Fase 15 — Testes - Opitional

### Framework (`tests/Framework/`):

- [ ] Instalar PHPUnit (`--dev`)
- [ ] Testes: Router, Request/Response, QueryBuilder, Validator, CSRF

### Aplicação (`tests/App/`):

- [ ] Testes de integração: rota → controller → view
- [ ] Testes dos models da aplicação

---

## Fase 16 — Documentação

- [ ] `README.md` — visão geral, instalação, uso rápido
- [ ] `docs/` — documentação por componente
- [ ] Exemplos de código
- [ ] `CONTRIBUTING.md`

---

## Ordem de Implementação Recomendada

```
Fase 1  → Estrutura Base (framework + app)
Fase 2  → Kernel e Container
Fase 13 → Variáveis de Ambiente (.env)
Fase 3  → HTTP (Request/Response)
Fase 4  → Roteamento
Fase 5  → Controllers
Fase 6  → Views (Blade)
Fase 7  → Models e Banco de Dados
Fase 8  → Middlewares
Fase 9  → Segurança (CSRF, Auth, Validação, Headers)
Fase 10 → Sessões e Flash Messages
Fase 11 → Erros e Exceções
Fase 12 → Helpers
Fase 14 → CLI (Opcional)
Fase 15 → Testes
Fase 16 → Documentação
```

---

> **Princípio**: O código em `src/` (namespace `Zyo\`) é o framework — genérico, reutilizável, nunca depende de `App\`.
> O código em `app/` (namespace `App\`) é a aplicação — específico do projeto, depende de `Zyo\`.
