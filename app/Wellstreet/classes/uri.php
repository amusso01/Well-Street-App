<?php
/**
 * Class to catch the uri request in the index.php
 * Create an instance contains the uri parameter  eg. index.php/landing  the class capture the landing.php parameter
 */


namespace Wellstreet\classes;

class uri
{
    protected $uri;
    protected $getParameter;
    protected $fileRoot;
    function __construct($fileRoot)
    {
        $this->uri=$_SERVER['REQUEST_URI'];
        $this->fileRoot=$fileRoot;
    }


    /**--------Setter-------*/

    protected function extractUri(){

        if ($this->uri==$this->fileRoot){
            $file='home.html.twig';
        }else{
            $file=htmlentities(str_replace($this->fileRoot,'',$this->uri).'.html.twig');
        }
        return $file;
    }

    /**--------Getter----------*/

    /**
     * @return current uri parameter
     */
    public function getUri()
    {
        return $this->extractUri();
    }

}
