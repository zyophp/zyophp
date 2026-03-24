# ZyoPHP Microframework

Microframework PHP MVC moderno, leve e seguro, construído com foco em separação de preocupações e facilidade de uso.

## ✨ Características

- **Arquitetura MVC Clean**: Separação total entre framework e aplicação.
- **Roteamento Poderoso**: Suporte a parâmetros dinâmicos, grupos e middlewares.
- **Blade Engine**: Utilize o poder dos templates Blade (Laravel).
- **Segurança Nativa**: Proteção CSRF, sanitização de inputs e headers de segurança.
- **Container de DI**: Injeção de dependências automática e Service Providers (PSR-11).
- **Active Record**: Modelagem de dados simples e intuitiva.

## 🚀 Início Rápido

### Requisitos
- PHP >= 8.4
- Composer

### Instalação
```bash
composer install
```

### Configuração
1. Copie o arquivo de exemplo: `cp .env.example .env`
2. Configure suas credenciais no `.env`.

### Rodando o Servidor
```bash
php bin/zyo serve
```

## 📂 Estrutura do Projeto

- `src/`: O "coração" do Microframework (Namespace `Zyo\`).
- `app/`: O código da sua aplicação (Namespace `App\`).
- `public/`: Único diretório acessível publicamente (Front Controller).
- `docs/`: Documentação técnica detalhada.

## 📚 Documentação

Para guias detalhados, consulte a pasta [docs/](docs/README.md):
- [Arquitetura](docs/arquitetura.md)
- [Ciclo de Vida](docs/ciclo-de-vida.md)
- [Roteamento](docs/routing/roteamento.md)
- [Segurança](docs/security/security.md)

## 📄 Licença

Este projeto está sob a licença MIT.
