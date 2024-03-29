<?php

/**
 * Decorator which enables CSS properties to be disabled for specific elements.
 */
class HTMLPurifier_AttrDef_CSS_DenyElementDecorator extends HTMLPurifier_AttrDef
{
	var $def, $element;
	
	/**
	 * @param $def Definition to wrap
	 * @param $element Element to deny
	 */
	function HTMLPurifier_AttrDef_CSS_DenyElementDecorator(&$def, $element) {
		$this->def =& $def;
		$this->element = $element;
	}
	/**
	 * Checks if CurrentToken is set and equal to $this->element
	 */
	function validate($string, $config, $context) {
		$token = $context->get('CurrentToken', true);
		if ($token && $token->name == $this->element) return false;
		return $this->def->validate($string, $config, $context);
	}
}
