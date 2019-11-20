<?php
class TypeService
{     
    private $connection;
    private $table_name = "type_service";
     
    public $id_type_service;    
    public $description;    
     
    public function __construct($db)
    {
        $this->connection = $db;
    }    
    function read()
    {
    
        // select all query
        $query = 
        "SELECT
            s.id_type_service as id_type_service, s.description as description
        FROM
            $this->table_name s";
                
        $stmt = $this->connection->prepare($query);

        $stmt->execute();
    
        return $stmt;
    }  
}
?>