# HTTP — `Zyo\Http`

Abstração de requisições e respostas HTTP.

## Arquivos

| Arquivo | Classe | Descrição |
|---------|--------|-----------|
| `Request.php` | `Zyo\Http\Request` | Encapsula superglobais |
| `Response.php` | `Zyo\Http\Response` | Constrói e envia respostas |

## Request

```php
// Dados de entrada
$name  = $request->input('name');           // POST ou GET
$page  = $request->query('page', 1);        // Só GET
$token = $request->header('Authorization');
$file  = $request->file('avatar');

// Informações
$request->method();          // GET, POST, PUT...
$request->path();            // /users/1
$request->isMethod('POST');  // true/false

// Subsets
$request->only(['name', 'email']);
$request->except(['password']);
```

Inputs sanitizados automaticamente contra XSS.

## Response

```php
// HTML
$response = new Response('<h1>Hello</h1>', 200);
$response->send();

// JSON
return Response::json(['users' => $users], 200);

// Redirect
return Response::redirect('/dashboard');

// Headers
$response->header('X-Custom', 'value');
$response->status(201);
```
