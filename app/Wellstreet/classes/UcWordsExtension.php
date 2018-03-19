<?php
/*

	== Twig UcWordsExtension ==

	== AUTHOR ==

		lxg
		https://stackoverflow.com/questions/31145361/how-to-call-ucwords-in-twig

*/

namespace Wellstreet\classes;

class UcWordsExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('ucwords', 'ucwords')
        ];
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('ucwords', 'ucwords')
        ];
    }

    public function getName()
    {
        return 'ext.ucwords';
    }

}