<?php

header("Access-Control-Allow-Origin: *");

include_once("./models/get.php");
include_once("./models/post.php");

include_once("./config/database.php");

$db = new Connection();
$pdo = $db->connect();
$get = new Get($pdo);
$post = new Post($pdo);


// $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $segments = explode('/', $uri);
// $projectIndex = array_search('routes.php', $segments);
// if ($projectIndex !== false && $projectIndex < count($segments) - 1) {
//     $request = array_slice($segments, $projectIndex + 1);

// }


$request = explode("/", $_REQUEST['request']);

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case "GET":

        switch ($request[0]) {
            case 'getemployees':
                echo json_encode($get->getEmployees());
                break;
            case 'getaccount':
                echo json_encode($get->getAccounts());
                break;
            case 'getdtr':
                echo json_encode($get->getDTR());
                break;
            default:
                echo "Invalid endpoint.";
                break;
        }

        break;
    case "POST":
        $data = json_decode(file_get_contents("php://input"));

        switch ($request[0]) {
            case 'addtimein':
                echo json_encode($post->addTimeIn($data));
                break;
            case 'addtimeout':
                echo json_encode($post->addTimeOut($data));
                break;
            case 'registeraccount':
                echo json_encode($post->registerAccount($data));
                break;
            case "login":
                echo json_encode($post->login($data));
                break;
            case 'addemployee':
                echo json_encode($post->addEmployee($data));
                break;
            case 'editemployee':
                echo json_encode($post->editEmployee($data));
                break;

            case 'deleteemployee':
                echo json_encode($post->deleteEmployee($data));
                break;
            default:
                echo "Invalid endpoint.";
                break;
        }

        break;
    default:
        echo "Invalid Method";
        break;
}

$pdo = null;
