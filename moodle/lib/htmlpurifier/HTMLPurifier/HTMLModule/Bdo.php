<?php

require_once 'HTMLPurifier/HTMLModule.php';
require_once 'HTMLPurifier/AttrTransform/BdoDir.php';

/**
 * XHTML 1.1 Bi-directional Text Module, defines elements that
 * declare directionality of content. Text Extension Module.
 */
class HTMLPurifier_HTMLModule_Bdo extends HTMLPurifier_HTMLModule
{
	
	var $name = 'Bdo';
	var $attr_collections = array(
		'I18N' => array('dir' => false)
	);
	
	function setup($config) {
		$bdo =& $this->addElement(
			'bdo', true, 'Inline', 'Inline', array('Core', 'Lang'),
			array(
				'dir' => 'Enum#ltr,rtl', // required
				// The Abstract Module specification has the attribute
				// inclusions wrong for bdo: bdo allows Lang
			)
		);
		$bdo->attr_transform_post['required-dir'] = new HTMLPurifier_AttrTransform_BdoDir();
		
		$this->attr_collections['I18N']['dir'] = 'Enum#ltr,rtl';
	}
	
}

