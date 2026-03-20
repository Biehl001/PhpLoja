<?php
/**
 * Header compartilhado do sistema
 *
 * Inclui a navegação (navbar) e abre a estrutura HTML.
 * Usado em todas as páginas com require_once.
 */
session_start();

// Importar as classes
require_once __DIR__ . "/../classes/Cliente.php";
require_once __DIR__ . "/../classes/Produto.php";
require_once __DIR__ . "/../classes/Pedido.php";

// Inicializar dados na sessão se ainda não existirem
if (!isset($_SESSION['clientes'])) {
    // Clientes padrão para demonstração
    $_SESSION['clientes'] = [
        ['id' => 1, 'nome' => 'João Silva', 'email' => 'joao@email.com'],
        ['id' => 2, 'nome' => 'Maria Santos', 'email' => 'maria@email.com'],
    ];
    $_SESSION['next_cliente_id'] = 3;
}

if (!isset($_SESSION['produtos'])) {
    // Produtos padrão para demonstração
    $_SESSION['produtos'] = [
        ['id' => 1, 'nome' => 'Notebook', 'preco' => 3500.00],
        ['id' => 2, 'nome' => 'Mouse Gamer', 'preco' => 150.00],
        ['id' => 3, 'nome' => 'Headset', 'preco' => 280.00],
        ['id' => 4, 'nome' => 'Teclado Mecânico', 'preco' => 420.00],
    ];
    $_SESSION['next_produto_id'] = 5;
}

if (!isset($_SESSION['pedidos'])) {
    // Pedido padrão para demonstração
    $_SESSION['pedidos'] = [
        ['numero' => 1001, 'cliente_id' => 1, 'produtos_ids' => [1, 2, 3]],
    ];
    $_SESSION['next_pedido_numero'] = 1002;
}

// Detecta a página atual para marcar o link ativo na navegação
$pagina_atual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Pedidos da Loja</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Navbar do sistema -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="navbar-brand">Loja Admin</a>
            <button class="navbar-toggle" onclick="document.querySelector('.navbar-links').classList.toggle('active')">
                &#9776;
            </button>
            <ul class="navbar-links">
                <li><a href="index.php" class="<?php echo $pagina_atual === 'index.php' ? 'active' : ''; ?>">Inicio</a></li>
                <li><a href="clientes.php" class="<?php echo $pagina_atual === 'clientes.php' ? 'active' : ''; ?>">Clientes</a></li>
                <li><a href="produtos.php" class="<?php echo $pagina_atual === 'produtos.php' ? 'active' : ''; ?>">Produtos</a></li>
                <li><a href="pedidos.php" class="<?php echo $pagina_atual === 'pedidos.php' ? 'active' : ''; ?>">Pedidos</a></li>
            </ul>
        </div>
    </nav>

    <!-- Container principal -->
    <div class="container">
