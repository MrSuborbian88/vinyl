<?php

require_once 'HTMLPurifier/AttrDef/HTML/FrameTarget.php';

/**
 * XHTML 1.1 Target Module, defines target attribute in link elements.
 */
class HTMLPurifier_HTMLModule_Target extends HTMLPurifier_HTMLModule
{
	
	var $name = 'Target';
	
	function setup($config) {
		$elements = array('a');
		foreach ($elements as $name) {
			$e =& $this->addBlankElement($name);
			$e->attr = array(
				'target' => new HTMLPurifier_AttrDef_HTML_FrameTarget()
			);
		}
	}
	
}

