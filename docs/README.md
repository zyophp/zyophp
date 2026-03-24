# ZyoPHP — Documentação

> Microframework PHP MVC leve e moderno.

[Visualizar Diagrama de Estrutura](diagrama.md)

## Camadas do Framework (`src/`)

| Camada | Descrição |
|--------|-----------|
| [core](core/core.md) | App, Kernel, Container, ServiceProvider |
| [ciclo de vida](core/ciclo-de-vida.md) | Fluxo detalhado da requisição HTTP |
| [exceções](core/excecoes.md) | Tratamento de erros, 404, 500, logging |
| [http](http/http.md) | Request, Response |
| [routing](routing/roteamento.md) | Router, Route, grupos, parâmetros |
| [controller](controller/controller.md) | BaseController, helpers |
| [model](model/model.md) | BaseModel, Database, QueryBuilder |
| [view](view/view.md) | BladeEngine, layouts, Blade |
| [security](security/security.md) | CSRF, Auth, Validator, Middlewares |
| [support](support/support.md) | Helpers, Session |
| [configuração](support/configuracao.md) | .env, config(), env() |
| [cli](support/cli.md) | Comandos make, serve, cache |

## Roadmap

- [TODO](TODO.md) — Checklist de construção
