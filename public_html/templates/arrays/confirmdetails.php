<?php
return array(
    'title'=>'Confirm Details',
    'FILE_ROOT'=>$FILE_ROOT,
    'user'=>htmlentities($_SESSION['uName']),
    'self'=>$self,
     'homeLink'=>$_SESSION['admin']
);