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

	public function autenticar() {
		$query = 'SELECT id,nome, email FROM usuarios WHERE email = :email AND senha = :senha';
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':email', $this->getEmail());
		$stmt->bindValue(':senha', $this->getSenha());

		$stmt->execute();

		$usuario =  $stmt->fetch(\PDO::FETCH_ASSOC);

		if ($usuario['id'] != '' && $usuario['nome'] != '' && $usuario['email'] != ''){
			$this->setId($usuario['id']);
			$this->setNome($usuario['nome']);
		}

		return $this;
	}

	public function getAll() {
		$query = 'SELECT u.id, u.nome, u.email, 
       (SELECT COUNT(*) FROM usuariosSeguidores as us WHERE us.id_usuario = :id_usuario AND us.id_usuario_seguindo = u.id) as seguindo
				  FROM usuarios as u WHERE u.nome LIKE :nome AND id != :id_usuario';
		$stmt = $this->db->prepare($query);

		$stmt->bindValue(':nome', '%'.$this->getNome().'%');
		$stmt->bindValue(':id_usuario', $this->getId());
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function seguirUsuario($idUsuario) {
		$query = 'INSERT INTO usuariosSeguidores (id_usuario, id_usuario_seguindo) value (:idUsuario, :idUsuarioSeguindo)';
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':idUsuario', $this->getId());
		$stmt->bindValue(':idUsuarioSeguindo', $idUsuario);
		$stmt->execute();

		return true;
	}

	public function pararSeguir($idUsuario) {
		$query = 'DELETE FROM usuariosSeguidores WHERE id_usuario = :idUsuario AND id_usuario_seguindo = :idUsuarioSeguindo';
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':idUsuario', $this->getId());
		$stmt->bindValue(':idUsuarioSeguindo', $idUsuario);
		$stmt->execute();

		return true;
	}

	public function getInfoUsuario() {
		$query = 'SELECT nome FROM usuarios WHERE id = :idUsuario';
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':idUsuario', $this->getId());
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function getTotalTweets() {
		$query = 'SELECT COUNT(*) as totalTweets FROM tweets WHERE id_usuario = :idUsuario';
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':idUsuario', $this->getId());
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function getTotalSeguindo() {
		$query = 'SELECT COUNT(*) as totalSeguindo FROM usuariosSeguidores WHERE id_usuario = :idUsuario';
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':idUsuario', $this->getId());
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function getTotalSeguidores() {
		$query = 'SELECT COUNT(*) as totalSeguidores FROM usuariosSeguidores WHERE id_usuario_seguindo = :idUsuario';
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':idUsuario', $this->getId());
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}


}