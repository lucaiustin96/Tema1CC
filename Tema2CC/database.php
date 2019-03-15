<?php
	class Database {
		public function connection() {
			$this -> conn = null;
			try {
			    $this -> conn  = new PDO('mysql:host=localhost;dbname=tema2cc', 'root', '');
			    
			} catch (PDOException $e) {
			    print "Error!: " . $e->getMessage() . "<br/>";
			    die();
			}
			return $this -> conn;
		}
	}

?>