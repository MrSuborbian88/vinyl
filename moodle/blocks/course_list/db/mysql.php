<?PHP  //$Id: mysql.php,v 1.4 2006/10/26 22:39:10 stronk7 Exp $

// THIS FILE IS DEPRECATED!  PLEASE DO NOT MAKE CHANGES TO IT!
//
// IT IS USED ONLY FOR UPGRADES FROM BEFORE MOODLE 1.7, ALL 
// LATER CHANGES SHOULD USE upgrade.php IN THIS DIRECTORY.
//
// This file is tailored to MySQL

function course_list_upgrade($oldversion=0) {

	global $CFG;
	
	$result = true;

	if ($oldversion < 2004041000 and $result) {
		$result = true; //Nothing to do
	}

	//////  DO NOT ADD NEW THINGS HERE!!  USE upgrade.php and the lib/ddllib.php functions.

	//Finally, return result
	return $result;
}
