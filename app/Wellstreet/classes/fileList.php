<?php
/**
 * Created by PhpStorm.
 * User: eandr
 * Date: 21/12/2017
 * Time: 16:36
 */


namespace Wellstreet\classes;

class fileList
{

    protected $getPage;
    protected $templateList;
    protected $templateArray;
    protected $viewList;

    function __construct($getPage, $templateList, $templateArray, $viewList)
    {
       $this->getPage=$getPage;
       $this->templateList=$this->stripFile($templateList);
       $this->templateArray=$this->stripFile($templateArray);
       $this->viewList=$this->stripFile($viewList);
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

    // return the name of the view required
    protected function getView(){
        $controller=$this->getPage.'.php';
        foreach ($this->viewList as $value){
            if($value==$controller){
                    return $value;
            }
        }
        return '404.php';
    }


    public function getTemplate(){
        $template=$this->getPage.'.html.twig';
        foreach ($this->templateList as $value){
            if ($value == $template){
                return $template;
            }
        }
        return '404.html.twig';
    }

    //return the array of the parameter of the specific template to render with Twig
    public function getArray(){
    $templateVariables=$this->getPage.'.php';
    foreach ($this->templateArray as $value){
        if ($templateVariables==$value){
            return $templateVariables;
        }
    }
    return '404.php';

    }

    public function displayView(){
        $finalView=$this->getView();
        foreach ($this->viewList as $view){
            switch ($finalView){
                case $view:
                    return __DIR__ . '/../../../public_html/view/' .$finalView;
                    break;
            }
        }
        return __DIR__ . '/../../../public_html/view/404.php';
    }



}