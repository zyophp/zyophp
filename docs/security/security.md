# Security — `Zyo\Security`

Segurança: CSRF, autenticação, validação, middlewares e headers.

## Arquivos

| Arquivo | Classe | Descrição |
|---------|--------|-----------|
| `CsrfProtection.php` | `Zyo\Security\CsrfProtection` | Tokens CSRF |
| `Auth.php` | `Zyo\Security\Auth` | Autenticação |
| `Validator.php` | `Zyo\Security\Validator` | Validação de dados |
| `MiddlewareInterface.php` | `Zyo\Security\MiddlewareInterface` | Interface de middleware |
| `SecurityHeaders.php` | `Zyo\Security\SecurityHeaders` | Headers HTTP seguros |

## CSRF

```blade
<form method="POST">@csrf ...</form>
```

`VerifyCsrfToken` valida em POST/PUT/PATCH/DELETE. Excluir rotas via `$except`.

## Autenticação

```php
$auth->attempt($email, $password);
$auth->check();
$auth->user();
$auth->logout();
```

Sessões seguras: `session_regenerate_id()`, cookies `httponly`/`secure`/`samesite`.

## Validação

```php
$this->validate($request, [
    'name'  => 'required|string|min:3',
    'email' => 'required|email|unique:users',
]);
```

Regras: `required`, `string`, `integer`, `email`, `min`, `max`, `unique`, `confirmed`.

## Middlewares

```php
class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) return redirect('/login');
        return $next($request);
    }
}
```

Registro: global (Kernel), por grupo, por rota, por controller.

## Headers

`SecurityHeaders` adiciona: `X-Content-Type-Options`, `X-Frame-Options`, `X-XSS-Protection`, `Referrer-Policy`, `CSP`.

## Aplicação

Middlewares do usuário: `app/Middlewares/*.php` (`App\Middlewares\`)
