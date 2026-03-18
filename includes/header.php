<?php
/**
 * Cabeçalho Compartilhado
 * Inclua no topo de cada página passando $paginaAtual e $tituloPagina
 * 
 * Exemplo de uso:
 *   $paginaAtual = 'index';
 *   $tituloPagina = 'Listagem de Áreas';
 *   include('includes/header.php');
 */
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DriveEasy - Pátio de Automóveis. Gerencie e venda veículos com facilidade.">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="assets/css/style.css">

    <title>DriveEasy &mdash; <?php echo htmlspecialchars($tituloPagina ?? 'Pátio de Automóveis'); ?></title>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" id="mainNav">
    <div class="container-fluid px-4">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
            <img src="assets/img/logo-rent-a-car.png" alt="DriveEasy Logo" height="44" class="logo-img">
        </a>

        <!-- Título centralizado (visível em desktop) -->
        <span class="navbar-title d-none d-lg-block">
            Pátio de Automóveis &mdash; 
            <span class="text-accent"><?php echo htmlspecialchars($tituloPagina ?? ''); ?></span>
        </span>

        <!-- Botão de tema (direita) -->
        <button class="btn btn-sm btn-outline-warning" id="btnTema" onclick="alterarTema()" title="Alternar tema claro/escuro">
            <i class="bi bi-moon-stars-fill" id="iconeTema"></i>
        </button>

    </div>
</nav>
