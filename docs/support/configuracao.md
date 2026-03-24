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

## Arquivos de Configuração (`app/Config/`)

As configurações permanentes da aplicação ficam em pastas dentro de `app/Config/`. Elas geralmente consomem os valores do `.env`.

Exemplo `app/Config/database.php`:
```php
return [
    'host' => env('DB_HOST', '127.0.0.1'),
    'user' => env('DB_USER', 'root'),
];
```

### Helper `config()`
Use esta função para acessar qualquer configuração usando a sintaxe de "ponto":
```php
// Busca o arquivo 'database.php' e a chave 'host' dentro dele
$host = config('database.host');

// Com valor padrão caso não exista
$timezone = config('app.timezone', 'UTC');
```

## Cache de Configuração

Em produção, o framework pode carregar todas as configurações em um único arquivo de cache para melhorar a performance.
