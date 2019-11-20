<?php
class Service
{     
    private $connection;
    private $table_name = "service";
    
    public $Id_Provider;
    public $Id_Service;    
    public $Description;
    public $Date;
    public $Title;
    public $Value;
    public $Id_User;
    public $Name_User;
    public $Id_Type_Service;
    public $Name_Type_Service;
     
    public function __construct($db)
    {
        $this->connection = $db;
    }    
    function getServicesByUser(){
        $query = 
        "select 
            t1.Id_Service,t1.Title, t1.Description as DescriptionService,t1.Date,t1.Value, t2.Id_User, t2.Name, t3.Id_Type_Service, t3.Description as  DescriptionTypeService
        from 	Service t1
        inner	join	user t2
        on		t1.Id_User = t2.Id_User
        inner	join type_service t3
        on		t1.Id_Type_Service = t3.Id_Type_Service
        left	join	service_provider t4
        on		t1.Id_Service = t4.Id_Service
        WHERE   t4.Id_Service is not null and t1.Id_User = $this->Id_User";

        $stmt = $this->connection->prepare($query);

        $stmt->execute();
    
        return $stmt;
    }
    function getServicesByProvider()
    {
        $query = 
            "select 
                t1.Id_Service,t1.Title, t1.Description as DescriptionService,t1.Date,t1.Value, t2.Id_User, t2.Name, t3.Id_Type_Service, t3.Description as  DescriptionTypeService
            from 	Service t1
            inner	join	user t2
            on		t1.Id_User = t2.Id_User
            inner	join type_service t3
            on		t1.Id_Type_Service = t3.Id_Type_Service
            left	join	service_provider t4
            on		t1.Id_Service = t4.Id_Service
            WHERE   t4.Id_Provider = $this->Id_Provider";
            

            $stmt = $this->connection->prepare($query);

            $stmt->execute();
        
            return $stmt;
    }
    function getServicesByDateNow($id_Type_Service)
    {
        $query = "";
        if (empty($id_Type_Service)) {
            $query = 
            "select 
                t1.Id_Service,t1.Title, t1.Description as DescriptionService,t1.Date,t1.Value, t2.Id_User, t2.Name, t3.Id_Type_Service, t3.Description as  DescriptionTypeService
            from 	Service t1
            inner	join	user t2
            on		t1.Id_User = t2.Id_User
            inner	join type_service t3
            on		t1.Id_Type_Service = t3.Id_Type_Service
            left	join	service_provider t4
            on		t1.Id_Service = t4.Id_Service
            where	t1.Date > Now() and t4.Id_Service is null";          
        }else{
            $query = 
            "select 
                t1.Id_Service,t1.Title, t1.Description as DescriptionService,t1.Date,t1.Value, t2.Id_User, t2.Name, t3.Id_Type_Service, t3.Description as  DescriptionTypeService
            from 	Service t1
            inner	join	user t2
            on		t1.Id_User = t2.Id_User
            inner	join type_service t3
            on		t1.Id_Type_Service = t3.Id_Type_Service
            left	join	service_provider t4
            on		t1.Id_Service = t4.Id_Service
            where	t1.Date > Now() and t4.Id_Service is null AND t1.Id_Type_Service = $id_Type_Service";
        }
        
                
        $stmt = $this->connection->prepare($query);

        $stmt->execute();
    
        return $stmt;
    }
    function create()
    {

        $query = 
        "INSERT INTO $this->table_name SET Description=:Description, Date=:Date, 
        Title=:Title, Value=:Value, Id_User=:Id_User, Id_Type_Service=:Id_Type_Service";
                 
        $stmt = $this->connection->prepare($query);
        
        $this->Title=htmlspecialchars(strip_tags($this->Title));
        $this->Description= htmlspecialchars(strip_tags($this->Description));
        $this->Date=htmlspecialchars(strip_tags($this->Date));
        $this->Value=htmlspecialchars(strip_tags($this->Value));
        $this->Id_User=htmlspecialchars(strip_tags($this->Id_User));
        $this->Id_Type_Service=htmlspecialchars(strip_tags($this->Id_Type_Service));        
                        
        $stmt->bindParam(":Description", $this->Description);
        $stmt->bindParam(":Date", $this->Date);
        $stmt->bindParam(":Title", $this->Title);
        $stmt->bindParam(":Value", $this->Value);
        $stmt->bindParam(":Id_User", $this->Id_User);
        $stmt->bindParam(":Id_Type_Service", $this->Id_Type_Service);
                
        // execute query
        if($stmt->execute()){            
            return $this->connection->lastInsertId();            
        }else{
            return 0;
        }
    }  
}
?>