<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: GET");
  
  include_once '../Config/database.php';
  include_once '../Models/service.php';
  
  $database = new Database();
  $db = $database->getConnection();
  
  $service = new Service($db);

  $id_service = isset($_GET['id_type_service']) ? $_GET['id_type_service'] : "";

  $stmt = $service->getServicesByDateNow($id_service);
  $num = $stmt->rowCount();
 
  if($num>0){
  
      // products array
      $services_list=array();
      $services_list["result"]=array();

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){        
          extract($row);
  
          $service_item=array(
              "Id_Service" => $Id_Service,
              "Title_Service" => html_entity_decode($Title),
              "Description_Service" => html_entity_decode($DescriptionService),
              "Date_Service" => html_entity_decode($Date),
              "Value_Service" => html_entity_decode($Value),
              "Id_User" => html_entity_decode($Id_User),
              "Name_User" => html_entity_decode($Name),
              "Id_Type_Service" => html_entity_decode($Id_Type_Service),
              "Description_Type_Service" => html_entity_decode($DescriptionTypeService),
          );
  
          array_push($services_list["result"], $service_item);
      }
      
      http_response_code(200);
      
      echo json_encode($services_list);
  }else{ 
    http_response_code(400);

    echo json_encode(
        array("message" => "Não foram encontrados serviços.")
    );
  }
?>