<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../models/service.php';
 
$database = new Database();
$db = $database->getConnection();
 
$service = new Service($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 

if (empty($data->Description) && empty($data->Title) && empty($data->Date) && empty($data->Value)) {
  http_response_code(400);         
  echo json_encode(array("mensagem" => "Descrição, Título, Valor e Data são campos obrigatórios."));
  return;  
}
if (empty($data->Id_User)) {  
  http_response_code(400);         
  echo json_encode(array("mensagem" => "É necessário o código do usuário"));
  return;
}
if (empty($data->Id_Type_Service)) {  
  http_response_code(400);         
  echo json_encode(array("mensagem" => "É necessário o código do tipo de serviço"));
  return;
}

date_default_timezone_set('America/Sao_Paulo');

$dataJson = date("d/m/Y H:i A",strtotime($data->Date));
$dataAtual = date("d/m/Y H:i A");

if ($dataJson < $dataAtual) {
  http_response_code(400);         
  echo json_encode(array("mensagem" => "A data deve ser maior que a atual"));
  return;
}

$service->Description = $data->Description;
$service->Date = date('Y-m-d H:i:s',strtotime($data->Date));
$service->Title = $data->Title;
$service->Value = $data->Value;
$service->Id_User = $data->Id_User;
$service->Id_Type_Service = $data->Id_Type_Service;


$newId = $service->create();

if($newId != 0){    
    http_response_code(201);  
    echo json_encode(array("Id_Service" => $newId));
} 
else{        
    http_response_code(400);         
    echo json_encode(array("mensagem" => "Não foi possível criar serviço."));
}
?>