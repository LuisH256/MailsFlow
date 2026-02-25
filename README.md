# 📧 MailFlows

[Português](#br) | [English](#en)

---

<a id="br"></a>
## 🇧🇷 Português

**MailFlows** é uma plataforma inteligente para criação, padronização e gerenciamento de templates de e-mails corporativos. O foco do projeto é trazer agilidade e profissionalismo para diferentes setores de uma empresa, permitindo que e-mails complexos sejam preenchidos de forma dinâmica.

### 🚀 Funcionalidades Principais
* **Editor com Preview em Tempo Real:** Visualize o resultado final enquanto digita.
* **Sintaxe Dinâmica Customizada:** * `{{variável}}`: Cria automaticamente campos de texto manual.
    * `[[Rótulo: Opção 1 > Opção 2]]`: Gera menus de seleção (dropdowns).
* **Gestão por Cargos:** Controle de visibilidade de templates baseado na hierarquia da empresa.
* **Interface Moderna:** Desenvolvido com **Tailwind CSS** focado em UX/UI.

### 🛠️ Tecnologias
* **PHP / PDO**: Lógica de back-end e segurança de dados.
* **JavaScript**: Processamento de Regex para transformar tags em formulários.
* **Tailwind CSS**: Estilização responsiva e moderna.

---

<a id="en"></a>
## 🇺🇸 English

**MailFlows** is a smart platform for creating, standardizing, and managing corporate email templates. The project focuses on bringing speed and professionalism to various business sectors by allowing complex emails to be filled out dynamically.

### 🚀 Key Features
* **Real-Time Preview Editor:** See the final result instantly as you type.
* **Custom Dynamic Syntax:** * `{{variable}}`: Automatically creates manual text input fields.
    * `[[Label: Option 1 > Option 2]]`: Generates dropdown selection menus.
* **Role-Based Management:** Control template visibility based on the company's hierarchy.
* **Modern Interface:** Built with **Tailwind CSS** with a strong focus on UX/UI.

### 🛠️ Technologies
* **PHP / PDO**: Backend logic and data security.
* **JavaScript**: Regex processing to transform tags into interactive forms.
* **Tailwind CSS**: Responsive and modern styling.

---

## 📖 Como a Mágica Acontece / How the Magic Works

O sistema utiliza **Expressões Regulares (Regex)** para converter marcações de texto em elementos de interface:
*The system uses **Regular Expressions (Regex)** to convert text markup into UI elements:*

```javascript
// Exemplo da lógica / Logic example:
// {{nome}} -> <input type="text">
// [[Kit: Mac > Dell]] -> <select><option>Mac</option></select>
