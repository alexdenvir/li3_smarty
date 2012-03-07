<?php

use lithium\core\Libraries;
use lithium\core\ConfigException;
use lithium\template\View;
use lithium\net\http\Media;
use Smarty\template\view\adapter\Smarty;

Libraries::add('Smarty', array(
            'path' => LITHIUM_LIBRARY_PATH . '/Smarty/_source/Smarty-3.1.8/libs',
            'includePath' => true,
            'bootstrap' => false
        ));
require_once("Smarty.class.php");

include(__DIR__ . "/../template/view/adapter/Smarty.php");

Media::type('default', null, array(
            'view' => '\lithium\template\View',
            'renderer' => '\Smarty\template\view\adapter\Smarty',
            'paths' => array(
                'template' => '{:library}/views/{:controller}/{:template}.{:type}.tpl',
                'layout' => '{:library}/views/layouts/{:layout}.{:type}.tpl'
            )
        ));
?>
