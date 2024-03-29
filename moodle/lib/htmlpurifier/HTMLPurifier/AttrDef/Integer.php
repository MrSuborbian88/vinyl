<?php

require_once 'HTMLPurifier/AttrDef.php';

/**
 * Validates an integer.
 * @note While this class was modeled off the CSS definition, no currently
 *	   allowed CSS uses this type.  The properties that do are: widows,
 *	   orphans, z-index, counter-increment, counter-reset.  Some of the
 *	   HTML attributes, however, find use for a non-negative version of this.
 */
class HTMLPurifier_AttrDef_Integer extends HTMLPurifier_AttrDef
{
	
	/**
	 * Bool indicating whether or not negative values are allowed
	 */
	var $negative = true;
	
	/**
	 * Bool indicating whether or not zero is allowed
	 */
	var $zero = true;
	
	/**
	 * Bool indicating whether or not positive values are allowed
	 */
	var $positive = true;
	
	/**
	 * @param $negative Bool indicating whether or not negative values are allowed
	 * @param $zero Bool indicating whether or not zero is allowed
	 * @param $positive Bool indicating whether or not positive values are allowed
	 */
	function HTMLPurifier_AttrDef_Integer(
		$negative = true, $zero = true, $positive = true
	) {
		$this->negative = $negative;
		$this->zero	 = $zero;
		$this->positive = $positive;
	}
	
	function validate($integer, $config, &$context) {
		
		$integer = $this->parseCDATA($integer);
		if ($integer === '') return false;
		
		// we could possibly simply typecast it to integer, but there are
		// certain fringe cases that must not return an integer.
		
		// clip leading sign
		if ( $this->negative && $integer[0] === '-' ) {
			$digits = substr($integer, 1);
			if ($digits === '0') $integer = '0'; // rm minus sign for zero
		} elseif( $this->positive && $integer[0] === '+' ) {
			$digits = $integer = substr($integer, 1); // rm unnecessary plus
		} else {
			$digits = $integer;
		}
		
		// test if it's numeric
		if (!ctype_digit($digits)) return false;
		
		// perform scope tests
		if (!$this->zero	 && $integer == 0) return false;
		if (!$this->positive && $integer > 0) return false;
		if (!$this->negative && $integer < 0) return false;
		
		return $integer;
		
	}
	
}

