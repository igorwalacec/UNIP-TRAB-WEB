<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: GET");
  
  include_once '../Config/database.php';
  include_once '../Models/schedule.php';
  
  $database = new Database();
  $db = $database->getConnection();
  
  $schedule = new Schedule($db);

  $id_service = isset($_GET['id_service']) ? $_GET['id_service'] : "";

  $stmt = $schedule->getScheduleByDateNow($id_service);
  $num = $stmt->rowCount();
 
  if($num>0){
  
      // products array
      $schedules_list=array();
      $schedules_list["result"]=array();

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){        
          extract($row);
  
          $schedule_item=array(
              "Id_Schedule" => $Id_Schedule,
              "Description_Schedule" => html_entity_decode($DescriptionSchedule),
              "Date_Schedule" => html_entity_decode($Date),
              "Id_User" => html_entity_decode($Id_User),
              "Name_User" => html_entity_decode($Name),
              "Id_Service" => html_entity_decode($Id_Service),
              "Description_Service" => html_entity_decode($DescriptionService),
          );
  
          array_push($schedules_list["result"], $schedule_item);
      }
      
      http_response_code(200);
      
      echo json_encode($schedules_list);
  }else{ 
    http_response_code(400);

    echo json_encode(
        array("message" => "Não foram encontrados agendamentos.")
    );
  }
?>