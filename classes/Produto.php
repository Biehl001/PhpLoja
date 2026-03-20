<?php

/**
 * Classe Produto
 *
 * Representa um produto da loja.
 * Demonstra o uso de:
 * - Atributos privados (encapsulamento)
 * - Construtor (__construct)
 * - Getters e Setters
 * - Validação no setter (preço não pode ser negativo)
 */
class Produto
{
    // Atributos privados - protegidos contra acesso direto
    private $id;
    private $nome;
    private $preco;

    /**
     * Construtor da classe Produto
     *
     * Ao criar o produto, já passamos os dados iniciais.
     * O preço é validado pelo setter para garantir que não seja negativo.
     *
     * @param int    $id    - Identificador único do produto
     * @param string $nome  - Nome do produto
     * @param float  $preco - Preço do produto (deve ser >= 0)
     */
    public function __construct($id, $nome, $preco)
    {
        $this->id = $id;
        $this->nome = $nome;

        // Usamos o setter aqui para aproveitar a validação do preço
        // Assim, mesmo no construtor, o preço é validado!
        $this->setPreco($preco);
    }

    // ========================
    // GETTERS
    // ========================

    /**
     * Retorna o ID do produto
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Retorna o nome do produto
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Retorna o preço do produto
     * @return float
     */
    public function getPreco()
    {
        return $this->preco;
    }

    // ========================
    // SETTERS
    // ========================

    /**
     * Define o ID do produto
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Define o nome do produto
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * Define o preço do produto
     *
     * VALIDAÇÃO: O preço não pode ser negativo!
     * Se alguém tentar colocar um preço negativo, o sistema define como 0.
     *
     * @param float $preco
     */
    public function setPreco($preco)
    {
        // Validação: se o preço for negativo, define como 0
        if ($preco < 0) {
            $this->preco = 0;
        } else {
            $this->preco = $preco;
        }
    }
}
