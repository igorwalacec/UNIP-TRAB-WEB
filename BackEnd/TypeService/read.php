<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
 
include_once '../Config/database.php';
include_once '../Models/typeService.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$typeService = new TypeService($db);



 $stmt = $typeService->read();
 $num = $stmt->rowCount();
 
if($num>0){
 
    // products array
    $typeServices_list=array();
    $typeServices_list["result"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){        
        extract($row);
 
        $typeService_item=array(
            "id" => $id_type_service,            
            "description" => html_entity_decode($description),
        );
 
        array_push($typeServices_list["result"], $typeService_item);
    }
    
    http_response_code(200);
     
    echo json_encode($typeServices_list);
}else{ 
  http_response_code(404);

  echo json_encode(
      array("message" => "Não foram encotrandos serviços.")
  );
}
?>