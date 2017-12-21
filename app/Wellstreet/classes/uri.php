<?php
/**
 * Class to catch the uri request in the index.php
 * Create an instance that contains the uri parameter
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
            $this->uri='home.php';
        }else{
            $this->uri=str_replace($this->fileRoot,'',$this->uri).'.php';
        }
    }


    /**--------Getter----------*/
    /**
     * @return current uri
     */
    public function getUri()
    {
        $this->extractUri();
        return $this->uri;
    }

}
