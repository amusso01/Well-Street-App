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

    protected $template;
    protected $templateList;
    protected $classList;
    public $renderTemplate;
    public $renderVariables;

    function __construct($template,$templateList,$classList)
    {
        $this->template=$template;
        $this->templateList=$this->stripFile($templateList);
        $this->classList=$this->stripFile($classList);
        $this->renderTemplate=$this->getTemplate();
        $this->renderVariables=$this->getTemplateArray();
    }

    //Remove variables from a given array
    protected function stripFile($array){
        foreach ($array as $value){
            if (($value == ".") || ($value == "..") || ($value=="base.html.twig") || ($value=="arrays")){ //skip those file
                continue;
            }else{
                $newArray[]=$value;
            }
        }
        return $newArray;
    }

    // return the template ask by the http request to render with Twig
    public function getTemplate(){
        $template=$this->template.'.html.twig';
        foreach ($this->templateList as $value){
            if($value==$template){
                    return $value;
            }
        }
        return '404.html.twig';
    }

    //return the array of the parameter of the specific template to render with Twig
    public function getTemplateArray(){
        $array=$this->getTemplate();
        $array=str_replace('.html.twig','.php',$array);
        return $array;
    }

    //Return the class to load
    public function getClass(){
        $this->template=$this->template.'.php';
        foreach ($this->classList as $value){
            if($value==$this->template){
                return $value;
            }
        }
        return false;
    }

    //*---------Render---------*/

    public function render(){
       return $this;
    }
}