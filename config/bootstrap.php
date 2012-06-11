<?php

use lithium\core\Libraries;
use lithium\core\ConfigException;
use lithium\template\View;
use lithium\net\http\Media;
use lithium\util\Set;

// Define path to plugin and other constants
defined('SMARTY_VERSION') OR define('SMARTY_VERSION', '3.1.10'); // Allows us to test different versions without breaking things
defined('LI3_SMARTY_PATH') OR define('LI3_SMARTY_PATH', dirname(__DIR__));
defined('LI3_SMARTY_LIB') OR define('LI3_SMARTY_LIB', dirname(__DIR__) . "/libraries/Smarty/" . SMARTY_VERSION . "/libs/");

Libraries::add('Smarty', array(
    "path" => LI3_SMARTY_LIB,
    "bootstrap" => "Smarty.class.php",
));

$defaults = array(
    'view' => '\lithium\template\View',
    'renderer' => '\li3_smarty\template\view\adapter\Smarty',
    'paths' => array(
        'template' => array(
            LITHIUM_APP_PATH . '/views/{:controller}/{:template}.{:type}.tpl',
            '{:library}/views/{:controller}/{:template}.{:type}.tpl',
        ),
        'element' => array(
            LITHIUM_APP_PATH . '/views/elements/{:template}.html.tpl',
            '{:library}/views/elements/{:template}.html.tpl'
        ),
        'layout' => false
    ),
    'compile_dir' => LITHIUM_APP_PATH . '/resources/templates_c',
    'cache_dir' => LITHIUM_APP_PATH . '/resources/cache',
    'template_dir' => array(
        LITHIUM_APP_PATH . "/views",
        LITHIUM_APP_PATH . "/views/pages"
    ),
    'plugin_dir' => array(
        LI3_SMARTY_PATH . "/plugins",
        LITHIUM_APP_PATH . "/extensions/plugins"
    )
);

$keys = array_intersect_key($config, $defaults);
foreach ($keys as $key => $val) {
    if (is_array($defaults[$key])) {
        $defaults[$key] = Set::merge($defaults[$key], $config[$key]);
    }
    else {
        $defaults[$key] = $val;
    }
}

/**
 * Map to the new renderer
 */
Media::type('default', null, $defaults);

?>
