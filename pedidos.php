<?php
/**
 * ==============================================
 * PÁGINA DE PEDIDOS
 * ==============================================
 *
 * Permite:
 * - Criar novos pedidos (formulário com seleção de cliente e produtos)
 * - Listar todos os pedidos com resumo completo
 *
 * Demonstra o relacionamento entre classes:
 * - Pedido "tem um" Cliente (composição)
 * - Pedido "tem vários" Produtos (array de objetos)
 */
require_once "includes/header.php";

$mensagem = '';

// Processa o formulário quando enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = intval($_POST['cliente_id'] ?? 0);
    $produtos_ids = $_POST['produtos_ids'] ?? [];

    // Converte os IDs dos produtos para inteiros
    $produtos_ids = array_map('intval', $produtos_ids);

    if ($cliente_id > 0 && !empty($produtos_ids)) {
        // Verifica se o cliente existe
        $cliente_existe = false;
        foreach ($_SESSION['clientes'] as $c) {
            if ($c['id'] === $cliente_id) {
                $cliente_existe = true;
                break;
            }
        }

        if ($cliente_existe) {
            // Cria o pedido na sessão
            $_SESSION['pedidos'][] = [
                'numero' => $_SESSION['next_pedido_numero'],
                'cliente_id' => $cliente_id,
                'produtos_ids' => $produtos_ids,
            ];
            $_SESSION['next_pedido_numero']++;

            $mensagem = 'sucesso';
        } else {
            $mensagem = 'erro';
        }
    } else {
        $mensagem = 'erro';
    }
}
?>

<!-- Cabeçalho da página -->
<header class="page-header">
    <h1>Pedidos</h1>
    <p>Crie e visualize os pedidos da loja</p>
</header>

<!-- Mensagens de feedback -->
<?php if ($mensagem === 'sucesso'): ?>
    <div class="alerta alerta-sucesso">Pedido criado com sucesso!</div>
<?php elseif ($mensagem === 'erro'): ?>
    <div class="alerta alerta-erro">Selecione um cliente e pelo menos um produto!</div>
<?php endif; ?>

<!-- Formulário de criação de pedido -->
<div class="card">
    <div class="card-header">Novo Pedido</div>
    <div class="card-body">
        <?php if (empty($_SESSION['clientes']) || empty($_SESSION['produtos'])): ?>
            <p class="texto-vazio">Cadastre ao menos um cliente e um produto antes de criar um pedido.</p>
        <?php else: ?>
            <form method="POST" action="pedidos.php">
                <div class="form-group">
                    <label for="cliente_id">Cliente</label>
                    <select id="cliente_id" name="cliente_id" required>
                        <option value="">Selecione um cliente...</option>
                        <?php foreach ($_SESSION['clientes'] as $c): ?>
                            <option value="<?php echo $c['id']; ?>">
                                <?php echo htmlspecialchars($c['nome']); ?> (<?php echo htmlspecialchars($c['email']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Produtos (selecione um ou mais)</label>
                    <div class="checkbox-group">
                        <?php foreach ($_SESSION['produtos'] as $p): ?>
                            <label class="checkbox-label">
                                <input type="checkbox" name="produtos_ids[]" value="<?php echo $p['id']; ?>">
                                <?php echo htmlspecialchars($p['nome']); ?> - R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Criar Pedido</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<!-- Listagem de pedidos -->
<div class="card">
    <div class="card-header">Pedidos Realizados</div>
    <div class="card-body">
        <?php if (empty($_SESSION['pedidos'])): ?>
            <p class="texto-vazio">Nenhum pedido realizado ainda.</p>
        <?php else: ?>
            <?php
            // Exibe cada pedido usando as classes (demonstra POO)
            foreach (array_reverse($_SESSION['pedidos']) as $pedido_data):
                // Busca o cliente do pedido
                $cliente_data = null;
                foreach ($_SESSION['clientes'] as $c) {
                    if ($c['id'] === $pedido_data['cliente_id']) {
                        $cliente_data = $c;
                        break;
                    }
                }

                if ($cliente_data):
                    // Cria os objetos usando as classes
                    $cliente = new Cliente($cliente_data['id'], $cliente_data['nome'], $cliente_data['email']);
                    $pedido = new Pedido($pedido_data['numero'], $cliente);

                    // Adiciona os produtos ao pedido
                    foreach ($pedido_data['produtos_ids'] as $pid) {
                        foreach ($_SESSION['produtos'] as $p) {
                            if ($p['id'] === $pid) {
                                $pedido->adicionarProduto(new Produto($p['id'], $p['nome'], $p['preco']));
                                break;
                            }
                        }
                    }

                    // Usa o método exibirResumo() da classe Pedido
                    echo $pedido->exibirResumo();
                endif;
            endforeach;
            ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once "includes/footer.php"; ?>
