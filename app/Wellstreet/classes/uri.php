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
        $this->getArray=$getArray;
    }

    /**--------Setter-------*/

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
