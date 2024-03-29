<?php

require_once 'HTMLPurifier/AttrDef.php';

// Enum = Enumerated
/**
 * Validates a keyword against a list of valid values.
 * @warning The case-insensitive compare of this function uses PHP's
 *		  built-in strtolower and ctype_lower functions, which may
 *		  cause problems with international comparisons
 */
class HTMLPurifier_AttrDef_Enum extends HTMLPurifier_AttrDef
{
	
	/**
	 * Lookup table of valid values.
	 */
	var $valid_values   = array();
	
	/**
	 * Bool indicating whether or not enumeration is case sensitive.
	 * @note In general this is always case insensitive.
	 */
	var $case_sensitive = false; // values according to W3C spec
	
	/**
	 * @param $valid_values List of valid values
	 * @param $case_sensitive Bool indicating whether or not case sensitive
	 */
	function HTMLPurifier_AttrDef_Enum(
		$valid_values = array(), $case_sensitive = false
	) {
		$this->valid_values = array_flip($valid_values);
		$this->case_sensitive = $case_sensitive;
	}
	
	function validate($string, $config, &$context) {
		$string = trim($string);
		if (!$this->case_sensitive) {
			// we may want to do full case-insensitive libraries
			$string = ctype_lower($string) ? $string : strtolower($string);
		}
		$result = isset($this->valid_values[$string]);
		
		return $result ? $string : false;
	}
	
	/**
	 * @param $string In form of comma-delimited list of case-insensitive
	 *	  valid values. Example: "foo,bar,baz". Prepend "s:" to make
	 *	  case sensitive
	 */
	function make($string) {
		if (strlen($string) > 2 && $string[0] == 's' && $string[1] == ':') {
			$string = substr($string, 2);
			$sensitive = true;
		} else {
			$sensitive = false;
		}
		$values = explode(',', $string);
		return new HTMLPurifier_AttrDef_Enum($values, $sensitive);
	}
	
}

