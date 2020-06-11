<?php
class User{
  
    // database connection and table name
    private $conn;
    private $table_name = "user";
  
    // object properties
    public $id;
    public $name;
    public $email;
    public $token;
    public $city;
    public $region;
    public $country;
    public $account_type;
    public $status;
    public $is_premium;
    public $is_onboarded;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
    
        // select all query
        $query = "SELECT * FROM " . $this->table_name;
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // create product
    function create(){
    
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET
                    name=:name, 
                    email=:email, 
                    token=:token, 
                    city=:city,
                    region=:region,
                    country=:country,
                    account_type=:account_type, 
                    status=:status,
                    is_premium=:is_premium, 
                    is_onboarded=:is_onboarded";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->token=htmlspecialchars(strip_tags($this->token));
        $this->city=htmlspecialchars(strip_tags($this->city));
        $this->region=htmlspecialchars(strip_tags($this->region));
        $this->country=htmlspecialchars(strip_tags($this->country));
        $this->account_type=htmlspecialchars(strip_tags($this->account_type));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->is_premium=htmlspecialchars(strip_tags($this->is_premium));
        $this->is_onboarded=htmlspecialchars(strip_tags($this->is_onboarded));
    
        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":token", $this->token);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":region", $this->region);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":account_type", $this->account_type);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":is_premium", $this->is_premium);
        $stmt->bindParam(":is_onboarded", $this->is_onboarded);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
    // used when filling up the update product form
    function login(){
    
        // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email ";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of product to be updated
        $stmt->bindParam(":email", $this->email);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->id=$row['id'] ?? null;
        $this->name=$row['name'] ?? null;
        $this->email=$row['email'] ?? null;
        $this->token=$row['token'] ?? null;
        $this->city=$row['city'] ?? null;
        $this->region=$row['region'] ?? null;
        $this->country=$row['country'] ?? null;
        $this->account_type=$row['account_type'] ?? null;
        $this->status=$row['status'] ?? null;
        $this->is_premium=$row['is_premium'] ?? null;
        $this->is_onboarded=$row['is_onboarded'] ?? null;
    }

    // used when filling up the update product form
    function readOne(){
    
        // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email ";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of product to be updated
        $stmt->bindParam(":email", $this->email);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->id=$row['id'] ?? null;
        $this->name=$row['name'] ?? null;
        $this->email=$row['email'] ?? null;
        $this->token=$row['token'] ?? null;
        $this->city=$row['city'] ?? null;
        $this->region=$row['region'] ?? null;
        $this->country=$row['country'] ?? null;
        $this->account_type=$row['account_type'] ?? null;
        $this->status=$row['status'] ?? null;
        $this->is_premium=$row['is_premium'] ?? null;
        $this->is_onboarded=$row['is_onboarded'] ?? null;
    }

    // update the product
    function update(){
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    User_Number=:User_Number, 
                    First_Name=:First_Name, 
                    Middle_Name=:Middle_Name, 
                    Last_Name=:Last_Name, 
                    Address=:Address,
                    Contact_Number=:Contact_Number, 
                    Account_Type=:Account_Type, 
                    Account_Status=:Account_Status, 
                    password=:password, 
                    Account_Picture=:Account_Picture
                WHERE
                    iduser = :iduser";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->iduser=htmlspecialchars(strip_tags($this->iduser));
        $this->User_Number=htmlspecialchars(strip_tags($this->User_Number));
        $this->First_Name=htmlspecialchars(strip_tags($this->First_Name));
        $this->Middle_Name=htmlspecialchars(strip_tags($this->Middle_Name));
        $this->Last_Name=htmlspecialchars(strip_tags($this->Last_Name));
        $this->Address=htmlspecialchars(strip_tags($this->Address));
        $this->Contact_Number=htmlspecialchars(strip_tags($this->Contact_Number));
        $this->Account_Type=htmlspecialchars(strip_tags($this->Account_Type));
        $this->Account_Status=htmlspecialchars(strip_tags($this->Account_Status));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->Account_Picture=htmlspecialchars(strip_tags($this->Account_Picture));
    
        // bind values
        $stmt->bindParam(":iduser", $this->iduser);
        $stmt->bindParam(":User_Number", $this->User_Number);
        $stmt->bindParam(":First_Name", $this->First_Name);
        $stmt->bindParam(":Middle_Name", $this->Middle_Name);
        $stmt->bindParam(":Last_Name", $this->Last_Name);
        $stmt->bindParam(":Address", $this->Address);
        $stmt->bindParam(":Contact_Number", $this->Contact_Number);
        $stmt->bindParam(":Account_Type", $this->Account_Type);
        $stmt->bindParam(":Account_Status", $this->Account_Status);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":Account_Picture", $this->Account_Picture);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete the product
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE iduser = :iduser";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->iduser=htmlspecialchars(strip_tags($this->ididuser));
    
        // bind id of record to delete
        $stmt->bindParam(":iduser", $this->iduser);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // search products
    function search($keywords){
    
        // select all query
        $query = "SELECT * FROM " . $this->table_name . " WHERE First_Name LIKE :First_Name OR Middle_Name LIKE :Middle_Name OR Last_Name LIKE :Last_Name";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
    
        // bind
        $stmt->bindParam(":First_Name", $keywords);
        $stmt->bindParam(":Middle_Name", $keywords);
        $stmt->bindParam(":Last_Name", $keywords);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }
    // read products with pagination
    public function readPaging($from_record_num, $records_per_page){
    
        // select query
        $query = "SELECT * FROM " . $this->table_name . " LIMIT ?, ?";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
    
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
    }

    // used for paging products
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_rows'];
    }
}
?>