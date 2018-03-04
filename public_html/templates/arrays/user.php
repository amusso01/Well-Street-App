<?php

return array(
    'title'=>'User Page',
    'FILE_ROOT'=>$FILE_ROOT,
    'self'=>$self,
    'user'=>htmlentities($_SESSION['employee']),
    'homeLink'=>$_SESSION['user']
);