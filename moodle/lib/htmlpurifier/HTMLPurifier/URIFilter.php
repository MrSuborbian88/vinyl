<?php

/**
 * Chainable filters for custom URI processing.
 * 
 * These filters can perform custom actions on a URI filter object,
 * including transformation or blacklisting.
 * 
 * @warning This filter is called before scheme object validation occurs.
 *		  Make sure, if you require a specific scheme object, you
 *		  you check that it exists. This allows filters to convert
 *		  proprietary URI schemes into regular ones.
 */
class HTMLPurifier_URIFilter
{
	
	/**
	 * Unique identifier of filter
	 */
	var $name;
	
	/**
	 * Performs initialization for the filter
	 */
	function prepare($config) {}
	
	/**
	 * Filter a URI object
	 * @param &$uri Reference to URI object
	 * @param $config Instance of HTMLPurifier_Config
	 * @param &$context Instance of HTMLPurifier_Context
	 * @return bool Whether or not to continue processing: false indicates
	 *		 URL is no good, true indicates continue processing. Note that
	 *		 all changes are committed directly on the URI object
	 */
	function filter(&$uri, $config, &$context) {
		trigger_error('Cannot call abstract function', E_USER_ERROR);
	}
	
}
