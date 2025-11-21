# Selynt Panel

<p align="center">
  <img src="https://i.ibb.co/MDgL17Kr/logo.png" alt="Selynt Panel Logo" width="200">
</p>

<p align="center">
  <strong>Painel web moderno para gerenciamento de processos</strong>
</p>

<p align="center">
  <a href="https://github.com/NullSablex/Selynt-Panel/releases">
    <img src="https://img.shields.io/github/v/release/NullSablex/Selynt-Panel?style=flat-square&color=blue" alt="Versão">
  </a>
  <a href="LICENSE">
    <img src="https://img.shields.io/badge/license-MIT-green?style=flat-square" alt="Licença MIT">
  </a>
  <a href="https://github.com/NullSablex/Selynt-Panel/actions">
    <img src="https://img.shields.io/github/actions/workflow/status/NullSablex/Selynt-Panel/ci.yml?style=flat-square&label=build" alt="Status do Build">
  </a>
  <img src="https://img.shields.io/badge/PHP-8.1+-purple?style=flat-square&logo=php" alt="PHP 8.1+">
  <img src="https://img.shields.io/badge/CodeIgniter-4-orange?style=flat-square&logo=codeigniter" alt="CodeIgniter 4">
</p>

<p align="center">
  <a href="#recursos">Recursos</a> •
  <a href="#screenshots">Screenshots</a> •
  <a href="#requisitos">Requisitos</a> •
  <a href="#instalação">Instalação</a> •
  <a href="#roadmap">Roadmap</a> •
  <a href="#licença">Licença</a>
</p>

---

> [!WARNING]
> O Selynt Panel ainda está em desenvolvimento ativo. Podem ocorrer pequenas falhas ou inconsistências visuais que não afetam o funcionamento operacional do painel. Melhorias e ajustes estão sendo implementados continuamente.

## Sobre

O **Selynt Panel** é um painel de controle web para gerenciamento de processos, oferecendo uma interface moderna e intuitiva para monitorar e administrar suas aplicações. Construído sobre o framework CodeIgniter 4, o projeto foi desenvolvido para ser leve, rápido e fácil de usar.

## Recursos

- 🖥️ **Interface moderna** — Design clean e responsivo
- 🌙 **Tema Dark/Light** — Escolha o tema que preferir
- 🌍 **Multi-idioma** — Suporte a múltiplos idiomas
- 🔐 **Segurança com Argon2** — Hash de senhas com algoritmo Argon2
- 📊 **Monitoramento em tempo real** — Acompanhe o status dos seus processos
- 🟢 **Suporte a Node.js** — Gerencie aplicações Node.js com facilidade
- ⚡ **Instalador integrado** — Configuração guiada e simples

### Em desenvolvimento

- 🐳 **Docker** — Gerenciamento de containers Docker
- 🐍 **Python** — Suporte para aplicações Python

## Screenshots

<p align="center">
  <img src="https://i.ibb.co/N68rSfpW/image.png" alt="Dashboard - Tema Light" width="45%">
  &nbsp;&nbsp;
  <img src="https://i.ibb.co/PGkbXPY5/image.png" alt="Dashboard - Tema Dark" width="45%">
</p>

<p align="center">
  <em>Dashboard em tema Light e Dark</em>
</p>

## Tecnologias

- **Backend:** [CodeIgniter 4](https://codeigniter.com) (PHP 8.1+)
- **Banco de dados:** SQLite
- **Gerenciador de processos:** PM2

## Requisitos

- PHP 8.1 ou superior
- Extensões PHP:
  - `intl`
  - `mbstring`
  - `json`
  - `curl`
  - `pdo`
  - `sqlite3` / `pdo_sqlite`
- [PM2](https://pm2.keymetrics.io/) instalado globalmente
- Node.js (para aplicações Node)

> **Nota:** O painel possui um instalador integrado que verifica automaticamente se todos os requisitos estão atendidos.

## Instalação

```bash
# Clone o repositório
git clone https://github.com/NullSablex/Selynt-Panel.git

# Acesse o diretório
cd Selynt-Panel

# Instale as dependências
composer install

# Configure o ambiente
cp env .env
```

Configure seu servidor web para apontar para o diretório `public/`.

### Instalador Web

Após configurar o servidor, acesse o instalador pelo navegador:

```
https://seu-dominio.com/install
```

O instalador irá guiá-lo pelo processo de configuração e verificar se todos os requisitos estão corretos.

## Roadmap

- [x] Gerenciamento de processos Node.js
- [x] Interface web moderna
- [x] Tema Dark/Light
- [x] Suporte multi-idioma
- [x] Autenticação com Argon2
- [x] Instalador integrado
- [ ] Suporte a Docker
- [ ] Suporte a Python
- [ ] Sistema de notificações
- [ ] API REST completa

## Contribuindo

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e pull requests.

## Licença

Este projeto está licenciado sob os termos da [Licença MIT](LICENSE).

---

<p align="center">
  Inspirado no projeto <a href="https://github.com/suryatkin/pm2-webui">pm2-webui</a> de Surya T.
</p>