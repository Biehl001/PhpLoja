<?php
/**
 * ==============================================
 * PÁGINA DE CLIENTES
 * ==============================================
 *
 * Permite:
 * - Cadastrar novos clientes (formulário)
 * - Listar todos os clientes cadastrados (tabela)
 *
 * Os dados são armazenados na sessão PHP.
 * Demonstra o uso da classe Cliente com getters e setters.
 */
require_once "includes/header.php";

// Variável para mensagens de feedback ao usuário
$mensagem = '';

// Processa o formulário quando enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Validação dos campos
    if ($nome !== '' && $email !== '') {
        // Cria o objeto Cliente usando a classe (demonstra POO)
        $novo_cliente = new Cliente($_SESSION['next_cliente_id'], $nome, $email);

        // Salva na sessão usando os getters
        $_SESSION['clientes'][] = [
            'id' => $novo_cliente->getId(),
            'nome' => $novo_cliente->getNome(),
            'email' => $novo_cliente->getEmail(),
        ];
        $_SESSION['next_cliente_id']++;

        $mensagem = 'sucesso';
    } else {
        $mensagem = 'erro';
    }
}
?>

<!-- Cabeçalho da página -->
<header class="page-header">
    <h1>Clientes</h1>
    <p>Cadastre e gerencie os clientes da loja</p>
</header>

<!-- Mensagens de feedback -->
<?php if ($mensagem === 'sucesso'): ?>
    <div class="alerta alerta-sucesso">Cliente cadastrado com sucesso!</div>
<?php elseif ($mensagem === 'erro'): ?>
    <div class="alerta alerta-erro">Preencha todos os campos!</div>
<?php endif; ?>

<!-- Formulário de cadastro -->
<div class="card">
    <div class="card-header">Novo Cliente</div>
    <div class="card-body">
        <form method="POST" action="clientes.php">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" placeholder="Ex: João Silva" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Ex: joao@email.com" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Cliente</button>
        </form>
    </div>
</div>

<!-- Listagem de clientes -->
<div class="card">
    <div class="card-header">Clientes Cadastrados</div>
    <div class="card-body">
        <?php if (empty($_SESSION['clientes'])): ?>
            <p class="texto-vazio">Nenhum cliente cadastrado ainda.</p>
        <?php else: ?>
            <table class="tabela-produtos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['clientes'] as $c): ?>
                        <?php
                        // Recria o objeto para usar os getters (demonstra encapsulamento)
                        $cliente = new Cliente($c['id'], $c['nome'], $c['email']);
                        ?>
                        <tr>
                            <td><?php echo $cliente->getId(); ?></td>
                            <td><?php echo htmlspecialchars($cliente->getNome()); ?></td>
                            <td><?php echo htmlspecialchars($cliente->getEmail()); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require_once "includes/footer.php"; ?>
