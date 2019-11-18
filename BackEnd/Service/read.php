<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
 
include_once '../Config/database.php';
include_once '../Models/service.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$service = new Service($db);



 $stmt = $service->read();
 $num = $stmt->rowCount();
 
if($num>0){
 
    // products array
    $services_list=array();
    $services_list["result"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){        
        extract($row);
 
        $service_item=array(
            "id" => $id_service,            
            "description" => html_entity_decode($description),
        );
 
        array_push($services_list["result"], $service_item);
    }
    
    http_response_code(200);
     
    echo json_encode($services_list);
}else{ 
  http_response_code(404);

  echo json_encode(
      array("message" => "No products found.")
  );
}
?>