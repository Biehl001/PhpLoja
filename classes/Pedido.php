<?php

/**
 * Classe Pedido
 *
 * Representa um pedido da loja.
 * Demonstra o uso de:
 * - Relacionamento entre classes (Pedido tem um Cliente e vários Produtos)
 * - Array de objetos (lista de produtos)
 * - Métodos que fazem cálculos e geram HTML
 */
class Pedido
{
    // Atributos privados
    private $numero;    // Número do pedido (ex: 1001)
    private $cliente;   // Objeto da classe Cliente (relacionamento entre classes!)
    private $produtos;  // Array que vai guardar os objetos Produto

    /**
     * Construtor da classe Pedido
     *
     * Ao criar um pedido, informamos o número e o cliente.
     * A lista de produtos começa vazia e vai sendo preenchida
     * com o método adicionarProduto().
     *
     * @param int     $numero  - Número identificador do pedido
     * @param Cliente $cliente - Objeto Cliente (quem fez o pedido)
     */
    public function __construct($numero, $cliente)
    {
        $this->numero = $numero;
        $this->cliente = $cliente;

        // Inicializa o array de produtos vazio
        // Os produtos serão adicionados depois com adicionarProduto()
        $this->produtos = [];
    }

    // ========================
    // GETTERS
    // ========================

    /**
     * Retorna o número do pedido
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Retorna o objeto Cliente associado ao pedido
     * @return Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Retorna o array de produtos do pedido
     * @return array
     */
    public function getProdutos()
    {
        return $this->produtos;
    }

    // ========================
    // SETTERS
    // ========================

    /**
     * Define o número do pedido
     * @param int $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * Define o cliente do pedido
     * @param Cliente $cliente
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
    }

    // ========================
    // MÉTODOS DO PEDIDO
    // ========================

    /**
     * Adiciona um produto ao pedido
     *
     * Cada produto adicionado vai para o array $produtos.
     * Podemos adicionar quantos produtos quisermos.
     *
     * @param Produto $produto - Objeto Produto a ser adicionado
     */
    public function adicionarProduto($produto)
    {
        // Adiciona o produto no final do array
        $this->produtos[] = $produto;
    }

    /**
     * Calcula o valor total do pedido
     *
     * Percorre todos os produtos do pedido e soma os preços.
     * Usa o getter getPreco() pois o atributo preco é privado na classe Produto.
     *
     * @return float - Valor total do pedido
     */
    public function calcularTotal()
    {
        $total = 0;

        // Percorre cada produto no array e soma o preço
        foreach ($this->produtos as $produto) {
            // Usamos o getter getPreco() porque preco é privado
            $total += $produto->getPreco();
        }

        return $total;
    }

    /**
     * Gera o HTML do resumo do pedido
     *
     * Este método retorna uma string HTML com todas as informações
     * do pedido formatadas para exibição na página.
     *
     * @return string - HTML do resumo do pedido
     */
    public function exibirResumo()
    {
        // Inicia a construção do HTML do resumo
        $html = '';

        // === SEÇÃO: NÚMERO DO PEDIDO ===
        $html .= '<div class="card">';
        $html .= '  <div class="card-header">Pedido N&ordm; ' . $this->numero . '</div>';
        $html .= '  <div class="card-body">';

        // === SEÇÃO: DADOS DO CLIENTE ===
        // Usamos os getters do objeto Cliente para acessar os dados
        $html .= '    <div class="secao">';
        $html .= '      <h3>Cliente</h3>';
        $html .= '      <p class="cliente-nome">' . $this->cliente->getNome() . '</p>';
        $html .= '      <p class="cliente-email">' . $this->cliente->getEmail() . '</p>';
        $html .= '    </div>';

        // === SEÇÃO: LISTA DE PRODUTOS ===
        $html .= '    <div class="secao">';
        $html .= '      <h3>Produtos</h3>';
        $html .= '      <table class="tabela-produtos">';
        $html .= '        <thead>';
        $html .= '          <tr>';
        $html .= '            <th>Produto</th>';
        $html .= '            <th>Pre&ccedil;o</th>';
        $html .= '          </tr>';
        $html .= '        </thead>';
        $html .= '        <tbody>';

        // Percorre cada produto e cria uma linha na tabela
        foreach ($this->produtos as $produto) {
            // number_format() formata o número: 2 casas decimais, vírgula, ponto
            $precoFormatado = 'R$ ' . number_format($produto->getPreco(), 2, ',', '.');

            $html .= '          <tr>';
            $html .= '            <td>' . $produto->getNome() . '</td>';
            $html .= '            <td class="preco">' . $precoFormatado . '</td>';
            $html .= '          </tr>';
        }

        $html .= '        </tbody>';
        $html .= '      </table>';
        $html .= '    </div>';

        // === SEÇÃO: TOTAL DO PEDIDO ===
        $totalFormatado = 'R$ ' . number_format($this->calcularTotal(), 2, ',', '.');

        $html .= '    <div class="total">';
        $html .= '      <span>Total do Pedido:</span>';
        $html .= '      <span class="total-valor">' . $totalFormatado . '</span>';
        $html .= '    </div>';

        $html .= '  </div>'; // fecha card-body
        $html .= '</div>';   // fecha card

        return $html;
    }
}
