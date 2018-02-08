<?php
return array(
    'title'=>'Search page',
    'FILE_ROOT'=>$FILE_ROOT,
    'self'=>$self,
    'user'=>htmlentities($_SESSION['uName']),
    'homeLink'=>$_SESSION['admin']
);