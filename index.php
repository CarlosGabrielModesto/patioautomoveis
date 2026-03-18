<?php
/**
 * index.php — Listagem de Áreas
 * DriveEasy - Pátio de Automóveis
 */

$paginaAtual  = 'index';
$tituloPagina = 'Listagem de Áreas';

include('includes/conecta.php');
include('includes/header.php');
?>

<main class="container py-4 py-lg-5 flex-grow-1">

    <!-- Cabeçalho da página -->
    <div class="page-header">
        <h1><i class="bi bi-grid-3x3-gap me-2 text-accent"></i>Áreas do Pátio</h1>
        <p class="subtitle">Selecione uma área para ver os veículos disponíveis</p>
        <div class="accent-line"></div>
    </div>

    <?php
    // ── Consulta: conta quantos modelos distintos há em cada área ──
    // Usamos COUNT(id) para saber quantas linhas (alocações) existem por área,
    // o que representa a quantidade de modelos naquela área.
    $stmt = mysqli_prepare($conectaBD,
        "SELECT area, COUNT(id) AS modelos
         FROM alocacao
         GROUP BY area
         ORDER BY area ASC"
    );
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    // Indexa os resultados por número de área para acesso O(1)
    $areas = [];
    while ($row = mysqli_fetch_assoc($resultado)) {
        $areas[(int)$row['area']] = (int)$row['modelos'];
    }
    mysqli_stmt_close($stmt);

    // Totais para o resumo
    $totalAreas       = count($areas);
    $totalDisponiveis = array_sum($areas);
    ?>

    <!-- Resumo geral -->
    <div class="row g-3 mb-4 justify-content-center">
        <div class="col-6 col-md-3">
            <div class="area-card justify-content-center flex-column text-center py-1">
                <span style="font-size:1.6rem; color:var(--accent);" class="fw-bold"><?php echo $totalAreas; ?></span>
                <small style="font-size:0.7rem; letter-spacing:.08em; text-transform:uppercase; color:var(--text-muted);">Áreas com veículos</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="area-card justify-content-center flex-column text-center py-1">
                <span style="font-size:1.6rem; color:var(--success);" class="fw-bold"><?php echo $totalDisponiveis; ?></span>
                <small style="font-size:0.7rem; letter-spacing:.08em; text-transform:uppercase; color:var(--text-muted);">Modelos alocados</small>
            </div>
        </div>
    </div>

    <!-- Cards das 11 áreas -->
    <div class="row g-3">
        <?php for ($i = 1; $i <= 11; $i++): ?>
        <?php
            $temVeiculos = isset($areas[$i]);
            $modelos     = $temVeiculos ? $areas[$i] : 0;
        ?>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="area-card <?php echo !$temVeiculos ? 'vazia' : ''; ?>">

                <!-- Info da área -->
                <div>
                    <div class="area-numero">Área</div>
                    <div class="area-nome"><?php echo sprintf('%02d', $i); ?></div>
                </div>

                <!-- Badge de disponibilidade -->
                <div class="text-center">
                    <?php if ($temVeiculos): ?>
                        <span class="area-badge disponivel">
                            <i class="bi bi-check-circle-fill"></i>
                            <?php echo $modelos; ?> modelo<?php echo $modelos > 1 ? 's' : ''; ?>
                        </span>
                    <?php else: ?>
                        <span class="area-badge indisponivel">
                            <i class="bi bi-x-circle-fill"></i>
                            Vazia
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Botão de ação -->
                <?php if ($temVeiculos): ?>
                    <a href="lista-automoveis.php?area=<?php echo $i; ?>" class="btn-accent">
                        <i class="bi bi-arrow-right me-1"></i>Ver
                    </a>
                <?php else: ?>
                    <button class="btn-outline-accent" disabled style="opacity:.4; cursor:not-allowed;">
                        <i class="bi bi-dash"></i>
                    </button>
                <?php endif; ?>

            </div>
        </div>
        <?php endfor; ?>
    </div>

</main>

<?php include('includes/footer.php'); ?>
