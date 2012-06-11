<?php

namespace li3_smarty\template\view\adapter;

use \lithium\core\Libraries;
use \lithium\core\Environment;

class Smarty extends \lithium\template\view\Renderer {

    protected $_smarty;

    public function __construct($config = array()) {
        $this->_smarty = new \Smarty();

        $this->_smarty->compile_dir = $config['compile_dir'];
        $this->_smarty->cache_dir = $config['cache_dir'];
        $this->_smarty->setTemplateDir($config['template_dir']);
        $this->_smarty->addPluginsDir($config['plugin_dir']);

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

        $template__ = (is_array($template)) ? $template[0] : $template;
        $flipped_path = array_reverse(explode("/", $template__));

        $isLayout = (preg_match('/layouts/', $flipped_path[0]) OR $flipped_path[1] == 'layouts') ? true : false;
        $isElement = (preg_match('/elements/', $flipped_path[0]) OR $flipped_path[1] == 'elements') ? true : false;
        $isView = (!$isLayout AND !$isElement) ? true : false;

        $data = array_merge($this->_toString($context), $this->_toString($data));

        // pass lithium data to smarty
        $this->_smarty->assign($data);
        $this->_smarty->assignByRef('this', $this);

        $parsedSmarty = $this->_smarty->fetch($template);

        return $parsedSmarty;
    }

}
