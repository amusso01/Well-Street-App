<?php
return array(
    'title'=>'BOH rota',
    'FILE_ROOT'=>$FILE_ROOT,
    'self'=>$self,
    'user'=>htmlentities($_SESSION['uName']),
    'department'=>'Back of house',
    'homeLink'=>$_SESSION['admin']
);