# View — `Zyo\View`

Engine de templates Blade.

## Arquivos

| Arquivo | Classe | Descrição |
|---------|--------|-----------|
| `BladeEngine.php` | `Zyo\View\BladeEngine` | Wrapper de configuração |

## Diretórios

- **Templates**: `app/Resources/views/`
- **Cache**: `storage/views/`

## Uso

```php
return $this->view('home', ['name' => 'João']);
return view('home', ['name' => 'João']);
```

## Layouts

```blade
{{-- layouts/app.blade.php --}}
<!DOCTYPE html>
<html>
<head><title>@yield('title', 'ZyoPHP')</title></head>
<body>@yield('content')</body>
</html>
```

```blade
{{-- home.blade.php --}}
@extends('layouts.app')
@section('title', 'Início')
@section('content')
    <h1>{{ $name }}</h1>
@endsection
```

## Variáveis

```blade
{{ $var }}      {{-- escape automático --}}
{!! $var !!}   {{-- raw HTML --}}
```

## Controle

```blade
@if($x) ... @else ... @endif
@foreach($items as $item) ... @endforeach
@include('partials.alert', ['type' => 'success'])
```

## CSRF

```blade
<form method="POST">@csrf ...</form>
```
