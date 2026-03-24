# Core — `Zyo\Core`

Coração do framework: inicialização, container de DI e ciclo de vida.

## Arquivos

| Arquivo | Classe | Descrição |
|---------|--------|-----------|
| `App.php` | `Zyo\Core\App` | Singleton, container DI, bootstrap |
| `Kernel.php` | `Zyo\Core\Kernel` | Ciclo de vida da requisição |
| `ServiceProvider.php` | `Zyo\Core\ServiceProvider` | Base para registro de serviços |
| `bootstrap.php` | — | Inicialização do framework |

## App

Singleton principal — container de DI (PSR-11).

```php
$app = App::getInstance();
$app->setBasePath(BASE_PATH);

// Container
$app->bind(MyService::class, fn() => new MyService());
$app->singleton(Database::class, fn() => new Database(config('database')));
$app->get(Database::class);
$app->has(Database::class); // true
```

## Kernel

Ciclo de vida: Request → Middlewares → Router → Controller → Response.

```php
$kernel = new Kernel($app);
$response = $kernel->handle($request);
$response->send();
```

## ServiceProvider

```php
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PaymentGateway::class, fn() => new StripeGateway());
    }

    public function boot(): void {}
}
```

## Ciclo de Vida

Para entender como uma requisição é processada do início ao fim, consulte o guia detalhado:
👉 **[Ciclo de Vida da Requisição](ciclo-de-vida.md)**

