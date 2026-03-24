# Routing — `Zyo\Routing`

Sistema de roteamento: resolve URLs para handlers.

## Arquivos

| Arquivo | Classe | Descrição |
|---------|--------|-----------|
| `Router.php` | `Zyo\Routing\Router` | Registro e resolução de rotas |
| `Route.php` | `Zyo\Routing\Route` | Representação de uma rota |

## Uso

```php
// routes/web.php
$router->get('/', fn() => view('home'));
$router->get('/users', 'UserController@index');
$router->post('/users', 'UserController@store');
$router->put('/users/{id}', 'UserController@update');
$router->delete('/users/{id}', 'UserController@destroy');
```

## Parâmetros

```php
$router->get('/users/{id}', 'UserController@show');           // obrigatório
$router->get('/posts/{slug?}', 'PostController@show');         // opcional
$router->get('/users/{id}', 'UserController@show')
       ->where('id', '[0-9]+');                                // regex
```

## Rotas Nomeadas

```php
$router->get('/users/{id}', 'UserController@show')->name('users.show');
route('users.show', ['id' => 1]); // /users/1
```

## Grupos

```php
$router->group(['prefix' => '/admin', 'middleware' => ['auth']], function ($router) {
    $router->get('/dashboard', 'AdminController@dashboard');
});
```

## API (`routes/api.php`)

Prefixo `/api` automático.
