<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../models/serviceProvider.php';
 
$database = new Database();
$db = $database->getConnection();
 
$serviceProvider = new ServiceProvider($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 

if (empty($data->Id_Provider) && empty($data->Id_Service)) {
  http_response_code(400);         
  echo json_encode(array("mensagem" => "Falta informar código do prestado e do serviço."));
  return;  
}

$serviceProvider->Id_Service = $data->Id_Service;
$serviceProvider->Id_Provider = $data->Id_Provider;

$pass =  $serviceProvider->catchService();

if($pass){    
    http_response_code(201);      
} 
else{        
    http_response_code(400);         
    echo json_encode(array("mensagem" => "Não foi possível pegar o serviço."));
}
?>