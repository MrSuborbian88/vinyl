<?php

require_once 'HTMLPurifier/HTMLModule.php';
require_once 'HTMLPurifier/AttrDef/CSS.php';

/**
 * XHTML 1.1 Edit Module, defines editing-related elements. Text Extension
 * Module.
 */
class HTMLPurifier_HTMLModule_StyleAttribute extends HTMLPurifier_HTMLModule
{
	
	var $name = 'StyleAttribute';
	var $attr_collections = array(
		// The inclusion routine differs from the Abstract Modules but
		// is in line with the DTD and XML Schemas.
		'Style' => array('style' => false), // see constructor
		'Core' => array(0 => array('Style'))
	);
	
	function setup($config) {
		$this->attr_collections['Style']['style'] = new HTMLPurifier_AttrDef_CSS();
	}
	
}

