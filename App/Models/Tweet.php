<?php

namespace App\Models;

use MF\Model\Model;

class Tweet extends Model {
	private $id;
	private $id_usuario;
	private $tweet;
	private $data;

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	public function setIdUsuario($id_usuario)
	{
		$this->id_usuario = $id_usuario;
	}

	public function getTweet()
	{
		return $this->tweet;
	}

	public function setTweet($tweet)
	{
		$this->tweet = $tweet;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function salvar() {
		$query = 'INSERT INTO tweets (id_usuario, tweet) VALUES (:id_usuario, :tweet)';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->getIdUsuario());
		$stmt->bindValue(':tweet', $this->getTweet());
		$stmt->execute();

		return $this;
	}

	public function getAll() {
		$query = 'SELECT
						t.id,
						t.id_usuario,
						u.nome,
						t.tweet,
						DATE_FORMAT(t.data, "%d/%m/%Y %H:%i") as data
					FROM tweets as t 
					LEFT JOIN usuarios as u on (t.id_usuario = u.id) WHERE id_usuario = :id_usuario 
					OR t.id_usuario in (SELECT id_usuario_seguindo FROM usuariosSeguidores WHERE usuariosSeguidores.id_usuario= :id_usuario)
					ORDER BY t.data DESC';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->getIdUsuario());
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function removerTweet($idTweet) {
		$query = 'DELETE FROM tweets WHERE id = :idTweet AND id_usuario = :idUsuario';
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':idTweet', $idTweet);
		$stmt->bindValue(':idUsuario', $_SESSION['id']);
		$stmt->execute();

		return true;
	}
}