<?php

$mysqli= new mysqli(
    $config['db_host'],
    $config['db_user'],
    $config['db_pass'],
    $config['db_name']
);

//Check connection status
if( $mysqli->connect_errno ){
    exit( 'Connection Error: '.$mysqli->connect_error);
}