<?php
class Schedule
{     
    private $connection;
    private $table_name = "schedule";
     
    public $Id_Schedule;    
    public $Description;
    public $Date;
    public $Title;
    public $Id_Provider;
    public $Name_Provider;
    public $Id_Service;
    public $Name_Service;
     
    public function __construct($db)
    {
        $this->connection = $db;
    }    
    function getScheduleByDateNow($id_service)
    {
        $query = "";
        if (empty($id_service)) {
            $query = 
            "select 
                t1.Id_Schedule,t1.Title, t1.Description as DescriptionSchedule,t1.Date,t3.Id_User, t3.Name, t1.Id_Service, t4.Description as  DescriptionService
            from 	schedule t1
            inner	join provider t2
            on		t1.Id_Provider = t2.Id_Provider
            inner	join	user t3
            on		t2.Id_Provider = t3.Id_Provider
            inner	join service t4
            on		t1.Id_Service = t4.Id_Service
            where	t1.Date > Now()";
        }else{
            $query = 
            "select 
                t1.Id_Schedule,t1.Title, t1.Description as DescriptionSchedule,t1.Date,t3.Id_User, t3.Name, t1.Id_Service, t4.Description as  DescriptionService
            from 	schedule t1
            inner	join provider t2
            on		t1.Id_Provider = t2.Id_Provider
            inner	join	user t3
            on		t2.Id_Provider = t3.Id_Provider
            inner	join service t4
            on		t1.Id_Service = t4.Id_Service
            where	t1.Date > Now() AND t1.Id_Service = $id_service";
        }
        
                
        $stmt = $this->connection->prepare($query);

        $stmt->execute();
    
        return $stmt;
    }
    function create()
    {

        $query = 
        "INSERT INTO $this->table_name SET Description=:Description, Date=:Date, 
        Title=:Title, Id_Provider=:Id_Provider, Id_Service=:Id_Service";
                    
        $stmt = $this->connection->prepare($query);
    
        // sanitize
        $this->Description= htmlspecialchars(strip_tags($this->Description));
        $this->Date=htmlspecialchars(strip_tags($this->Date));
        $this->Title=htmlspecialchars(strip_tags($this->Title));
        $this->Id_Provider=htmlspecialchars(strip_tags($this->Id_Provider));
        $this->Id_Service=htmlspecialchars(strip_tags($this->Id_Service));
                
        // bind values
        $stmt->bindParam(":Description", $this->Description);
        $stmt->bindParam(":Date", $this->Date);
        $stmt->bindParam(":Title", $this->Title);            
        $stmt->bindParam(":Id_Provider", $this->Id_Provider);
        $stmt->bindParam(":Id_Service", $this->Id_Service);
                
        // execute query
        if($stmt->execute()){            
            return $this->connection->lastInsertId();            
        }else{
            return 0;
        }
    }  
}
?>