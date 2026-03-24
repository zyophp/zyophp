# Interface de Linha de Comando (CLI)

O ZyoPHP fornece uma ferramenta de linha de comando para automatizar tarefas comuns de desenvolvimento.

## Uso Básico

A ferramenta está localizada em `bin/zyo`. Você pode executá-la usando:

```bash
php bin/zyo [comando] [opções]
```

## Comandos Disponíveis

### Servidor de Desenvolvimento
Inicia o servidor embutido do PHP configurado para o framework.
```bash
php bin/zyo serve
```

### Geradores (Scaffolding)
Cria arquivos base para acelerar o desenvolvimento.

- **Controller**:
  ```bash
  php bin/zyo make:controller UserController
  ```
- **Model**:
  ```bash
  php bin/zyo make:model Product
  ```

### Manutenção
- **Limpar Cache**: Remove os arquivos compilados das views Blade.
  ```bash
  php bin/zyo clear:cache
  ```
- **Listar Rotas**: Exibe todas as rotas registradas no sistema.
  ```bash
  php bin/zyo routes:list
  ```

## Extensão do CLI

Você pode registrar seus próprios comandos customizados criando classes que estendem a funcionalidade base do CLI e registrando-as no `AppServiceProvider`.
