<?php // $Id: unload_xml_file.class.php,v 1.4 2007/10/10 05:25:29 nicolasconnault Exp $

///////////////////////////////////////////////////////////////////////////
//																	   //
// NOTICE OF COPYRIGHT												   //
//																	   //
// Moodle - Modular Object-Oriented Dynamic Learning Environment		 //
//		  http://moodle.com											//
//																	   //
// Copyright (C) 1999 onwards Martin Dougiamas		http://dougiamas.com  //
//		   (C) 2001-3001 Eloy Lafuente (stronk7) http://contiento.com  //
//																	   //
// This program is free software; you can redistribute it and/or modify  //
// it under the terms of the GNU General Public License as published by  //
// the Free Software Foundation; either version 2 of the License, or	 //
// (at your option) any later version.								   //
//																	   //
// This program is distributed in the hope that it will be useful,	   //
// but WITHOUT ANY WARRANTY; without even the implied warranty of		//
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the		 //
// GNU General Public License for more details:						  //
//																	   //
//		  http://www.gnu.org/copyleft/gpl.html						 //
//																	   //
///////////////////////////////////////////////////////////////////////////

/// This class will unload one loaded file completely

class unload_xml_file extends XMLDBAction {

	/**
	 * Init method, every subclass will have its own
	 */
	function init() {
		parent::init();

	/// Set own custom attributes

	/// Get needed strings
		$this->loadStrings(array(
		/// 'key' => 'module',
		));
	}

	/**
	 * Invoke method, every class will have its own
	 * returns true/false on completion, setting both
	 * errormsg and output as necessary
	 */
	function invoke() {
		parent::invoke();

		$result = true;

	/// Set own core attributes
		$this->does_generate = ACTION_NONE;
		//$this->does_generate = ACTION_GENERATE_HTML;

	/// These are always here
		global $CFG, $XMLDB;

	/// Do the job, setting result as needed

	/// Get the dir containing the file
		$dirpath = required_param('dir', PARAM_PATH);
		$dirpath = $CFG->dirroot . stripslashes_safe($dirpath);

		/// Get the original dir and delete some elements
		if (!empty($XMLDB->dbdirs)) {
			if (isset($XMLDB->dbdirs[$dirpath])) {
				$dbdir =& $XMLDB->dbdirs[$dirpath];
				if ($dbdir) {
					unset($dbdir->xml_file);
					unset($dbdir->xml_loaded);
					unset($dbdir->xml_changed);
					unset($dbdir->xml_exists);
					unset($dbdir->xml_writeable);
				}
			}
		}
		/// Get the edited dir and delete it completely
		if (!empty($XMLDB->editeddirs)) {
			if (isset($XMLDB->editeddirs[$dirpath])) {
				unset($XMLDB->editeddirs[$dirpath]);
			}
		}

	/// Launch postaction if exists (leave this here!)
		if ($this->getPostAction() && $result) {
			return $this->launch($this->getPostAction());
		}

	/// Return ok if arrived here
		return $result;
	}
}
?>
