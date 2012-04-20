<?php

use lithium\core\Libraries;
use lithium\core\ConfigException;
use lithium\template\View;
use lithium\net\http\Media;

// Define path to plugin and other constants
defined('SMARTY_VERSION') OR define('SMARTY_VERSION', '3.1.8'); // Allows us to test different versions without breaking things
defined('LI3_SMARTY_PATH') OR define('LI3_SMARTY_PATH', dirname(__DIR__));
defined('LI3_SMARTY_LIB') OR define('LI3_SMARTY_LIB', dirname(__DIR__) . "/libraries/Smarty/" . SMARTY_VERSION . "/libs/");

Libraries::add('Smarty', array(
    "path" => LI3_SMARTY_LIB,
    "bootstrap" => "Smarty.class.php",
));

/**
 * Map to the new renderer
 */
Media::type('default', null, array(
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
    )
));

?>
