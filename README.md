# OrçaLink

OrçaLink é um SaaS B2C para freelancers criarem, enviarem e acompanharem
orçamentos por meio de links compartilháveis. O produto transforma a criação
de propostas em um fluxo simples: cadastrar itens, enviar o orçamento ao
cliente e acompanhar a resposta sem depender de planilhas ou documentos
avulsos.

> **Status:** MVP funcional. As cinco fases atuais do roadmap estão
> implementadas e a suíte existente registra 36 testes aprovados.

## Funcionalidades atuais

- Autenticação, registro, verificação de e-mail, recuperação de senha e
  gerenciamento de perfil.
- Dashboard com indicadores de orçamentos e controle de plano do usuário.
- Criação, edição, visualização e exclusão de orçamentos.
- Itens de orçamento dinâmicos, com descrição, quantidade e preço.
- Validação de dados e preservação dos itens preenchidos quando há erros no
  formulário.
- Geração de links públicos para compartilhar orçamentos com clientes.
- Visualização pública sem autenticação, com registro de visualização.
- Aprovação ou rejeição do orçamento pelo cliente.
- Ciclo de vida de status com transições controladas: rascunho, enviado,
  visualizado, aprovado, rejeitado e expirado.
- Data de expiração e comando Artisan para expirar orçamentos vencidos.
- Limite de criação de orçamentos aplicado por middleware conforme o plano.
- Landing page e configuração de deploy em Docker.

## Arquitetura

O projeto é uma aplicação monolítica Laravel com views renderizadas no
servidor. A organização principal é:

```text
app/
├── Console/Commands/       # Comandos Artisan, incluindo expiração
├── Enums/                  # Estados do orçamento
├── Http/
│   ├── Controllers/        # Fluxos autenticados e públicos
│   ├── Middleware/         # Regras como limite de orçamentos
│   └── Requests/           # Validação de entrada
├── Models/                 # User, Quote e QuoteItem
└── View/Components/        # Layouts Blade reutilizáveis

database/
├── factories/              # Dados para testes e desenvolvimento
├── migrations/             # Schema da aplicação
└── seeders/                # Dados iniciais

resources/
├── js/                     # Bootstrap, Alpine.js e comportamento de quotes
├── css/                    # Tailwind CSS
└── views/                  # Templates Blade, layouts e componentes

routes/
├── web.php                 # Rotas da aplicação e dos orçamentos
└── auth.php                # Rotas de autenticação
```

O fluxo principal usa `QuoteController` para as operações autenticadas e
`PublicQuoteController` para a experiência do cliente. `QuoteStatus` concentra
as regras de transição de estado, enquanto `CheckQuoteLimit` protege a criação
de novos orçamentos.

## Stack

- PHP `^8.3` (o ambiente de deploy usa PHP 8.5)
- Laravel `^13.17`
- Laravel Breeze para autenticação
- Blade, Alpine.js e Tailwind CSS v4
- Vite para assets frontend
- SQLite como banco padrão local
- Pest 4 para testes
- Laravel Pint e Larastan para qualidade de código
- Docker para execução em ambiente de deploy

## Requisitos

- PHP 8.3 ou superior
- Composer
- Node.js e npm
- SQLite e a extensão `pdo_sqlite` do PHP

## Instalação

Clone o repositório e entre no diretório do projeto:

```bash
git clone https://github.com/p-v-dev/OrcaSim.git
cd OrcaSim
```

O script de setup instala as dependências, cria o ambiente local, gera a
chave da aplicação, executa as migrations, instala os pacotes frontend e
compila os assets:

```bash
composer run setup
```

Para configurar manualmente, copie `.env.example` para `.env`, ajuste as
variáveis necessárias e execute:

```bash
composer install
php artisan key:generate
php artisan migrate
npm install
npm run build
```

O projeto usa SQLite por padrão. O arquivo de banco local fica em
`database/database.sqlite`.

## Execução local

Para iniciar o servidor Laravel e o Vite em paralelo:

```bash
composer run dev
```

Alternativamente, execute cada processo separadamente:

```bash
php artisan serve
npm run dev
```

## Testes e qualidade

Execute a suíte completa, incluindo a verificação de formatação:

```bash
composer test
```

Para executar apenas os testes Laravel:

```bash
php artisan test --compact
```

Comandos úteis de qualidade:

```bash
composer lint
composer lint:check
vendor/bin/phpstan analyse
```

## Docker

A imagem de produção usa PHP 8.5 com SQLite e executa as otimizações de
configuração, rotas e views durante o build:

```bash
docker build -t orcalink .
docker run --rm -p 8000:8000 -e PORT=8000 orcalink
```

## Roadmap e próximos passos

Os itens abaixo **não fazem parte do MVP atual** e estão planejados para as
próximas iterações:

1. **Analytics no dashboard:** corrigir os agrupamentos atuais de status e
   adicionar gráficos de volume, pendências, aprovações e rejeições ao longo
   do tempo.
2. **Envio de orçamento por e-mail:** enviar automaticamente o link ao
   cliente, oferecer reenvio sob demanda e permitir escolher entre e-mail e
   compartilhamento manual.
3. **Planos pagos com Stripe:** criar planos e checkout, processar webhooks,
   oferecer portal do cliente e substituir o limite gratuito por regras de
   assinatura.

A ordem prevista é corrigir os indicadores do dashboard, adicionar os
   gráficos, implementar o envio de e-mail e, por fim, integrar pagamentos.

## Licença

Este projeto está disponível sob a licença MIT.
