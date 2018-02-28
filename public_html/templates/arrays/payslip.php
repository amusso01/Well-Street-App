<?php
return array(
    'title'=>'Payslip',
    'FILE_ROOT'=>$FILE_ROOT,
    'self'=>$self,
    'user'=>htmlentities($_SESSION['uName']),
    'homeLink'=>$_SESSION['admin']
);