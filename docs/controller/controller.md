# Controller — `Zyo\Controller`

Classe base para controllers da aplicação.

## Arquivos

| Arquivo | Classe | Descrição |
|---------|--------|-----------|
| `BaseController.php` | `Zyo\Controller\BaseController` | Classe base com helpers |

## Uso

```php
namespace App\Controllers;

use Zyo\Controller\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        return $this->view('home', ['title' => 'ZyoPHP']);
    }
}
```

## Helpers

```php
$this->view('template', ['key' => 'value']);   // Blade
$this->json(['status' => 'ok'], 200);          // JSON
$this->redirect('/dashboard');                  // Redirect
$this->validate($request, [                    // Validação
    'name' => 'required|string|min:3',
]);
```

## Middlewares por Controller

```php
class AdminController extends BaseController
{
    protected array $middlewares = ['auth'];
}
```

## Injeção de Dependências

```php
class UserController extends BaseController
{
    public function __construct(private Database $db) {}
}
```

## Aplicação

Controllers do usuário: `app/Controllers/*.php` (`App\Controllers\`)
