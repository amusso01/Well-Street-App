<?php

require_once __DIR__.'/../config/start.php';





$uri= new \Wellstreet\classes\uri($FILE_ROOT);





echo $uri->getUri();
//echo $_SERVER['HTTP_HOST'];
