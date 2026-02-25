# MailsFlow


# 📧 MailFlows

**MailFlows** é uma plataforma inteligente para criação, padronização e gerenciamento de templates de e-mails corporativos. O foco do projeto é trazer agilidade e profissionalismo para diferentes setores de uma empresa, permitindo que e-mails complexos sejam preenchidos de forma dinâmica através de variáveis e menus de seleção.

__________________________________

## 🚀 Funcionalidades Principais

* **Editor com Preview em Tempo Real:** Visualize como o e-mail ficará enquanto você digita.
* **Sintaxe Dinâmica Customizada:** * `{{variável}}`: Cria automaticamente campos de texto manual.
    * `[[Rótulo: Opção 1 > Opção 2]]`: Gera menus de seleção (dropdowns) dentro do template.
* **Gestão Empresarial por Cargos:** Administradores podem definir quais cargos têm acesso a quais modelos de e-mail.
* **Sistema Multi-idioma:** Integração nativa com Google Translate para suporte global.
* **Interface Moderna:** Desenvolvido com **Tailwind CSS** e foco total em UX/UI (User Experience).
* **Gestão de Equipe:** Cadastro e controle de funcionários vinculados a uma empresa.

__________________________________

## 🛠️ Tecnologias Utilizadas

* **PHP 8.x**: Lógica de back-end e conexão com banco de dados.
* **PDO (PHP Data Objects)**: Segurança contra SQL Injection.
* **Tailwind CSS**: Estilização moderna e responsiva.
* **JavaScript (Vanilla)**: Processamento dinâmico de templates e manipulação de DOM para preview em tempo real.
* **Google Fonts (Inter)**: Tipografia limpa e profissional.

__________________________________

## 📖 Como Funciona (Lógica do Sistema)

### 1. Criação de Template
O usuário utiliza uma sintaxe simples no editor. O sistema processa via Regex (Expressões Regulares) os padrões `{{}}` e `[[]]` para transformar texto estático em um formulário interativo.

### 2. Preenchimento Dinâmico
Ao selecionar um template salvo, o MailFlows gera automaticamente os inputs necessários:
- Se houver `{{nome}}`, um campo de texto "NOME" aparece.
- Se houver `[[Kit: Mac > Dell]]`, um menu de escolha aparece.

### 3. Gestão de Acesso
```php
// Exemplo de filtragem por cargo presente no código:
$stmt = $pdo->prepare("SELECT DISTINCT cargo FROM usuarios WHERE empresa_id = ?");
// Isso garante que a padronização chegue apenas aos setores corretos.
