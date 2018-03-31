<?php
return array(
    'title'=>'Holiday',
    'FILE_ROOT'=>$FILE_ROOT,
    'self'=>$self,
    'user'=>htmlentities($_SESSION['uName']),
    'homeLink'=>$_SESSION['admin']
);