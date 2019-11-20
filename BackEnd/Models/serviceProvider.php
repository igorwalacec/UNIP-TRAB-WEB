<?php
class ServiceProvider
{     
    private $connection;
    private $table_name = "service_provider";
     
    public $Id_Service;    
    public $Id_Provider;
     
    public function __construct($db)
    {
        $this->connection = $db;
    }        
    function catchService()
    {

        $query = 
        "INSERT INTO $this->table_name SET Id_Service=:Id_Service, Id_Provider=:Id_Provider";
                 
        $stmt = $this->connection->prepare($query);
        
        $this->Id_Provider=htmlspecialchars(strip_tags($this->Id_Provider));
        $this->Id_Service= htmlspecialchars(strip_tags($this->Id_Service));
                        
        $stmt->bindParam(":Id_Service", $this->Id_Service);
        $stmt->bindParam(":Id_Provider", $this->Id_Provider);
        
        if($stmt->execute()){            
            return true;
        }else{
            return false;
        }
    }  
}
?>