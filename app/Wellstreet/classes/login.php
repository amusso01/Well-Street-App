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
    protected $postArray;
    protected $mysqli;
    public $username;
    public $password;
    public $errorArray;
    protected $sqlUsername;


    function __construct($postArray,$mysqli,$sqlUsername)
    {
        $this->mysqli=$mysqli;
        $this->postArray=$postArray;
        $this->sqlUsername=$sqlUsername;
        $this->password=$this->setPass();
        $this->errorArray=array();
        $this->username=$this->setUser();
    }

    protected function setPass(){
        return mysqli_real_escape_string($this->postArray['pass']);
    }

    protected function setUser(){
        return mysqli_real_escape_string($this->postArray['username']);
    }


}