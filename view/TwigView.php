<?php
//die(¨twing¨);

require_once __DIR__. '/../vendor/autoload.php';

abstract class TwigView {
    private static $twig;

    public static function getTwig() {
        if (!isset(self::$twig)) {
            //Twig_Autoloader::register();
          
            $loader = new Twig_Loader_Filesystem(__DIR__. '/../templates');
            self::$twig = new Twig_Environment($loader, array('cache' => false,'debug'=>true));
        }
        return self::$twig;
    }
}
