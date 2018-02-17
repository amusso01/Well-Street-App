<?php
return array(
    'title'=>'FOH rota',
    'FILE_ROOT'=>$FILE_ROOT,
    'self'=>$self,
    'user'=>htmlentities($_SESSION['uName']),
    'department'=>'Front of house',
    'page'=>'adminrotafoh',
    'homeLink'=>$_SESSION['admin']

);