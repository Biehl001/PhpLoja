<?php

/**
 * Classe Cliente
 *
 * Representa um cliente da loja.
 * Demonstra o uso de:
 * - Atributos privados (encapsulamento)
 * - Construtor (__construct)
 * - Getters e Setters
 */
class Cliente
{
    // Atributos privados - não podem ser acessados diretamente de fora da classe
    // Para acessar ou modificar, usamos getters e setters
    private $id;
    private $nome;
    private $email;

    /**
     * Construtor da classe Cliente
     *
     * O construtor é chamado automaticamente quando criamos um novo objeto.
     * Exemplo: $cliente = new Cliente(1, "João", "joao@email.com");
     *
     * @param int    $id    - Identificador único do cliente
     * @param string $nome  - Nome completo do cliente
     * @param string $email - Email do cliente
     */
    public function __construct($id, $nome, $email)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
    }

    // ========================
    // GETTERS - Métodos para LER os atributos privados
    // ========================

    /**
     * Retorna o ID do cliente
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Retorna o nome do cliente
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Retorna o email do cliente
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    // ========================
    // SETTERS - Métodos para ALTERAR os atributos privados
    // ========================

    /**
     * Define o ID do cliente
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Define o nome do cliente
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * Define o email do cliente
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}
