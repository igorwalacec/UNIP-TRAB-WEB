<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: GET");
  
  include_once '../Config/database.php';
  include_once '../Models/user.php';
  
  $database = new Database();
  $db = $database->getConnection();
  
  $data = json_decode(file_get_contents("php://input"));
  $user = new User($db);

  if (empty($data->Email) || empty($data->Password)) {
    http_response_code(401);
    echo json_encode(
      array("message" => "Informe o e-mail e a senha.")      
    );
    return;
  }

  $user->Email = $data->Email;
  $user->Password = $data->Password;

  $result = $user->login();
  
  if($result)
  {
    http_response_code(200);
    echo json_encode(
      array("result" => "Login válido.")
    );
    return;
  }
  else
  { 
    http_response_code(401);

    echo json_encode(
        array("message" => "Login Inválido.")
    );
    return;
  }
?>