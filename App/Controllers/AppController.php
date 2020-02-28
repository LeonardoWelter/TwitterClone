<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action
{

	public function timeline()
	{
		session_start();

		if (isset($_SESSION['id']) && isset($_SESSION['nome'])) {

			$tweet = Container::getModel('Tweet');
			$tweet->setIdUsuario($_SESSION['id']);

			$tweets = $tweet->getAll();

			$this->view->tweets = $tweets;

			$usuario = Container::getModel('Usuario');
			$usuario->setId($_SESSION['id']);
			$this->view->infoUsuario = $usuario->getInfoUsuario();
			$this->view->totalTweets = $usuario->getTotalTweets();
			$this->view->totalSeguindo = $usuario->getTotalSeguindo();
			$this->view->totalSeguidores = $usuario->getTotalSeguidores();

			$this->render('timeline');
		} else {
			header('Location: /?login=erro');
		}
	}

	public function tweet()
	{
		session_start();

		if (isset($_SESSION['id']) && isset($_SESSION['nome'])) {

			$tweet = Container::getModel('Tweet');

			$tweet->setTweet($_POST['tweet']);
			$tweet->setIdUsuario($_SESSION['id']);

			$tweet->salvar();

			header('Location: /timeline');
		} else {
			header('Location: /?login=erro');
		}
	}

	public function quemSeguir()
	{
		session_start();

		if (isset($_SESSION['id']) && isset($_SESSION['nome'])) {

			$pesquisaUsuario = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : null;

			$usuarios = array();

			$usuario = Container::getModel('Usuario');
			$usuario->setId($_SESSION['id']);
			$this->view->infoUsuario = $usuario->getInfoUsuario();
			$this->view->totalTweets = $usuario->getTotalTweets();
			$this->view->totalSeguindo = $usuario->getTotalSeguindo();
			$this->view->totalSeguidores = $usuario->getTotalSeguidores();

			if (isset($pesquisaUsuario)) {
				$usuario = Container::getModel('Usuario');
				$usuario->setNome($pesquisaUsuario);
				$usuario->setId($_SESSION['id']);
				$usuarios = $usuario->getAll();
			}
			$this->view->usuarios = $usuarios;

			$this->render('quemSeguir');
		} else {
			header('Location: /?login=erro');
		}
	}

	public function acao()
	{
		session_start();

		if (isset($_SESSION['id']) && isset($_SESSION['nome'])) {
			$acao = isset($_GET['acao']) ? $_GET['acao'] : null;
			$id_usuario = isset($_GET['usuario']) ? $_GET['usuario'] : null;

			$usuario = Container::getModel('Usuario');
			$usuario->setId($_SESSION['id']);

			if ($acao == 'seguir') {
				$usuario->seguirUsuario($id_usuario);
			} else if ($acao == 'pararSeguir') {
				$usuario->pararSeguir($id_usuario);
			}

			header('Location: /quemSeguir');
		} else {
			header('Location: /?login=erro');
		}

	}

	public function removerTweet() {
		session_start();

		if (isset($_SESSION['id']) && isset($_SESSION['nome'])) {
			$tweet = Container::getModel('Tweet');

			$tweet->removerTweet($_GET['tweet']);
		} else {
			header('Location: /?login=erro');
		}

		header('Location: /timeline');
	}
}



