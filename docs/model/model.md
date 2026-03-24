# Model — `Zyo\Model`

Acesso a banco de dados: Active Record e QueryBuilder.

## Arquivos

| Arquivo | Classe | Descrição |
|---------|--------|-----------|
| `Database.php` | `Zyo\Model\Database` | Conexão PDO singleton |
| `QueryBuilder.php` | `Zyo\Model\QueryBuilder` | Query builder fluente |
| `BaseModel.php` | `Zyo\Model\BaseModel` | Active Record base |

## BaseModel

```php
namespace App\Models;

use Zyo\Model\BaseModel;

class User extends BaseModel
{
    protected string $table = 'users';
    protected array $fillable = ['name', 'email', 'password'];
    protected array $hidden = ['password'];
}
```

## CRUD

```php
User::all();
User::find(1);
User::create(['name' => 'João', 'email' => 'joao@email.com']);
$user->update(['name' => 'João Silva']);
$user->delete();
```

## QueryBuilder

```php
$db->table('users')
    ->select('id', 'name')
    ->where('active', '=', 1)
    ->orderBy('name', 'ASC')
    ->limit(10)
    ->get();

$db->table('users')->where('email', '=', 'x@x.com')->first();
$db->table('users')->count();

$db->table('posts')
    ->join('users', 'posts.user_id', '=', 'users.id')
    ->get();
```

## Segurança

- **Prepared statements** (SQL Injection)
- `$fillable` (mass assignment)
- `$hidden` (serialização)

## Aplicação

Models do usuário: `app/Models/*.php` (`App\Models\`), config em `app/Config/database.php`
