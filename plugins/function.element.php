<?php
	
	/**
	 * Automagical smarty plugin to expose Lithium PHP helpers for use in smarty templates
	 * {{{
	 * 	{helper init="html:link" title="LinkTitle" href="http://localhost/" options=['class' => 'external']}
	 * }}}
	 * @param  array 	$params   	essentially an array of key:value pairs, can be a multidimensional array
	 * @param  object 	&$_smarty 	parent smarty object, lithium is also stored in this object
	 * @return mixed           		returns the result of whatever helper is requested
	 */
	function smarty_function_element($params, &$_smarty){

		// Lets grap the lithium object
		$_li3 = $_smarty->smarty->tpl_vars['this']->value;

		// grab vars from the passed `$params` and remove the sections that arent considered
		// `$params` in terms of lithium requirements
		extract($params, EXTR_OVERWRITE); unset($params['data']);

		$options = array();

		// ensure `$params` is a sequential array
		$params = explode(',', implode(',', $params));
		$params = !empty($params[0]) ? $params : false;

		// If required params are passed
		if(isset($file)){
			$params = array('element' => $file);
			if(isset($data)){
				$options += $data;
			}
		}

		// Return the Li3 magic
		// return $_li3->view()->render($params);
		return $_li3->view()->render($params, $options);
	}

?>