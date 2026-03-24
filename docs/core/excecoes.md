# Tratamento de Erros e Exceções

O ZyoPHP possui um sistema centralizado para capturar e processar erros do PHP e exceções não tratadas.

## ExceptionHandler (`Zyo\Core\ExceptionHandler`)

Esta classe é responsável por decidir como um erro deve ser exibido ao usuário e como deve ser logado.

### Ambientes

- **Desenvolvimento (`APP_DEBUG=true`)**: Exibe uma página de erro detalhada, incluindo o Stack Trace, a linha exata do erro e informações da requisição.
- **Produção (`APP_DEBUG=false`)**: Exibe uma página amigável (ex: erro 500 personalizado) sem expor detalhes sensíveis do código.

## Exceções HTTP

O framework fornece classes para erros comuns da Web:

- `NotFoundException`: Disparada quando uma rota não é encontrada (Erro 404).
- `ForbiddenException`: Disparada quando o acesso é negado (Erro 403).

## Registro de Logs

Todos os erros capturados são registrados automaticamente em `storage/logs/error.log`.

## Customização de Páginas de Erro

Para personalizar o que o usuário vê, edite os templates Blade em:
- `app/Resources/views/errors/404.blade.php`
- `app/Resources/views/errors/500.blade.php`
