<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * @author  Ivan A Kirillov (Ivan.A.Kirillov@gmail.com)
 * @version $Id: pmd_display_field.php 10149 2007-03-20 15:11:15Z cybot_tm $
 * @package phpMyAdmin-Designer
 */

/**
 *
 */
include_once 'pmd_common.php';
require_once './libraries/relation.lib.php';


$table = $T;
$display_field = $F;

if ($cfgRelation['displaywork']) {

	$disp	 = PMA_getDisplayField($db, $table);
	if ($disp) {
		if ($display_field != $disp) {
			$upd_query = 'UPDATE ' . PMA_backquote($GLOBALS['cfgRelation']['db']) . '.' . PMA_backquote($cfgRelation['table_info'])
					   . ' SET display_field = \'' . PMA_sqlAddslashes($display_field) . '\''
					   . ' WHERE db_name  = \'' . PMA_sqlAddslashes($db) . '\''
					   . ' AND table_name = \'' . PMA_sqlAddslashes($table) . '\'';
		} else {
			$upd_query = 'DELETE FROM ' . PMA_backquote($GLOBALS['cfgRelation']['db']) . '.' . PMA_backquote($cfgRelation['table_info'])
					   . ' WHERE db_name  = \'' . PMA_sqlAddslashes($db) . '\''
					   . ' AND table_name = \'' . PMA_sqlAddslashes($table) . '\'';
		}
	} elseif ($display_field != '') {
		$upd_query = 'INSERT INTO ' . PMA_backquote($GLOBALS['cfgRelation']['db']) . '.' . PMA_backquote($cfgRelation['table_info'])
				   . '(db_name, table_name, display_field) '
				   . ' VALUES('
				   . '\'' . PMA_sqlAddslashes($db) . '\','
				   . '\'' . PMA_sqlAddslashes($table) . '\','
				   . '\'' . PMA_sqlAddslashes($display_field) . '\')';
	}

	if (isset($upd_query)) {
		$upd_rs	= PMA_query_as_cu($upd_query);
	}
} // end if

header("Content-Type: text/xml; charset=utf-8");
header("Cache-Control: no-cache");
die("<root act='save_pos' return='strModifications'></root>");
?>
