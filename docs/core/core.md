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

A classe `App` é o singleton principal e herda diretamente de `Zyo\Core\Container`, o que significa que ela própria é o container de DI (PSR-11).

### Uso Básico

```php
$app = App::getInstance();
$app->setBasePath(BASE_PATH);

// Registro no Container
$app->bind(MyService::class, fn() => new MyService());

// Singleton
$app->singleton(Database::class, fn() => new Database(config('database')));

// Recuperação
$db = $app->get(Database::class);
$hasDb = $app->has(Database::class); // true
```

### Caminhos da Aplicação

O objeto `App` também gerencia os caminhos base do sistema, permitindo acessá-los via container ou métodos:
- `path.base`: `/`
- `path.config`: `/app/Config`
- `path.public`: `/public`
- `path.storage`: `/storage`


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

