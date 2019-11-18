<?php
class Provider
{     
    private $connection;
    private $table_name = "provider";
     
    public $Id_Provider; 
    public $CNPJ; 
    public $Phone;
    public $CPF;    
     
    public function __construct($db)
    {
        $this->connection = $db;
    }  
      
    function create()
    {                             
        $query = "INSERT INTO $this->table_name SET CNPJ=:CNPJ, Phone=:Phone, CPF=:CPF";
            
        $stmt = $this->connection->prepare($query);
            
        $this->CNPJ= htmlspecialchars(strip_tags($this->CNPJ));
        $this->Phone=htmlspecialchars(strip_tags($this->Phone));
        $this->CPF=htmlspecialchars(strip_tags($this->CPF));      
            
        $stmt->bindParam(":CNPJ", $this->CNPJ);
        $stmt->bindParam(":Phone", $this->Phone);
        $stmt->bindParam(":CPF", $this->CPF);    
                        
        if($stmt->execute()){            
            return $this->connection->lastInsertId();            
        }else{
            return 0;
        }    
                
    }  
}
?>