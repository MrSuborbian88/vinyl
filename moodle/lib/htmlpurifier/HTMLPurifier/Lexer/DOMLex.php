<?php

require_once 'HTMLPurifier/Lexer.php';
require_once 'HTMLPurifier/TokenFactory.php';

/**
 * Parser that uses PHP 5's DOM extension (part of the core).
 * 
 * In PHP 5, the DOM XML extension was revamped into DOM and added to the core.
 * It gives us a forgiving HTML parser, which we use to transform the HTML
 * into a DOM, and then into the tokens.  It is blazingly fast (for large
 * documents, it performs twenty times faster than
 * HTMLPurifier_Lexer_DirectLex,and is the default choice for PHP 5. 
 * 
 * @note Any empty elements will have empty tokens associated with them, even if
 * this is prohibited by the spec. This is cannot be fixed until the spec
 * comes into play.
 * 
 * @note PHP's DOM extension does not actually parse any entities, we use
 *	   our own function to do that.
 * 
 * @warning DOM tends to drop whitespace, which may wreak havoc on indenting.
 *		  If this is a huge problem, due to the fact that HTML is hand
 *		  edited and you are unable to get a parser cache that caches the
 *		  the output of HTML Purifier while keeping the original HTML lying
 *		  around, you may want to run Tidy on the resulting output or use
 *		  HTMLPurifier_DirectLex
 */

class HTMLPurifier_Lexer_DOMLex extends HTMLPurifier_Lexer
{
	
	private $factory;
	
	public function __construct() {
		// setup the factory
		parent::HTMLPurifier_Lexer();
		$this->factory = new HTMLPurifier_TokenFactory();
	}
	
	public function tokenizeHTML($html, $config, &$context) {
		
		$html = $this->normalize($html, $config, $context);
		
		// attempt to armor stray angled brackets that cannot possibly
		// form tags and thus are probably being used as emoticons
		if ($config->get('Core', 'AggressivelyFixLt')) {
			$char = '[^a-z!\/]';
			$comment = "/<!--(.*?)(-->|\z)/is";
			$html = preg_replace_callback($comment, array('HTMLPurifier_Lexer_DOMLex', 'callbackArmorCommentEntities'), $html);
			$html = preg_replace("/<($char)/i", '&lt;\\1', $html);
			$html = preg_replace_callback($comment, array('HTMLPurifier_Lexer_DOMLex', 'callbackUndoCommentSubst'), $html); // fix comments
		}
		
		// preprocess html, essential for UTF-8
		$html = $this->wrapHTML($html, $config, $context);
		
		$doc = new DOMDocument();
		$doc->encoding = 'UTF-8'; // theoretically, the above has this covered
		
		set_error_handler(array($this, 'muteErrorHandler'));
		$doc->loadHTML($html);
		restore_error_handler();
		
		$tokens = array();
		$this->tokenizeDOM(
			$doc->getElementsByTagName('html')->item(0)-> // <html>
				  getElementsByTagName('body')->item(0)-> //   <body>
				  getElementsByTagName('div')->item(0)	//	 <div>
			, $tokens);
		return $tokens;
	}
	
	/**
	 * Recursive function that tokenizes a node, putting it into an accumulator.
	 * 
	 * @param $node	 DOMNode to be tokenized.
	 * @param $tokens   Array-list of already tokenized tokens.
	 * @param $collect  Says whether or start and close are collected, set to
	 *				  false at first recursion because it's the implicit DIV
	 *				  tag you're dealing with.
	 * @returns Tokens of node appended to previously passed tokens.
	 */
	protected function tokenizeDOM($node, &$tokens, $collect = false) {
		
		// intercept non element nodes. WE MUST catch all of them,
		// but we're not getting the character reference nodes because
		// those should have been preprocessed
		if ($node->nodeType === XML_TEXT_NODE) {
			$tokens[] = $this->factory->createText($node->data);
			return;
		} elseif ($node->nodeType === XML_CDATA_SECTION_NODE) {
			// undo libxml's special treatment of <script> and <style> tags
			$last = end($tokens);
			$data = $node->data;
			// (note $node->tagname is already normalized)
			if ($last instanceof HTMLPurifier_Token_Start && $last->name == 'script') {
				$new_data = trim($data);
				if (substr($new_data, 0, 4) === '<!--') {
					$data = substr($new_data, 4);
					if (substr($data, -3) === '-->') {
						$data = substr($data, 0, -3);
					} else {
						// Highly suspicious! Not sure what to do...
					}
				}
			}
			$tokens[] = $this->factory->createText($this->parseData($data));
			return;
		} elseif ($node->nodeType === XML_COMMENT_NODE) {
			// this is code is only invoked for comments in script/style in versions
			// of libxml pre-2.6.28 (regular comments, of course, are still
			// handled regularly)
			$tokens[] = $this->factory->createComment($node->data);
			return;
		} elseif (
			// not-well tested: there may be other nodes we have to grab
			$node->nodeType !== XML_ELEMENT_NODE
		) {
			return;
		}
		
		$attr = $node->hasAttributes() ?
			$this->transformAttrToAssoc($node->attributes) :
			array();
		
		// We still have to make sure that the element actually IS empty
		if (!$node->childNodes->length) {
			if ($collect) {
				$tokens[] = $this->factory->createEmpty($node->tagName, $attr);
			}
		} else {
			if ($collect) { // don't wrap on first iteration
				$tokens[] = $this->factory->createStart(
					$tag_name = $node->tagName, // somehow, it get's dropped
					$attr
				);
			}
			foreach ($node->childNodes as $node) {
				// remember, it's an accumulator. Otherwise, we'd have
				// to use array_merge
				$this->tokenizeDOM($node, $tokens, true);
			}
			if ($collect) {
				$tokens[] = $this->factory->createEnd($tag_name);
			}
		}
		
	}
	
	/**
	 * Converts a DOMNamedNodeMap of DOMAttr objects into an assoc array.
	 * 
	 * @param $attribute_list DOMNamedNodeMap of DOMAttr objects.
	 * @returns Associative array of attributes.
	 */
	protected function transformAttrToAssoc($node_map) {
		// NamedNodeMap is documented very well, so we're using undocumented
		// features, namely, the fact that it implements Iterator and
		// has a ->length attribute
		if ($node_map->length === 0) return array();
		$array = array();
		foreach ($node_map as $attr) {
			$array[$attr->name] = $attr->value;
		}
		return $array;
	}
	
	/**
	 * An error handler that mutes all errors
	 */
	public function muteErrorHandler($errno, $errstr) {}
	
	/**
	 * Callback function for undoing escaping of stray angled brackets
	 * in comments
	 */
	function callbackUndoCommentSubst($matches) {
		return '<!--' . strtr($matches[1], array('&amp;'=>'&','&lt;'=>'<')) . $matches[2];
	}
	
	/**
	 * Callback function that entity-izes ampersands in comments so that
	 * callbackUndoCommentSubst doesn't clobber them
	 */
	function callbackArmorCommentEntities($matches) {
		return '<!--' . str_replace('&', '&amp;', $matches[1]) . $matches[2];
	}
	
	/**
	 * Wraps an HTML fragment in the necessary HTML
	 */
	function wrapHTML($html, $config, &$context) {
		$def = $config->getDefinition('HTML');
		$ret = '';
		
		if (!empty($def->doctype->dtdPublic) || !empty($def->doctype->dtdSystem)) {
			$ret .= '<!DOCTYPE html ';
			if (!empty($def->doctype->dtdPublic)) $ret .= 'PUBLIC "' . $def->doctype->dtdPublic . '" ';
			if (!empty($def->doctype->dtdSystem)) $ret .= '"' . $def->doctype->dtdSystem . '" ';
			$ret .= '>';
		}
		
		$ret .= '<html><head>';
		$ret .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		$ret .= '</head><body><div>'.$html.'</div></body></html>';
		return $ret;
	}
	
}

