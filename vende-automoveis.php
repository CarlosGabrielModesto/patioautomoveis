<?php
/**
 * vende-automoveis.php — Formulário de Venda
 * DriveEasy - Pátio de Automóveis
 */

include('includes/conecta.php');

// ── Valida parâmetros GET ──
$idAutomovel = isset($_GET['id'])   ? (int)$_GET['id']   : 0;
$area        = isset($_GET['area']) ? (int)$_GET['area'] : 0;

if ($idAutomovel <= 0 || $area <= 0) {
    header('Location: index.php');
    exit;
}

// ── Busca dados do automóvel ──
$stmtCar = mysqli_prepare($conectaBD,
    "SELECT modelo, fabricante, ano, preco FROM automoveis WHERE id = ? LIMIT 1"
);
mysqli_stmt_bind_param($stmtCar, 'i', $idAutomovel);
mysqli_stmt_execute($stmtCar);
$resCar = mysqli_stmt_get_result($stmtCar);
$carro  = mysqli_fetch_assoc($resCar);
mysqli_stmt_close($stmtCar);

// Veículo não encontrado
if (!$carro) {
    header('Location: lista-automoveis.php?area=' . $area);
    exit;
}

// ── Busca a concessionária responsável pela alocação ──
$stmtCS = mysqli_prepare($conectaBD,
    "SELECT a.concessionaria AS id_cs, c.concessionaria AS nome_cs
     FROM alocacao a
     INNER JOIN concessionarias c ON c.id = a.concessionaria
     WHERE a.area = ? AND a.automovel = ?
     LIMIT 1"
);
mysqli_stmt_bind_param($stmtCS, 'ii', $area, $idAutomovel);
mysqli_stmt_execute($stmtCS);
$resCS        = mysqli_stmt_get_result($stmtCS);
$concessionaria = mysqli_fetch_assoc($resCS);
mysqli_stmt_close($stmtCS);

// ── Busca lista de clientes ──
$stmtClientes = mysqli_prepare($conectaBD, "SELECT id, nome FROM clientes ORDER BY nome ASC");
mysqli_stmt_execute($stmtClientes);
$resClientes  = mysqli_stmt_get_result($stmtClientes);
$clientes     = mysqli_fetch_all($resClientes, MYSQLI_ASSOC);
mysqli_stmt_close($stmtClientes);

$paginaAtual  = 'venda';
$tituloPagina = 'Venda de Automóvel';

include('includes/header.php');
?>

<main class="container py-4 py-lg-5 flex-grow-1 d-flex flex-column align-items-center">

    <!-- Botão voltar -->
    <div class="w-100 mb-3" style="max-width:580px;">
        <a href="lista-automoveis.php?area=<?php echo $area; ?>"
           style="font-size:0.78rem; padding:0.3rem 0.75rem; text-decoration:none; display:inline-flex; align-items:center; gap:0.3rem; border-radius:6px; border:1px solid var(--border-accent); color:var(--accent); font-family:var(--font-display); font-weight:700; letter-spacing:.08em; text-transform:uppercase; transition:all .25s;">
            <i class="bi bi-arrow-left"></i> Voltar à Área <?php echo $area; ?>
        </a>
    </div>

    <!-- Formulário de venda -->
    <div class="form-venda">

        <!-- Destaque do veículo -->
        <div class="car-highlight">
            <div class="car-icon">🚗</div>
            <div class="car-modelo"><?php echo htmlspecialchars($carro['modelo']); ?></div>
            <div style="color:var(--text-muted); font-size:0.8rem; margin: 0.2rem 0;">
                <?php echo htmlspecialchars($carro['fabricante']); ?> &bull; <?php echo htmlspecialchars($carro['ano']); ?>
            </div>
            <div class="car-preco"><?php echo htmlspecialchars($carro['preco']); ?></div>
        </div>

        <!-- Input oculto com o ID do veículo -->
        <form action="processa-venda.php" method="post" id="formVenda">
            <input type="hidden" name="automovel"     value="<?php echo $idAutomovel; ?>">
            <input type="hidden" name="concessionaria" value="<?php echo $concessionaria ? (int)$concessionaria['id_cs'] : 0; ?>">

            <!-- Seleção de cliente -->
            <div class="mb-3">
                <label for="cliente" class="form-label">
                    <i class="bi bi-person me-1"></i>Cliente
                </label>
                <select name="cliente" id="cliente" class="form-select" required>
                    <option value="" disabled selected>— Selecione o cliente —</option>
                    <?php foreach ($clientes as $c): ?>
                        <option value="<?php echo (int)$c['id']; ?>">
                            <?php echo htmlspecialchars($c['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Concessionária (somente leitura, pré-preenchida) -->
            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-building me-1"></i>Concessionária
                </label>
                <input type="text"
                       class="form-control"
                       value="<?php echo $concessionaria ? htmlspecialchars($concessionaria['nome_cs']) : 'Não encontrada'; ?>"
                       readonly
                       style="cursor:default; opacity:.75;">
            </div>

            <hr class="form-divider">

            <!-- Botão de confirmação -->
            <div class="d-flex gap-2 justify-content-end">
                <a href="lista-automoveis.php?area=<?php echo $area; ?>"
                   class="btn-outline-accent"
                   style="text-decoration:none; padding:0.55rem 1.25rem; border-radius:6px; display:inline-flex; align-items:center; gap:.4rem;">
                    <i class="bi bi-x-lg"></i> Cancelar
                </a>
                <button type="submit" class="btn-accent" style="padding:0.55rem 1.5rem; font-size:0.9rem;"
                        <?php echo !$concessionaria ? 'disabled' : ''; ?>>
                    <i class="bi bi-bag-check-fill me-1"></i> Confirmar Venda
                </button>
            </div>

        </form>
    </div>

</main>

<?php include('includes/footer.php'); ?>
