<?php

require_once 'HTMLPurifier/AttrDef.php';

/**
 * Validates the value for the CSS property text-decoration
 * @note This class could be generalized into a version that acts sort of
 *	   like Enum except you can compound the allowed values.
 */
class HTMLPurifier_AttrDef_CSS_TextDecoration extends HTMLPurifier_AttrDef
{
	
	function validate($string, $config, &$context) {
		
		static $allowed_values = array(
			'line-through' => true,
			'overline' => true,
			'underline' => true,
		);
		
		$string = strtolower($this->parseCDATA($string));
		
		if ($string === 'none') return $string;
		
		$parts = explode(' ', $string);
		$final = '';
		foreach ($parts as $part) {
			if (isset($allowed_values[$part])) {
				$final .= $part . ' ';
			}
		}
		$final = rtrim($final);
		if ($final === '') return false;
		return $final;
		
	}
	
}

