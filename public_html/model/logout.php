<?php
echo 'thanks';
session_regenerate_id();
logOut();
header( 'refresh:4;url=index.php' );