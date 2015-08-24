<?php
/**
 */
namespace MyCode\Twig;

use Slim\Slim;

class TwigExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'mycode';
    }

    public function getGlobals()
    {
        return array(
            'req' => Slim::getInstance()->request()
        );
    }
}
