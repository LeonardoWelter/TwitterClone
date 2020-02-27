<?php

namespace App\Models;

use MF\Model\Model;

class Usuario extends Model {

	private $id;
	private $nome;
	private $email;
	private $senha;

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getNome()
	{
		return $this->nome;
	}

	public function setNome($nome)
	{
		$this->nome = $nome;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getSenha()
	{
		return $this->senha;
	}

	public function setSenha($senha)
	{
		$this->senha = $senha;
	}

	public function salvar() {
		$query = "INSERT INTO usuarios(nome, email, senha) VALUES (:nome,:email, :senha)";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':nome', $this->getNome());
		$stmt->bindValue(':email', $this->getEmail());
		$stmt->bindValue(':senha', $this->getSenha());

		$stmt->execute();

		return $this;
	}

	public function validarCadastro() {
		$valido = true;

		if (strlen($this->getNome()) < 3) {
			$valido = false;
		}

		if (strlen($this->getEmail()) < 3) {
			$valido = false;
		}

		if (strlen($this->getSenha()) < 3) {
			$valido = false;
		}

		return $valido;
	}

	public function getUsuarioPorEmail() {
		$query = "SELECT nome, email FROM usuarios WHERE email = :email";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':email', $this->getEmail());
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}


}