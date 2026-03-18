<?php
/**
 * lista-automoveis.php — Listagem de Automóveis por Área
 * DriveEasy - Pátio de Automóveis
 */

include('includes/conecta.php');

// ── Valida e sanitiza o parâmetro de área via GET ──
$area = isset($_GET['area']) ? (int)$_GET['area'] : 0;

if ($area <= 0 || $area > 11) {
    // Área inválida: redireciona para a página inicial
    header('Location: index.php');
    exit;
}

$paginaAtual  = 'lista';
$tituloPagina = "Área {$area} — Automóveis";

include('includes/header.php');
?>

<main class="container py-4 py-lg-5 flex-grow-1">

    <!-- Cabeçalho -->
    <div class="page-header">
        <div class="mb-2">
            <a href="index.php" class="btn-outline-accent" style="font-size:0.78rem; padding:0.3rem 0.75rem; text-decoration:none; display:inline-flex; align-items:center; gap:0.3rem; border-radius:6px; border:1px solid var(--border-accent); color:var(--accent); font-family:var(--font-display); font-weight:700; letter-spacing:.08em; text-transform:uppercase; transition:all .25s;">
                <i class="bi bi-arrow-left"></i> Voltar às Áreas
            </a>
        </div>
        <h1><i class="bi bi-car-front me-2 text-accent"></i>Área <?php echo $area; ?></h1>
        <p class="subtitle">Veículos disponíveis para venda nesta área</p>
        <div class="accent-line"></div>
    </div>

    <?php
    // ── Consulta: busca veículos com quantidade > 0 na área informada ──
    // Usa JOIN para evitar N+1 queries (uma query por automóvel).
    // Prepared statement protege contra SQL Injection.
    $stmt = mysqli_prepare($conectaBD,
        "SELECT a.id AS alocacao_id,
                a.automovel AS automovel_id,
                a.quantidade,
                v.modelo,
                v.fabricante,
                v.ano,
                v.preco
         FROM alocacao a
         INNER JOIN automoveis v ON v.id = a.automovel
         WHERE a.area = ? AND a.quantidade > 0
         ORDER BY v.modelo ASC"
    );
    mysqli_stmt_bind_param($stmt, 'i', $area);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $veiculos  = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    $totalVeiculos = count($veiculos);
    ?>

    <?php if ($totalVeiculos === 0): ?>
        <!-- Estado vazio -->
        <div class="text-center py-5" style="animation: fadeInUp .5s ease both;">
            <i class="bi bi-car-front" style="font-size:3rem; color:var(--text-muted); display:block; margin-bottom:1rem;"></i>
            <h4 style="font-family:var(--font-display); color:var(--text-secondary);">Nenhum veículo disponível nesta área</h4>
            <p style="color:var(--text-muted); font-size:0.9rem;">Todos os veículos desta área foram vendidos ou a área está vazia.</p>
            <a href="index.php" class="btn-accent mt-3" style="display:inline-block; text-decoration:none;">
                <i class="bi bi-arrow-left me-1"></i>Voltar às Áreas
            </a>
        </div>
    <?php else: ?>

        <!-- Contador -->
        <p class="mb-3" style="color:var(--text-secondary); font-size:0.9rem;">
            <i class="bi bi-info-circle me-1"></i>
            <strong style="color:var(--text-primary);"><?php echo $totalVeiculos; ?></strong>
            modelo<?php echo $totalVeiculos > 1 ? 's' : ''; ?> encontrado<?php echo $totalVeiculos > 1 ? 's' : ''; ?>
        </p>

        <!-- Tabela -->
        <div class="tabela-wrapper">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="bi bi-car-front me-1"></i>Modelo</th>
                            <th class="d-none d-md-table-cell">Fabricante</th>
                            <th class="d-none d-sm-table-cell">Ano</th>
                            <th>Preço</th>
                            <th class="text-center">Qtd.</th>
                            <th class="text-center">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($veiculos as $v): ?>
                        <?php
                            // Define classe do badge de quantidade
                            $qty = (int)$v['quantidade'];
                            $badgeClass = $qty >= 5 ? 'alto' : ($qty >= 2 ? 'medio' : 'baixo');
                        ?>
                        <tr>
                            <td class="fw-semibold"><?php echo htmlspecialchars($v['modelo']); ?></td>
                            <td class="d-none d-md-table-cell" style="color:var(--text-secondary);">
                                <?php echo htmlspecialchars($v['fabricante']); ?>
                            </td>
                            <td class="d-none d-sm-table-cell" style="color:var(--text-secondary);">
                                <?php echo htmlspecialchars($v['ano']); ?>
                            </td>
                            <td style="color:var(--accent); font-weight:600;">
                                <?php echo htmlspecialchars($v['preco']); ?>
                            </td>
                            <td class="text-center">
                                <span class="qty-badge <?php echo $badgeClass; ?>"><?php echo $qty; ?></span>
                            </td>
                            <td class="text-center">
                                <a href="vende-automoveis.php?id=<?php echo (int)$v['automovel_id']; ?>&area=<?php echo $area; ?>"
                                   class="btn-accent"
                                   data-bs-toggle="tooltip"
                                   data-bs-title="Iniciar venda deste veículo">
                                    <i class="bi bi-bag-plus me-1"></i>Vender
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php endif; ?>

</main>

<?php include('includes/footer.php'); ?>
