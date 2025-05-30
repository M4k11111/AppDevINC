<?php 
include_once("./models/get.php");
include_once("./config/database.php");

$db = new Connection();
$pdo = $db->connect();
$get = new Get($pdo);

$request = explode("/", $_REQUEST['request']);

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method) {
	case 'GET':

		switch($request[0]) {
			case 'getstudents':
				echo json_encode($get->getStudents());
				break;
			case 'getgrades':
				echo json_encode($get->getGrades());
				break;
			case 'getcourses':
				echo json_encode($get->getCourses());
				break;
		}
		break;

	case 'POST':
		// echo "This is my post method";
		break;
	
	default:
		# code...
		break;
}

$pdo = null;
?>