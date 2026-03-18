# 🚗 DriveEasy — Pátio de Automóveis v2.0

Sistema de gerenciamento e venda de automóveis desenvolvido em PHP + MySQL.  
Projeto acadêmico — SENAI "Luiz Massa" | Técnico em Desenvolvimento de Sistemas | 2023  
Refatorado e profissionalizado em 2025.

---

## 📁 Estrutura de Arquivos

```
patioautomoveis/
│
├── index.php                  # Página inicial — Listagem de Áreas
├── lista-automoveis.php       # Listagem de veículos por área
├── vende-automoveis.php       # Formulário de venda
├── processa-venda.php         # Processamento da venda (POST)
│
├── includes/
│   ├── conecta.php            # Conexão com o banco de dados
│   ├── header.php             # Cabeçalho/Navbar compartilhado
│   └── footer.php             # Rodapé compartilhado
│
├── assets/
│   ├── css/
│   │   └── style.css          # Estilos personalizados (tema escuro/claro)
│   ├── js/
│   │   └── script.js          # JavaScript (tema, tooltips, UX)
│   └── img/
│       ├── logo-rent-a-car.png
│       └── carro-fundo.png
│
└── README.md
```

---

## ⚙️ Requisitos

- **PHP** 7.4 ou superior (recomendado: PHP 8.x)
- **MySQL** 5.7 ou superior (ou MariaDB 10.x)
- **Apache** com mod_rewrite ativado
- **XAMPP** (recomendado para desenvolvimento local no Windows)

---

## 🚀 Como Instalar e Executar (XAMPP)

### 1. Instalar o XAMPP

1. Baixe em: https://www.apachefriends.org/pt_br/download.html
2. Instale com as opções padrão (Apache + MySQL + PHP)
3. Abra o **XAMPP Control Panel**
4. Clique em **Start** no Apache e no MySQL

### 2. Configurar o Banco de Dados

1. Abra o navegador e acesse: http://localhost/phpmyadmin
2. Clique em **Novo** (ou **New**) para criar um banco
3. No campo "Nome do banco de dados", digite: `patioautomoveis_db`
4. Clique em **Criar**
5. Com o banco selecionado, clique na aba **Importar**
6. Clique em **Escolher arquivo** e selecione o arquivo `patioautomoveis_db.sql`
7. Clique em **Importar** no final da página

### 3. Copiar os arquivos do projeto

1. Abra a pasta de instalação do XAMPP (normalmente `C:\xampp\`)
2. Entre na pasta `htdocs`
3. Crie uma pasta chamada `patioautomoveis`
4. Copie todos os arquivos do projeto para dentro dessa pasta

A estrutura final deve ser:
```
C:\xampp\htdocs\patioautomoveis\
    ├── index.php
    ├── lista-automoveis.php
    ├── vende-automoveis.php
    ├── processa-venda.php
    ├── includes\
    ├── assets\
    └── ...
```

### 4. Configurar a conexão (se necessário)

Abra o arquivo `includes/conecta.php` e verifique as credenciais:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');      // Padrão do XAMPP: senha vazia ''
define('DB_NAME', 'patioautomoveis_db');
```

> ⚠️ No XAMPP, a senha padrão do MySQL é **vazia** (string vazia `''`).  
> Se instalou com senha, ajuste `DB_PASS` conforme necessário.

### 5. Acessar o sistema

Abra o navegador e acesse:

```
http://localhost/patioautomoveis/
```

---

## 🔐 Melhorias de Segurança (v2.0)

| Problema (v1.0)                     | Solução aplicada (v2.0)                          |
|-------------------------------------|--------------------------------------------------|
| SQL Injection em todas as queries   | Prepared Statements com `mysqli_prepare()`       |
| Variável errada `$connect`          | Corrigido para `$conectaBD` consistentemente     |
| Parâmetros GET/POST sem validação   | Validação e cast para `(int)` em todos os inputs |
| N+1 queries na listagem             | JOIN único substitui loop de queries aninhadas   |
| `header()` após output HTML         | Redirecionamentos movidos para antes do HTML     |

---

## ✨ Melhorias Visuais (v2.0)

- Bootstrap 5.3 (era 4.1)
- Tema escuro profissional + tema claro alternável
- Fonte Barlow Condensed para títulos (automotiva, moderna)
- Cards animados com stagger na listagem de áreas
- Badges coloridos por nível de estoque
- Layout totalmente responsivo (mobile-first)
- Footer e navbar compartilhados via `includes/`
- Feedback visual aprimorado na confirmação de venda

---

## 👨‍💻 Autor

**Carlos Gabriel dos Santos Modesto**  
Técnico em Desenvolvimento de Sistemas  
SENAI "Luiz Massa" — Concluído em 21/06/2023
