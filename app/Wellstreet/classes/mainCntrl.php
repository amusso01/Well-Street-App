<?php


namespace Wellstreet\classes;

class mainCntrl
{

    protected $getPage; //page _GET from the url
    protected $templateList; //name of all the template inside a specific directory
    protected $templateArray; //name of all the template array inside a specific directory
    protected $viewList; // name of all the model inside the specific directory

    function __construct($getPage, $templateList, $templateArray, $viewList)
    {
       $this->getPage=$getPage;
       $this->templateList=$this->stripFile($templateList);
       $this->templateArray=$this->stripFile($templateArray);
       $this->viewList=$this->stripFile($viewList);
    }

    //Remove variables from a given array
    //Specifically use in the template directory to retrieve the templates list
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

    // return the model required
    //based on the page url retrieve the model to call from the model list pass in the constructor
    protected function getView(){
        $controller=$this->getPage.'.php';
        foreach ($this->viewList as $value){
            if($value==$controller){
                    return $value;
            }
        }
        return '404.php';
    }

    // return the template required
    //based on the page url retrieve the template to call from the template list pass in the constructor
    //use by Twig to render the right template
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

    //return the specific path to the model required
    //if the model required doesn't exist return a 404 model
    public function displayView(){
        $finalView=$this->getView();
        foreach ($this->viewList as $view){
            if ($finalView==$view){return __DIR__ . '/../../../public_html/model/' .$finalView;}
        }
        return __DIR__ . '/../../../public_html/model/404.php';
    }



}