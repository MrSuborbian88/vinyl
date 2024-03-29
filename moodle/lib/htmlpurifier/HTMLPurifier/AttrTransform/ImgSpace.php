<?php

require_once 'HTMLPurifier/AttrTransform.php';

/**
 * Pre-transform that changes deprecated hspace and vspace attributes to CSS
 */
class HTMLPurifier_AttrTransform_ImgSpace
extends HTMLPurifier_AttrTransform {
	
	var $attr;
	var $css = array(
		'hspace' => array('left', 'right'),
		'vspace' => array('top', 'bottom')
	);
	
	function HTMLPurifier_AttrTransform_ImgSpace($attr) {
		$this->attr = $attr;
		if (!isset($this->css[$attr])) {
			trigger_error(htmlspecialchars($attr) . ' is not valid space attribute');
		}
	}
	
	function transform($attr, $config, &$context) {
		
		if (!isset($attr[$this->attr])) return $attr;
		
		$width = $this->confiscateAttr($attr, $this->attr);
		// some validation could happen here
		
		if (!isset($this->css[$this->attr])) return $attr;
		
		$style = '';
		foreach ($this->css[$this->attr] as $suffix) {
			$property = "margin-$suffix";
			$style .= "$property:{$width}px;";
		}
		
		$this->prependCSS($attr, $style);
		
		return $attr;
		
	}
	
}

