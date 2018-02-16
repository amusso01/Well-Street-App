<?php
/**
 * Created by PhpStorm.
 * User: desktop
 * Date: 2/1/2018
 * Time: 12:06 PM
 */

namespace Wellstreet\classes;


use Couchbase\Exception;

class user
{


public $userDetails;
public $userCredentials;
protected $db;
function __construct($userDetails,$userCredentials)
{
    $this->userDetails=$userDetails;
    $this->userCredentials=$userCredentials;
}

//escape each user imputed value before query the database
public function dbEscape($detail){
    foreach ($detail as $key=>$value) {
        if($key=='password'){
            $this->userCredentials['password']=$this->passHash($this->userCredentials['password']);
        }else{
            $detail[$key]=mysqli_real_escape_string($this->db,$value);

        }
    }
}

protected function passHash($pass){
    return password_hash($pass,PASSWORD_DEFAULT);
}
//Build the INSERT query you need
//@value array of details to insert, array index is the table column name
//@table the table you want insert in
protected function insertQuery($value, $table){
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
    $userName=$this->userCredentials['username'];
    $query = "SELECT * FROM users WHERE username='$userName'";
    $result = mysqli_query($this->db, $query);
    if($result->num_rows == 0){
        try{
            $query=$this->insertQuery($this->userCredentials,'users');
            $this->db->begin_transaction();
            $this->db->query($query);
            $userId['user_id']=$this->db->insert_id;
            $userDetails=array_merge($this->userDetails,$userId);
            $query=$this->insertQuery($userDetails,'employees');
            $this->db->query($query);
            $this->db->commit();
        }catch (Exception $e){
            $this->db->rollback();
        }
    }else{
        header( 'location:?page=confirmed' );
    }
}

public function setDb($mysql){
    $this->db=$mysql;
}


}