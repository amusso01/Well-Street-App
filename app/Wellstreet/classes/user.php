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
public $userDetails;
protected $userCredentials;
protected $db;
function __construct($userDetails,$userCredentials,$db)
{
    $this->userDetails=$userDetails;
    $this->userCredentials=$userCredentials;
    $this->db=$db;
}



}