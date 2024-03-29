<?php

require_once 'HTMLPurifier/AttrDef.php';
require_once 'HTMLPurifier/AttrDef/HTML/Length.php';

/**
 * Validates a MultiLength as defined by the HTML spec.
 * 
 * A multilength is either a integer (pixel count), a percentage, or
 * a relative number.
 */
class HTMLPurifier_AttrDef_HTML_MultiLength extends HTMLPurifier_AttrDef_HTML_Length
{
	
	function validate($string, $config, &$context) {
		
		$string = trim($string);
		if ($string === '') return false;
		
		$parent_result = parent::validate($string, $config, $context);
		if ($parent_result !== false) return $parent_result;
		
		$length = strlen($string);
		$last_char = $string[$length - 1];
		
		if ($last_char !== '*') return false;
		
		$int = substr($string, 0, $length - 1);
		
		if ($int == '') return '*';
		if (!is_numeric($int)) return false;
		
		$int = (int) $int;
		
		if ($int < 0) return false;
		if ($int == 0) return '0';
		if ($int == 1) return '*';
		return ((string) $int) . '*';
		
	}
	
}

