<?php

require_once 'HTMLPurifier/AttrDef.php';
require_once 'HTMLPurifier/AttrDef/HTML/Pixels.php';

/**
 * Validates the HTML type length (not to be confused with CSS's length).
 * 
 * This accepts integer pixels or percentages as lengths for certain
 * HTML attributes.
 */

class HTMLPurifier_AttrDef_HTML_Length extends HTMLPurifier_AttrDef_HTML_Pixels
{
	
	function validate($string, $config, &$context) {
		
		$string = trim($string);
		if ($string === '') return false;
		
		$parent_result = parent::validate($string, $config, $context);
		if ($parent_result !== false) return $parent_result;
		
		$length = strlen($string);
		$last_char = $string[$length - 1];
		
		if ($last_char !== '%') return false;
		
		$points = substr($string, 0, $length - 1);
		
		if (!is_numeric($points)) return false;
		
		$points = (int) $points;
		
		if ($points < 0) return '0%';
		if ($points > 100) return '100%';
		
		return ((string) $points) . '%';
		
	}
	
}

