<?php 
	class GET {
		private $pdo;
		public function __construct(\PDO $pdo) 
		{
			$this->pdo = $pdo;
		}

		public function getStudents() {
			$sql = "SELECT * FROM students";
			$data = array();

			if($result = $this->pdo->query($sql)->fetchAll()){
				foreach($result as $record) {
					array_push($data, $record);
				}
				return $data;
			}

			return "No records found";
		}

		public function getGrades() {
			$sql = "SELECT * FROM grades";
			$data = array();

			if($result = $this->pdo->query($sql)->fetchAll()){
				foreach($result as $record) {
					array_push($data, $record);
				}
				return $data;
			}

			return "No records found";
		}

		public function getCourses() {
			$sql = "SELECT * FROM courses";
			$data = array();

			if($result = $this->pdo->query($sql)->fetchAll()){
				foreach($result as $record) {
					array_push($data, $record);
				}
				return $data;
			}

			return "No records found";
		}
	}
?>