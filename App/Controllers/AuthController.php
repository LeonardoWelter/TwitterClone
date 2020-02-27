<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action{

	public function autenticar() {

		$usuario = Container::getModel('Usuario');

		$usuario->setEmail($_POST['email']);
		$usuario->setSenha(md5($_POST['senha']));

		$retorno = $usuario->autenticar();

		if ($usuario->getId() != '' && $usuario->getNome() != '') {

			session_start();

			$_SESSION['id'] = $usuario->getId();
			$_SESSION['nome'] = $usuario->getNome();

			header('Location: /timeline');
		} else {
			header('Location: /?login=erro');
		}

	}

	public function sair() {
		session_start();
		session_destroy();

		header('Location: /');
	}

}