<?php
class User
{     
    private $connection;
    private $table_name = "user";
         
    public $Name;
    public $Email;
    public $Password;
    public $Created_at;
    public $Updated_at;
    public $Id_Provider;
     
    public function __construct($db)
    {
        $this->connection = $db;
    }  
      
    function create()
    {                             
        $query = "INSERT INTO $this->table_name SET Name=:Name, Email=:Email, Password=:Password, Created_at=:Created_at, Id_Provider=:Id_Provider";
            
        // prepare query
        $stmt = $this->connection->prepare($query);
    
        // sanitize
        $this->Name= htmlspecialchars(strip_tags($this->Name));
        $this->Email=htmlspecialchars(strip_tags($this->Email));
        $this->Password=htmlspecialchars(strip_tags($this->Password));      
        $this->Created_at=htmlspecialchars(strip_tags($this->Created_at));              
        $this->Id_Provider=htmlspecialchars(strip_tags($this->Id_Provider));      
                
        // bind values
        $stmt->bindParam(":Name", $this->Name);
        $stmt->bindParam(":Email", $this->Email);
        $stmt->bindParam(":Password", $this->Password);    
        $stmt->bindParam(":Created_at", $this->Created_at);            
        $stmt->bindParam(":Id_Provider", $this->Id_Provider, PDO::PARAM_NULL);             
                
        // execute query
        if($stmt->execute()){            
            return $this->connection->lastInsertId();            
        }else{
            return 0;
        }    
                
    }  
    function login()
    {
      $query = 
        "SELECT
            s.id_user as id_user
        FROM
            $this->table_name s
        WHERE s.Email = '$this->Email' AND s.Password = '$this->Password'";
                        
        $stmt = $this->connection->prepare($query);

      $stmt->execute();

      $num = $stmt->rowCount();
      if ($num > 0)
      {
        return true;
      }
      else
      {
        return false;
      }
    }
}
?>
