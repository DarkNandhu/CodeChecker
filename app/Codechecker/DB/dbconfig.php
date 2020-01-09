<?php
namespace Codechecker\DB;
use PDO;
use PDOException;
class dbconfig{
private  $host = 'localhost';
private  $user = 'root';
private  $password = '';
private  $database = 'codechecker';
private  $driver = 'mysql';
private  $pdo;
//DB init routines
public function __construct(){
    $dsn = $this->driver.':host='. $this->host .';dbname='.$this->database;
    try{
    if(!$this->pdo = new PDO($dsn, $this->user, $this->password)){
        throw new PDOException('failed to connect PHP PDO extension might not be installed', 0, 0);
    }
    }
    catch(PDOException $e){
        throw new PDOException('failed to connect '.$e->getMessage(), 0, $e);
    }
}


//Routines for insert

public function insert($sql, $placeholders=null){
    $stmt = $this->querybuilder($sql, $placeholders);
    return $this->pdo->lastInsertId();   
}
//Routines for selection

public function select($sql, $placeholders=null){
$stmt = $this->querybuilder($sql, $placeholders);
return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

public function delete($sql, $placeholders=null){
    $stmt = $this->querybuilder($sql, $placeholders);
    return $stmt->rowCount();   
}


public function update($sql, $placeholders=null){
    $stmt = $this->querybuilder($sql, $placeholders);
    return "Updated Successfully";   
}


//Query Builder 
public function querybuilder($sql, $placeholders = null){
    try
    {
    if(!$stmt = $this->pdo->prepare($sql)){
    $error = $this->pdo->errorInfo();
    throw new PDOException("ERROR : ".$error[0],0);
}
if(is_array($placeholders)){
    foreach($placeholders as $key => $placeholder){
        if(is_int($key)){
            $key++;
        }
        if(!$stmt->bindParam($key, $placeholders[$key])){
            $error = $stmt->errorInfo();
            throw new PDOException("ERROR : ".$error[0],0);
        }
    }
}
if(!$stmt->execute()){
    $error = $stmt->errorInfo();
    throw new PDOException("ERROR : ".$error[0],0);
}
return $stmt;
}
catch(PDOException $e){
    return $e->getMessage();
}
}
}
