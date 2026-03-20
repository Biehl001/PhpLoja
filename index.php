<?php
/**
 * ==============================================
 * PÁGINA INICIAL - DASHBOARD
 * ==============================================
 *
 * Exibe um resumo geral do sistema:
 * - Total de clientes cadastrados
 * - Total de produtos cadastrados
 * - Total de pedidos realizados
 * - Último pedido feito (resumo completo)
 */
require_once "includes/header.php";

// Contadores para os cards do dashboard
$total_clientes = count($_SESSION['clientes']);
$total_produtos = count($_SESSION['produtos']);
$total_pedidos = count($_SESSION['pedidos']);
?>

<!-- Cabeçalho da página -->
<header class="page-header">
    <h1>Gestão de Pedidos</h1>
    <p>Visão geral do sistema de pedidos</p>
</header>

<!-- Cards de resumo -->
<div class="dashboard-cards">
    <div class="dash-card">
        <div class="dash-card-icon clientes-icon">&#128100;</div>
        <div class="dash-card-info">
            <span class="dash-card-numero"><?php echo $total_clientes; ?></span>
            <span class="dash-card-label">Clientes</span>
        </div>
    </div>
    <div class="dash-card">
        <div class="dash-card-icon produtos-icon">&#128230;</div>
        <div class="dash-card-info">
            <span class="dash-card-numero"><?php echo $total_produtos; ?></span>
            <span class="dash-card-label">Produtos</span>
        </div>
    </div>
    <div class="dash-card">
        <div class="dash-card-icon pedidos-icon">&#128196;</div>
        <div class="dash-card-info">
            <span class="dash-card-numero"><?php echo $total_pedidos; ?></span>
            <span class="dash-card-label">Pedidos</span>
        </div>
    </div>
</div>

<?php
// Exibe o último pedido criado como resumo
if (!empty($_SESSION['pedidos'])) {
    $ultimo_pedido_data = end($_SESSION['pedidos']);

    // Recria os objetos a partir da sessão para usar os métodos da classe
    $cliente_data = null;
    foreach ($_SESSION['clientes'] as $c) {
        if ($c['id'] === $ultimo_pedido_data['cliente_id']) {
            $cliente_data = $c;
            break;
        }
    }

    if ($cliente_data) {
        $cliente = new Cliente($cliente_data['id'], $cliente_data['nome'], $cliente_data['email']);
        $pedido = new Pedido($ultimo_pedido_data['numero'], $cliente);

        foreach ($ultimo_pedido_data['produtos_ids'] as $pid) {
            foreach ($_SESSION['produtos'] as $p) {
                if ($p['id'] === $pid) {
                    $pedido->adicionarProduto(new Produto($p['id'], $p['nome'], $p['preco']));
                    break;
                }
            }
        }

        echo '<h2 class="section-title">Ultimo Pedido Realizado</h2>';
        echo $pedido->exibirResumo();
    }
}
?>

<?php require_once "includes/footer.php"; ?>
