<?php
/**
 * Created by PhpStorm.
 * User: desktop
 * Date: 1/16/2018
 * Time: 5:21 PM
 */

namespace Wellstreet\classes;



class login
{
    public $valid;
    public $errorArray;
    public $sessionArray;
    protected $postArray;
    protected $mysqli;

    function __construct($postArray,$mysqli)
    {
        $this->mysqli=$mysqli;
        $this->postArray=$postArray;
        $this->errorArray=array();
        $this->redisplayArray=array();
        $this->sessionArray=array();
        $this->valid=false;
    }

    protected function validate(){
        $post=$this->postArray;
        if (!empty($post['pass']) && !empty($post['username'])){
            $uPass=$post['pass'];
            $uPass=mysqli_real_escape_string($this->mysqli,$uPass);
            $uName=$post['username'];
            $uName=trim($uName);
            $uName=strtolower($uName);
            $uName=mysqli_real_escape_string($this->mysqli,$uName);
            $query="SELECT * FROM users WHERE username='$uName'";
            $result=mysqli_query($this->mysqli,$query);
            if($result==false){
                die($this->mysqli->error);
            }else{
                $user= $result->fetch_assoc();
                if(password_verify($uPass,$user['password']) && $uName==$user['username']){
                    if ($user['adminaccess']==1){
                        $_SESSION = array();
                        $_SESSION['uName']=$uName;
                        $_SESSION['admin']='set';
                        header('location:?page=admin');
                    }else{
                        $_SESSION = array();
                        $_SESSION['uName']=$uName;
                        header('location:?page=user');
                    }
                }else{
                    $this->errorArray['passError']='Password is incorrect';
                    $this->errorArray['redisplayUser']=$uName;
                }
            }
        }else{

            $this->errorArray['passError']='Password is required';
        }


        }

    public function valid(){
        $this->validate();
    }


}