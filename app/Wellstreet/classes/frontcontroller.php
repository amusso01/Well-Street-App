<?php
/**
 * Created by PhpStorm.
 * User: eandr
 * Date: 21/12/2017
 * Time: 16:36
 */


namespace Wellstreet\classes;


class frontcontroller
{
    protected $templatePath;
    protected $template;
    protected $templateList;

    function __construct($templatePath,$template,$templateList)
    {
        $this->template=$template;
        $this->templatePath=$templatePath;
        $this->templateList=$templateList;
    }

    /**--------Getter----------*/

    public function getTemplate(){
        foreach ($this->templateList as $value){
            if($value==$this->template){
                return $value;
            }
        }
        return '404.html.twig';
    }
}