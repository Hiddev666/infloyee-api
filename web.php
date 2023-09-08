<?php
use Api\Auth\AuthController;
use Api\EmployeeController;

require_once('api/EmployeeController.php');
require_once('api/auth/AuthController.php');

$employees = new EmployeeController();
$auth = new AuthController();
$requestMethod = $_SERVER["REQUEST_METHOD"];


switch($requestMethod) {
    case 'GET' : 
        if(!empty($_GET['nrp'])) {
            $employees->show($_GET['nrp']);
        } else {
            $employees->index();
        }
        break;
    case 'POST' :
        if(!empty($_GET['nrp'])) {
            $employees->update($_GET['nrp']);
        } else if (!empty($_GET['page'])) {
            $auth->login();
        } else {
            $employees->insert();
        }
        break;
    case 'DELETE' :
        $employees->delete($_GET['nrp']);
        break;
    default :
        echo json_encode([
            'status' => 404,
            'message' => 'Route or Method not found!'
        ]);
        http_response_code(404);
}


?>