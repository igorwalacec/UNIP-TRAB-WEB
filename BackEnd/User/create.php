<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../models/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
if (empty($data->Name) && empty($data->Email) && empty($data->Password)) {
  http_response_code(400);         
  echo json_encode(array("mensagem" => "Nome, Email e Senha são campos obrigatórios."));
  return;  
}
if (!empty($data->Id_Provider)) {
  $user->Id_Provider = $data->Id_Provider;  
}


$user->Name = $data->Name;
$user->Email = $data->Email;
$user->Password = $data->Password;
$user->Created_at = date('Y-m-d H:i:s');

$newId = $user->create();

if($newId != 0){    
    http_response_code(201);  
    echo json_encode(array("id_user" => $newId));
} 
else{        
    http_response_code(400);         
    echo json_encode(array("mensagem" => "Não foi possível criar usuário."));
}
?>