# Support — `Zyo\Support`

Helpers, sessão e utilitários.

## Arquivos

| Arquivo | Classe/Tipo | Descrição |
|---------|-------------|-----------|
| `helpers.php` | Funções | Funções globais |
| `Session.php` | `Zyo\Support\Session` | Gestão de sessão e flash messages |

## Helpers (`helpers.php`)

| Função | Descrição |
|--------|-----------|
| `app()` | Container da aplicação |
| `config($key, $default)` | Acessar configuração |
| `env($key, $default)` | Variável de ambiente |
| `view($tpl, $data)` | Renderizar Blade |
| `redirect($url)` | Redirecionar |
| `route($name, $params)` | URL por nome de rota |
| `csrf_token()` | Token CSRF atual |
| `old($field)` | Input anterior (flash) |
| `dd(...$vars)` | Dump & Die |
| `dump(...$vars)` | Dump |

Carregado via `composer.json` → `"files": ["src/Support/helpers.php"]`.

## Session

```php
$session->set('key', 'value');
$session->get('key', 'default');
$session->has('key');
$session->forget('key');

// Flash messages
$session->flash('success', 'Salvo com sucesso!');
$message = $session->getFlash('success');
```
