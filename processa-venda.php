<?php
/**
 * processa-venda.php — Processamento da Venda
 * DriveEasy - Pátio de Automóveis
 *
 * Recebe os dados do formulário via POST,
 * valida, executa o UPDATE no banco e exibe o resultado.
 */

include('includes/conecta.php');

// ── Só aceita requisições POST ──
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// ── Coleta e valida os dados recebidos ──
$automovelID     = isset($_POST['automovel'])      ? (int)$_POST['automovel']      : 0;
$clienteID       = isset($_POST['cliente'])        ? (int)$_POST['cliente']        : 0;
$concessionariaID = isset($_POST['concessionaria']) ? (int)$_POST['concessionaria'] : 0;

// Se algum ID for inválido, redireciona
if ($automovelID <= 0 || $clienteID <= 0 || $concessionariaID <= 0) {
    header('Location: index.php');
    exit;
}

// ── Busca dados do automóvel para a mensagem de confirmação ──
$stmtCar = mysqli_prepare($conectaBD,
    "SELECT modelo, preco FROM automoveis WHERE id = ? LIMIT 1"
);
mysqli_stmt_bind_param($stmtCar, 'i', $automovelID);
mysqli_stmt_execute($stmtCar);
$resCar = mysqli_stmt_get_result($stmtCar);
$carro  = mysqli_fetch_assoc($resCar);
mysqli_stmt_close($stmtCar);

// ── Busca nome do cliente ──
$stmtCliente = mysqli_prepare($conectaBD,
    "SELECT nome FROM clientes WHERE id = ? LIMIT 1"
);
mysqli_stmt_bind_param($stmtCliente, 'i', $clienteID);
mysqli_stmt_execute($stmtCliente);
$resCliente = mysqli_stmt_get_result($stmtCliente);
$cliente    = mysqli_fetch_assoc($resCliente);
mysqli_stmt_close($stmtCliente);

// ── Executa o UPDATE: decrementa a quantidade em 1 ──
// A condição "AND quantidade > 0" garante que nunca vá abaixo de zero
$stmtUpdate = mysqli_prepare($conectaBD,
    "UPDATE alocacao
     SET quantidade = quantidade - 1
     WHERE automovel = ?
       AND concessionaria = ?
       AND quantidade > 0"
);
mysqli_stmt_bind_param($stmtUpdate, 'ii', $automovelID, $concessionariaID);
$sucesso = mysqli_stmt_execute($stmtUpdate);
$linhasAfetadas = mysqli_stmt_affected_rows($stmtUpdate);
mysqli_stmt_close($stmtUpdate);

// Encerra a conexão após as operações
mysqli_close($conectaBD);

// ── Determina resultado ──
// affected_rows == 0 significa que não havia estoque (quantidade já era 0)
$vendaOk = $sucesso && $linhasAfetadas > 0;

// Configurações da página
$paginaAtual  = 'venda';
$tituloPagina = $vendaOk ? 'Venda Realizada!' : 'Erro na Venda';

include('includes/header.php');
?>

<main class="container py-5 flex-grow-1 d-flex flex-column align-items-center justify-content-center">

    <div style="max-width:520px; width:100%; animation: fadeInUp .5s ease both;">

        <?php if ($vendaOk): ?>
        <!-- ── Sucesso ── -->
        <div class="alert-resultado sucesso">
            <span class="icone">✅</span>
            <div>
                Venda realizada com sucesso!
            </div>
            <?php if ($carro): ?>
            <div style="margin-top:.75rem; font-size:1rem; color:var(--text-secondary);">
                <strong class="modelo-destaque"><?php echo htmlspecialchars($carro['modelo']); ?></strong>
                vendido por <strong style="color:var(--success);"><?php echo htmlspecialchars($carro['preco']); ?></strong>
            </div>
            <?php endif; ?>
            <?php if ($cliente): ?>
            <div style="margin-top:.4rem; font-size:0.85rem; color:var(--text-muted);">
                Cliente: <?php echo htmlspecialchars($cliente['nome']); ?>
            </div>
            <?php endif; ?>
        </div>

        <?php else: ?>
        <!-- ── Erro ── -->
        <div class="alert-resultado erro">
            <span class="icone">❌</span>
            <div>Não foi possível efetuar a venda.</div>
            <div style="margin-top:.5rem; font-size:0.85rem; color:var(--text-muted);">
                O veículo pode não ter estoque disponível ou houve um erro no sistema.
            </div>
        </div>
        <?php endif; ?>

        <!-- Barra de progresso do redirecionamento -->
        <div class="redirect-msg text-center">
            <i class="bi bi-arrow-clockwise me-1"></i>
            Redirecionando para a página inicial em <strong>5 segundos</strong>…
            <div class="progress-redirect mt-2">
                <div class="progress-redirect-bar"></div>
            </div>
        </div>

        <!-- Botão manual caso queira voltar já -->
        <div class="text-center mt-3">
            <a href="index.php" class="btn-accent" style="text-decoration:none; display:inline-block; padding:.55rem 1.5rem;">
                <i class="bi bi-house me-1"></i>Ir para a Página Inicial
            </a>
        </div>

    </div>
</main>

<!-- Redirecionamento automático via meta refresh -->
<meta http-equiv="refresh" content="5;url=index.php">

<?php include('includes/footer.php'); ?>
