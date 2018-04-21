<?php

namespace Core;

/**
 * View
 */
class View {

    /**
     * Render a view file
     *
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = []) {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/App/Views/$view";  // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a view template using Twig
     *
     * @param string $template  The template file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = []) {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig_Environment($loader, [
                'cache' => dirname(__DIR__) . '/public/storage/cache/html',
                'auto_reload' => true
            ]);

            /** From Composer twig/extensions (|truncate(x)) */
            $twig->addExtension(new \Twig_Extensions_Extension_Text());

            /**
             * Slugify Filter
             */
            $slugify = new \Twig_Filter('slugify', '\Core\Funcs::slugify');
            $twig->addFilter($slugify);

            /**
             * Convert to gb/kb etc
             */
            $dconvert = new \Twig_Filter('dconvert', '\Core\Funcs::convert');
            $twig->addFilter($dconvert);

            /**
             * Allows any php functions to be used
             * {{ php_print_r(['random', 'array']) }}
             */
            $twig->addFunction(new \Twig_SimpleFunction('php_*', function(){
                $arg_list = func_get_args();
                $function = array_shift($arg_list);

                return call_user_func_array($function, $arg_list);
            },
                array('pre_escape' => 'html', 'is_safe' => array('html'))
            ));

            /**
             * Add global vars to {{ x }}
             */
            $twig->addGlobal('version', '1.32');
            
            $twig->addGlobal('app', [
                'baseUrl' => "http".(isset($_SERVER['HTTPS'])?'s':'')."://"."{$_SERVER['HTTP_HOST']}",
                'siteUrl' => "http".(isset($_SERVER['HTTPS'])?'s':'')."://"."{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}",

                'httpv' => $_SERVER['SERVER_PROTOCOL'],
                'request' => [
                    'get' => $_GET,
                    'post' => $_POST,
                    'session' => $_SESSION,
                    'cookie' => $_COOKIE,
                ]
            ]);
        }

        echo $twig->render($template, $args);
    }
}