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
	function smarty_function_helper($params, &$_smarty){

		// Lets grap the lithium object
		$li3 = $_smarty->smarty->tpl_vars['this']->value;

		// grab vars from the passed `$params` and remove the sections that arent considered
		// `$params` in terms of lithium requirements
		extract($params, EXTR_OVERWRITE); unset($params['init']); unset($params['options']);

		// ensure `$params` is in an array
		if(is_string($params)){
			$params = explode(',', implode(',', $params));
			$params = !empty($params[0]) ? $params : false;
		}

		// Build init call to determine which helper class and method to use
		$init = explode(':', $init);

		// If required params are passed
		if($params){
			// If an optional array is passed in
			if(isset($options) AND is_array($options)){
				$options = array($options);
				$params = array_merge($params, $options);
			}
		// No params are given
		} else {
			$params = array();
			// If the option array is given (likely it's not optional in this case)
			if(isset($options) AND is_array($options)){
				$params = array($options);
			}
		}

		// Return the Li3 magic
		return call_user_func_array(array($li3->{$init[0]}, $init[1]), $params);

	}

?>