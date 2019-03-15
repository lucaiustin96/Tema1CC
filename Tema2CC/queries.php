<?php 
	class Queries {
		public function __construct($db) {
			$this -> conn = $db;
		}

		public function getall() {
			$stmt = $this -> conn -> prepare('SELECT * FROM students');
			$stmt->execute();
			return $stmt;
		}

		public function getid($id) {
			$stmt = $this -> conn -> prepare('SELECT * FROM students WHERE id = ' . $id);
			$stmt->execute();
			return $stmt;
		}

		public function post($nume, $prenume, $email, $facultate) {
			try {
			    $stmt = $this -> conn ->prepare("INSERT INTO students (nume, prenume, email, facultate) VALUES (:nume, :prenume, :email, :facultate)");
			    $stmt->bindParam(':nume', $nume);
			    $stmt->bindParam(':prenume', $prenume);
			    $stmt->bindParam(':email', $email);
			    $stmt->bindParam(':facultate', $facultate);

			 	$stmt->execute();
			 	return 1;
			    }
			catch(PDOException $e)
			    {
			    echo "Error: " . $e->getMessage();
			    }
			$conn = null;
		}

		public function update($id, $nume, $prenume, $email, $facultate) {
			try {
			    $stmt = $this -> conn ->prepare("UPDATE students SET nume = :nume, prenume = :prenume, email = :email, facultate = :facultate WHERE id = :id");
			    $stmt->bindParam(':nume', $nume);
			    $stmt->bindParam(':prenume', $prenume);
			    $stmt->bindParam(':email', $email);
			    $stmt->bindParam(':facultate', $facultate);
			    $stmt->bindParam(':id', $id);

			 	$stmt->execute();
			 	return 1;
			    }
			catch(PDOException $e)
			    {
			    echo "Error: " . $e->getMessage();
			    }
			$conn = null;
		}

		public function delete($id) {
			try {
			    $stmt = $this -> conn ->prepare("DELETE FROM students WHERE id = :id");
			    $stmt->bindParam(':id', $id);
			 	$stmt->execute();
			 	return 1;
			    }
			catch(PDOException $e)
			    {
			    echo "Error: " . $e->getMessage();
			    }
			$conn = null;
		}

		public function getMaxId() {
			try {
			    $stmt = $this->conn->prepare("SELECT MAX(id) FROM students");
			 	$stmt->execute();
			 	return $stmt;
			    }
			catch(PDOException $e)
			    {
			    echo "Error: " . $e->getMessage();
			    }
			$conn = null;
		}
	}
?>