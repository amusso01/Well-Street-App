<?php
return array(
'title'=>'Holiday',
'FILE_ROOT'=>$FILE_ROOT,
'self'=>$self,
'user'=>htmlentities($_SESSION['employee']),
'user_id'=>htmlentities($_SESSION['employee_id']),
'homeLink'=>$_SESSION['user']
);