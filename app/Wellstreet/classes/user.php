<?php
/**
 * Created by PhpStorm.
 * User: desktop
 * Date: 2/1/2018
 * Time: 12:06 PM
 */

namespace Wellstreet\classes;


class user
{

public $table;
public $userDetails;
public $userCredentials;
protected $db;
function __construct($userDetails,$userCredentials)
{
    $this->userDetails=$userDetails;
    $this->userCredentials=$userCredentials;
}

//escape each user imputed value before query the database
protected function dbEscape($detail){
    foreach ($detail as $key=>$value) {
        $detail[$key]=mysqli_real_escape_string($this->db,$value);
    }
}
//Build the INSERT query you need
//@value array of details to insert, array index is the table column name
//@table the table you want insert in
public function insertQuery($value, $table){
    $this->dbEscape($value);
    $query="INSERT INTO $table (";
    foreach ($value as $key => $details){
        $query.="$key,";
    }
    $query=rtrim($query,',');
    $query.=")
    VALUES (";
    foreach ($value as $details){
        $query.="'$details',";
    }
    $query=rtrim($query,',');
    $query.=")";
    return $query;
}

public function pushToDb(){
$query=$this->insertQuery($this->userCredentials,'users');
//    try{
//        $this->db->begin_transaction();
//        $this->db->query($query);
//        $userId=$this->db->insert_id;
        return $query;
//        $details=array_push($this->userDetails,)
//    }
}

public function getCredentials(){
    return $this->userCredentials;
}

public function setDb($mysql){
    $this->db=$mysql;
}

}