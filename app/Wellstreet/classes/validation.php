<?php
/**
 * Created by PhpStorm.
 * User: desktop
 * Date: 1/16/2018
 * Time: 5:21 PM
 */

namespace Wellstreet\classes;



class validation
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
//validate the login process
    protected function validateLogin(){
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
                        $this->mysqli->close();
                        header('location:?page=admin');
                    }else{
                        $_SESSION = array();
                        $_SESSION['uName']=$uName;
                        $this->mysqli->close();
                        header('location:?page=user');
                    }
                }else{
                    $this->errorArray['passError']='Password is incorrect';
                    $this->errorArray['redisplayUser']=htmlentities($uName);
                }
            }
        }else{

            $this->errorArray['passError']='Password is required';
        }


        }

    protected function sanitizeEntry(){
        foreach ($this->postArray as $key=>$value){
            if($value=='pass'){
                continue;
            }elseif(is_string($value)){
                $value=trim($value);
                $value=strtolower($value);
                $this->postArray[$key]=mysqli_real_escape_string($this->mysqli,$value);
            }else{
                continue;//todo sanitize number think just a mysqli escape is going to be enough
            }
        }
    }

    protected function addUser(){
        $this->sanitizeEntry();
        $uname=$this->postArray['uname'];
        if($uname!=''){
            if(strlen($uname)<6 || strlen($uname)>45){
                $this->errorArray['unameError']='Maximum 45 minimum 6 characters for username';
            }else{
                $number=preg_match_all("/[0-9]/",$uname);
                if($number<1){
                    $this->errorArray['unameError']='Username must contains at least 1 number';
                }else{
                    $uname=mysqli_real_escape_string($this->mysqli,$uname);
                    $query="SELECT * FROM users WHERE username='$uName'";
                    $result=mysqli_query($this->mysqli,$query);
                    if($result->num_rows!==0){
                        $this->errorArray['unameError']='Username already exist please choose a different one';
                    }else{
                    $this->sessionArray['uname']=$uname;
                    $pass=$this->postArray['pass'];
                    if($pass!=''){
                        if (strlen($pass)<8||strlen($pass)>15){
                            $this->errorArray['redisplayUser']=$uname;
                            $this->errorArray['passError']='Maximum 15 minimum 8 characters for password';
                        }else{
                            $number=preg_match_all("/[0-9]/",$pass);
                            if ($number<2){
                                $this->errorArray['redisplayUser']=$uname;
                                $this->errorArray['passError']='Password must contains at least 2 numbers';
                            }else{
                                $this->sessionArray['pass']=$pass;
                                unset($this->errorArray);
                            }
                        }
                    }

                }
            }
        }
    }
    public function validateuser(){
        $this->addUser();
    }

    public function login(){
        $this->validateLogin();
    }


}