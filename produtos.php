<?php
/**
 * ==============================================
 * PÁGINA DE PRODUTOS
 * ==============================================
 *
 * Permite:
 * - Cadastrar novos produtos (formulário)
 * - Listar todos os produtos cadastrados (tabela)
 *
 * Demonstra a validação de preço negativo no setter da classe Produto.
 */
require_once "includes/header.php";

$mensagem = '';

// Processa o formulário quando enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $preco = floatval($_POST['preco'] ?? 0);

    if ($nome !== '' && $preco > 0) {
        // Cria o objeto Produto usando a classe
        // O setter do preço faz a validação automaticamente!
        $novo_produto = new Produto($_SESSION['next_produto_id'], $nome, $preco);

        // Salva na sessão usando os getters
        $_SESSION['produtos'][] = [
            'id' => $novo_produto->getId(),
            'nome' => $novo_produto->getNome(),
            'preco' => $novo_produto->getPreco(),
        ];
        $_SESSION['next_produto_id']++;

        $mensagem = 'sucesso';
    } else {
        $mensagem = 'erro';
    }
}
?>

<!-- Cabeçalho da página -->
<header class="page-header">
    <h1>Produtos</h1>
    <p>Cadastre e gerencie os produtos da loja</p>
</header>

<!-- Mensagens de feedback -->
<?php if ($mensagem === 'sucesso'): ?>
    <div class="alerta alerta-sucesso">Produto cadastrado com sucesso!</div>
<?php elseif ($mensagem === 'erro'): ?>
    <div class="alerta alerta-erro">Preencha todos os campos! O preco deve ser maior que zero.</div>
<?php endif; ?>

<!-- Formulário de cadastro -->
<div class="card">
    <div class="card-header">Novo Produto</div>
    <div class="card-body">
        <form method="POST" action="produtos.php">
            <div class="form-group">
                <label for="nome">Nome do Produto</label>
                <input type="text" id="nome" name="nome" placeholder="Ex: Monitor 24 polegadas" required>
            </div>
            <div class="form-group">
                <label for="preco">Preco (R$)</label>
                <input type="number" id="preco" name="preco" placeholder="Ex: 899.90" step="0.01" min="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Produto</button>
        </form>
    </div>
</div>

<!-- Listagem de produtos -->
<div class="card">
    <div class="card-header">Produtos Cadastrados</div>
    <div class="card-body">
        <?php if (empty($_SESSION['produtos'])): ?>
            <p class="texto-vazio">Nenhum produto cadastrado ainda.</p>
        <?php else: ?>
            <table class="tabela-produtos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Preco</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['produtos'] as $p): ?>
                        <?php
                        // Recria o objeto para usar os getters
                        $produto = new Produto($p['id'], $p['nome'], $p['preco']);
                        ?>
                        <tr>
                            <td><?php echo $produto->getId(); ?></td>
                            <td><?php echo htmlspecialchars($produto->getNome()); ?></td>
                            <td class="preco">R$ <?php echo number_format($produto->getPreco(), 2, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require_once "includes/footer.php"; ?>
