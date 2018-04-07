<?php
/**
 * Created by PhpStorm.
 * User: eandr
 * Date: 07/04/2018
 * Time: 15:16
 */

namespace Wellstreet\classes;


class holidayApi
{
    protected $mysqli;
    public $start;
    public $end;
    public $title;
    public $query;

    function __construct($mysqli,$query)
    {
        $this->mysqli=$mysqli;
        $this->query=$query;
    }


    //function to generate random dark color
    protected function randomColor($num){
            $hash = md5($num);
            $hex=substr($hash, 1, 2).substr($hash, 2, 2).substr($hash, 4, 2);
            return $hex;
    }

    public function allEvents(){
        $result=$this->mysqli->query($this->query);
        $json=[];
        $events = array();
        if ($result){
            while ($row=$result->fetch_assoc()){
                    $json['id']=$row['employee_id'];
                    $json['title']=$row['name'].' '.$row['surname'];
                    $json['start']=$row['holiday_start'];
                    $json['end']=$row['holiday_end'];
                    $json['color']='#'.$this->randomColor($row['employee_id']);
                    array_push($events, $json);
            }
            $jsonResult=json_encode($events);
            return $jsonResult;
        }else{
            die($this->mysqli->error());
        }
    }
}