<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../models/schedule.php';
 
$database = new Database();
$db = $database->getConnection();
 
$schedule = new Schedule($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 

if (empty($data->Description) && empty($data->Title) && empty($data->Date)) {
  http_response_code(400);         
  echo json_encode(array("mensagem" => "Descrição, Título e Data são campos obrigatórios."));
  return;  
}
if (empty($data->Id_Provider)) {  
  http_response_code(400);         
  echo json_encode(array("mensagem" => "É necessário o código do Prestador de serviço"));
  return;
}
if (empty($data->Id_Service)) {  
  http_response_code(400);         
  echo json_encode(array("mensagem" => "É necessário o código do serviço"));
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

$schedule->Description = $data->Description;
$schedule->Date = date('Y-m-d H:i:s',strtotime($data->Date));
$schedule->Title = $data->Title;
$schedule->Id_Provider = $data->Id_Provider;
$schedule->Id_Service = $data->Id_Service;


$newId = $schedule->create();

if($newId != 0){    
    http_response_code(201);  
    echo json_encode(array("Id_Schedule" => $newId));
} 
else{        
    http_response_code(400);         
    echo json_encode(array("mensagem" => "Não foi possível criar agendamento."));
}
?>