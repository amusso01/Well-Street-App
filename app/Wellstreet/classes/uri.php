<?php
/**
 * Class to catch the uri request in the index.php
 * Create an instance contains the uri parameter  eg. index.php/landing  the class capture the landing.php parameter
 */


namespace Wellstreet\classes;

class uri
{
    protected $getArray;
    function __construct($getArray)
    {
        $this->getArray=$getArray;//_GET array
    }

    /**--------Setter-------*/


    //retrieve the value of page inside the _GET array
    //this value will be use to call the model responsible of displaying the right template
    protected function extractUri()
    {
        if (!isset($this->getArray['page'])) {
            $file = 'home';
        } else {
            $file = $this->getArray['page'];
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
