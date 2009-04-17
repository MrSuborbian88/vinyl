<?php  /// Moodle Configuration File 

unset($CFG);

$CFG->dbtype	= 'mysql';
$CFG->dbhost	= 'localhost';
$CFG->dbname	= 'moodle';
$CFG->dbuser	= 'root';
$CFG->dbpass	= '';
$CFG->dbpersist =  false;
$CFG->prefix	= 'mdl_';

$CFG->wwwroot   = 'http://128.113.91.132';
$CFG->dirroot   = 'C:\Users\plochd\Documents\Course Files Spring 2009\Software Design and Documentation\moodlecopy\server\moodle';
$CFG->dataroot  = 'C:\Users\plochd\Documents\Course Files Spring 2009\Software Design and Documentation\moodlecopy\server/moodledata';
$CFG->admin	 = 'admin';

$CFG->directorypermissions = 00777;  // try 02777 on a server in Safe Mode

require_once("$CFG->dirroot/lib/setup.php");
// MAKE SURE WHEN YOU EDIT THIS FILE THAT THERE ARE NO SPACES, BLANK LINES,
// RETURNS, OR ANYTHING ELSE AFTER THE TWO CHARACTERS ON THE NEXT LINE.
?>