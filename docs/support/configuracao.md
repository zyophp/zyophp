# Configuração e Ambiente

O ZyoPHP utiliza um sistema flexível de configurações baseado em arquivos PHP e variáveis de ambiente.

## Variáveis de Ambiente (`.env`)

Valores que mudam entre máquinas (como credenciais de banco) devem ser armazenados no arquivo `.env` na raiz do projeto.

```env
DB_HOST=127.0.0.1
DB_PASSWORD=secret
```

### Helper `env()`
Use esta função para ler valores do `.env`:
```php
$dbHost = env('DB_HOST', 'localhost'); // Segundo parâmetro é o valor padrão
```

## Classe de Configuração (`Zyo\Support\Config`)

O framework utiliza a classe `Config` para gerenciar o carregamento e acesso aos dados de forma eficiente.

```php
use Zyo\Support\Config;

$config = new Config($app->configPath());

// Acessando valores
$appName = $config->get('app.name');
$debug = $config->get('app.debug', false); // Com default
```

### Helper `config()`

Para facilitar o acesso em qualquer lugar da aplicação, utilize a função global `config()`:

```php
// Busca o arquivo 'app.php' e a chave 'name'
$name = config('app.name');

// Configurações de banco (arquivo database.php)
$db = config('database.connections.mysql');
```

## Estrutura do Diretório `app/Config/`

Cada arquivo PHP dentro deste diretório deve retornar um `array` associativo. O nome do arquivo define o primeiro nível da chave de acesso.

- `app.php` → `config('app')`
- `database.php` → `config('database')`
- `services.php` → `config('services')`

