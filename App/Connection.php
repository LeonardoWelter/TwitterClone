<?php

namespace App;

class Connection {
	public static function getDBConnection() {
		try {

			$conn = new \PDO("mysql:host=localhost;dbname=mvc;charset=utf8",
							'leonardo', 'p4ss*');

			return $conn;
		} catch (\PDOException $e) {
			echo $e;
		}
	}
}