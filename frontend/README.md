# 🎯 Sistema de Quiz Online

Sistema web completo para criação e realização de quizzes, desenvolvido como projeto para a disciplina de Engenharia de Software II.

## 👥 Autores

- **Palmira Nzau** - Conjunto 1: Sistema de Recomendação de Filmes | Conjunto 2: Sistema de Quiz Online
- [Adicionar outros membros do grupo]

## 📚 Sobre o Projeto

O Sistema de Quiz Online permite que utilizadores realizem quizzes sobre diversos temas, enquanto administradores podem criar, editar e importar perguntas de uma API externa.

### Funcionalidades

#### Utilizadores normais
- ✅ Registo e autenticação
- ✅ Visualizar lista de quizzes disponíveis
- ✅ Responder a quizzes com perguntas de múltipla escolha
- ✅ Ver pontuação final
- ✅ Exportar resultados em CSV e PDF
- ✅ Alternar entre modo claro/escuro
- ✅ Alternar entre Português e Inglês

#### Administradores
- ✅ Todas as funcionalidades de utilizador normal
- ✅ Criar, editar e apagar quizzes
- ✅ Importar perguntas da API Open Trivia DB
- ✅ Gerir perguntas e respostas

## 🛠️ Tecnologias Utilizadas

| Tecnologia | Função |
|------------|--------|
| Angular 17+ | Frontend |
| PHP 8+ (puro) | Backend API |
| MySQL | Base de dados |
| Bootstrap 5 | Estilização e responsividade |
| JWT | Autenticação |
| jsPDF / FileSaver | Exportação PDF/CSV |
| Open Trivia DB | API externa |

## 📋 Requisitos Obrigatórios Cumpridos

- [x] Sistema de autenticação completo (registo, login, logout,) Att: recuperação de senha não concluido
- [x] Base de dados relacional com 6 tabelas e operações CRUD
- [x] Integração com API externa (Open Trivia DB)
- [x] Interface responsiva (Bootstrap)
- [x] Modo claro e modo escuro com alternância
- [x] Suporte a múltiplos idiomas (Português/Inglês)
- [x] Funcionalidade de exportação de dados (CSV e PDF)
- [x] Distinção entre tipos de utilizadores (admin/user)
- [x] Permissões diferenciadas de acesso

## 🚀 Como Executar o Projeto

### Pré-requisitos

- [XAMPP](https://www.apachefriends.org/) (ou WAMP/MAMP) com PHP 8+ e MySQL
- [Node.js](https://nodejs.org/) (versão 18 ou superior)
- [Angular CLI](https://angular.io/cli) (`npm install -g @angular/cli`)

### Passo 1: Configurar a Base de Dados

1. Inicie o MySQL no XAMPP
2. Aceda ao phpMyAdmin: `http://localhost/phpmyadmin`
3. Crie uma base de dados chamada `quiz_system`
4. Importe o ficheiro `database/quiz_system.sql`
5. Verifique as credenciais no ficheiro `backend/config/database.php` (ajuste a porta se necessário, ex: `localhost:3307`)

### Passo 2: Configurar o Backend

1. Copie a pasta `backend` para `C:/xampp/htdocs/sistema-quiz-online/`
2. Certifique-se de que o PHP está ativo
3. Teste a API acedendo a: 
   `http://localhost/sistema-quiz-online/backend/routes/api.php?endpoint=quizzes`

### Passo 3: Configurar o Frontend

```bash
cd frontend
npm install
ng serve --open