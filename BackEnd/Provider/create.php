<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../models/provider.php';
 
$database = new Database();
$db = $database->getConnection();
 
$provider = new Provider($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
if (empty($data->CNPJ) && empty($data->CPF)) {
  http_response_code(400);         
  echo json_encode(array("mensagem" => "CPF ou CNPJ é obrigatório para prestador de serviço."));
  return;  
}
if (empty($data->Phone)) {
  http_response_code(400);         
  echo json_encode(array("mensagem" => "Telefone é obrigatório."));
  return;  
}

if (!empty($data->CNPJ)) {
  $provider->CNPJ = $data->CNPJ;  
}
if (!empty($data->CPF)) {
  $provider->CPF = $data->CPF;  
}
$provider->Phone = $data->Phone;  
//$provider->created = date('Y-m-d H:i:s');

$newId = $provider->create();

if($newId != 0){    
    http_response_code(201);  
    echo json_encode(array("id_provider" => $newId));
} 
else{        
    http_response_code(400);         
    echo json_encode(array("mensagem" => "Não foi possível criar prestador de servico."));
}

?>