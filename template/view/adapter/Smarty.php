<?php
namespace Smarty\template\view\adapter;

use \lithium\core\Libraries;
use \lithium\core\Environment;

class Smarty extends \lithium\template\view\Renderer {

    protected $_smarty;

    public function __construct($config = array()) {
        $this->_smarty = new \Smarty();

        $this->_smarty->compile_dir = \LITHIUM_APP_PATH . "/resources/templates_c";
        $this->_smarty->cache_dir = \LITHIUM_APP_PATH . "/resources/cache";
        $this->_smarty->addPluginsDir(\LITHIUM_APP_PATH . "/extensions/smarty");

        $defaults = array('classes' => array());
        parent::__construct($config + $defaults);
    }

    public function render($template, $data = array(), array $options = array()) {
        $defaults = array('context' => array());
        $options += $defaults;
        $context = array();
        $this->_context = $options['context'] + $this->_context;
        foreach (array_keys($this->_context) as $key) {
            $context[$key] = $this->__get($key);
        }
        $data = array_merge($this->_toString($context), $this->_toString($data));
        $this->_smarty->assign($data);
        $this->_smarty->assignByRef('this', $this);
        return $this->_smarty->fetch($template);
    }

}
