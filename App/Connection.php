<?php

namespace App;

class Connection {
	public static function getDBConnection() {
		try {
			$HOST = 'localhost';
			$DBNAME = 'twitterClone';
			$USER = 'leonardo';
			$PASS = 'p4ss*';

			$conn = new \PDO("mysql:host=$HOST;dbname=$DBNAME;charset=utf8",
							$USER, $PASS);

			return $conn;
		} catch (\PDOException $e) {
			echo $e;
		}
	}
}