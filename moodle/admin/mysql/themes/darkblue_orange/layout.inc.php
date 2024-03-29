<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * configures general layout
 * for detailed layout configuration please refer to the css files
 *
 * @version $Id: layout.inc.php 11036 2008-01-05 14:30:41Z lem9 $
 * @package phpMyAdmin-theme
 * @subpackage Darkblue_orange
 */

// protect against path disclosure
if (empty($_SESSION['PMA_Theme'])) {
	exit;
}

/**
 * navi frame
 */
// navi frame width
$GLOBALS['cfg']['NaviWidth']				= 180;

// foreground (text) color for the navi frame
$GLOBALS['cfg']['NaviColor']				= '#ffffff';

// background for the navi frame
$GLOBALS['cfg']['NaviBackground']		   = '#666699';

// foreground (text) color of the pointer in navi frame
$GLOBALS['cfg']['NaviPointerColor']		 = '#000000';

// background of the pointer in navi frame
$GLOBALS['cfg']['NaviPointerBackground']	= '#9999cc';

// text color of the selected database name (when showing the table list)
$GLOBALS['cfg']['NaviDatabaseNameColor']	= '#ff9900';

/**
 * main frame
 */
// foreground (text) color for the main frame
$GLOBALS['cfg']['MainColor']				= '#000000';

// background for the main frame
$GLOBALS['cfg']['MainBackground']		   = '#ffffff';
//$GLOBALS['cfg']['MainBackground']	   = '#ffffff url(' . $_SESSION['PMA_Theme']->getImgPath() . 'vertical_line.png) repeat-y';

// foreground (text) color of the pointer in browse mode
$GLOBALS['cfg']['BrowsePointerColor']	   = '#000000';

// background of the pointer in browse mode
$GLOBALS['cfg']['BrowsePointerBackground']  = '#ccffcc';

// foreground (text) color of the marker (visually marks row by clicking on it) in browse mode
$GLOBALS['cfg']['BrowseMarkerColor']		= '#000000';

// background of the marker (visually marks row by clicking on it) in browse mode
$GLOBALS['cfg']['BrowseMarkerBackground']   = '#ffcc99';

/**
 * fonts
 */
/**
 * the font family as a valid css font family value,
 * if not set the browser default will be used
 * (depending on browser, DTD and system settings)
 */
$GLOBALS['cfg']['FontFamily']		   = 'Verdana, Arial, Helvetica, sans-serif';
/**
 * fixed width font family, used in textarea
 */
$GLOBALS['cfg']['FontFamilyFixed']	  = 'monospace';

/**
 * tables
 */
// border
$GLOBALS['cfg']['Border']			   = 0;
// table header and footer color
$GLOBALS['cfg']['ThBackground']		 = '#ff9900 url(' . $_SESSION['PMA_Theme']->getImgPath() . 'tbl_th.png) repeat-x top';
// table header and footer background
$GLOBALS['cfg']['ThColor']			  = '#000000';
// table data row background
$GLOBALS['cfg']['BgOne']				= '#E5E5E5';
// table data row background, alternate
$GLOBALS['cfg']['BgTwo']				= '#D5D5D5';

/**
 * query window
 */
// Width of Query window
$GLOBALS['cfg']['QueryWindowWidth']	 = 600;
// Height of Query window
$GLOBALS['cfg']['QueryWindowHeight']	= 400;

/**
 * SQL Parser Settings
 * Syntax colouring data
 */
$GLOBALS['cfg']['SQP']['fmtColor']	  = array(
	'comment'			=> '#808000',
	'comment_mysql'	  => '',
	'comment_ansi'	   => '',
	'comment_c'		  => '',
	'digit'			  => '',
	'digit_hex'		  => 'teal',
	'digit_integer'	  => 'teal',
	'digit_float'		=> 'aqua',
	'punct'			  => 'fuchsia',
	'alpha'			  => '',
	'alpha_columnType'   => '#FF9900',
	'alpha_columnAttrib' => '#0000FF',
	'alpha_reservedWord' => '#990099',
	'alpha_functionName' => '#FF0000',
	'alpha_identifier'   => 'black',
	'alpha_charset'	  => '#6495ed',
	'alpha_variable'	 => '#800000',
	'quote'			  => '#008000',
	'quote_double'	   => '',
	'quote_single'	   => '',
	'quote_backtick'	 => ''
);
?>
