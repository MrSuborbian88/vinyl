<?php // $Id: new_table.class.php,v 1.6 2007/10/10 05:25:29 nicolasconnault Exp $

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

/// This class will create a new default table to be edited

class new_table extends XMLDBAction {

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

	/// Get the correct dirs
		if (!empty($XMLDB->dbdirs)) {
			$dbdir =& $XMLDB->dbdirs[$dirpath];
		} else {
			return false;
		}
		if (!empty($XMLDB->editeddirs)) {
			$editeddir =& $XMLDB->editeddirs[$dirpath];
			$structure =& $editeddir->xml_file->getStructure();
		}
	/// ADD YOUR CODE HERE

	/// If the changeme table exists, just get it and continue
		$changeme_exists = false;
		if ($tables =& $structure->getTables()) {
			if ($table =& $structure->getTable('changeme')) {
				$changeme_exists = true;
			}
		}
		if (!$changeme_exists) { /// Lets create the table
			$field = new XMLDBField('id');
			$field->setType(XMLDB_TYPE_INTEGER);
			$field->setLength(10);
			$field->setNotNull(true);
			$field->setUnsigned(true);
			$field->setSequence(true);
			$field->setLoaded(true);
			$field->setChanged(true);

			$key = new XMLDBKey('primary');
			$key->setType(XMLDB_KEY_PRIMARY);
			$key->setFields(array('id'));
			$key->setLoaded(true);
			$key->setChanged(true);

			$table = new XMLDBTable('changeme');
			$table->setComment('Default comment for the table, please edit me');
			$table->addField($field);
			$table->addKey($key);

		/// Finally, add the whole retroffited table to the structure
		/// in the place specified
			$structure->addTable($table);
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
