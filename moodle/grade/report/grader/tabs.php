<?php  // $Id: tabs.php,v 1.11 2007/10/10 06:34:21 nicolasconnault Exp $

///////////////////////////////////////////////////////////////////////////
//																	   //
// NOTICE OF COPYRIGHT												   //
//																	   //
// Moodle - Modular Object-Oriented Dynamic Learning Environment		 //
//		  http://moodle.com											//
//																	   //
// Copyright (C) 1999 onwards  Martin Dougiamas  http://moodle.com	   //
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
	$row = $tabs = array();
	$tabcontext = get_context_instance(CONTEXT_COURSE, $COURSE->id);
	$row[] = new tabobject('graderreport',
						   $CFG->wwwroot.'/grade/report/grader/index.php?id='.$courseid,
						   get_string('modulename', 'gradereport_grader'));
	if (has_capability('moodle/grade:manage',$tabcontext ) ||
		has_capability('moodle/grade:edit', $tabcontext) ||
		has_capability('gradereport/grader:view', $tabcontext)) {
		$row[] = new tabobject('preferences',
							   $CFG->wwwroot.'/grade/report/grader/preferences.php?id='.$courseid,
							   get_string('myreportpreferences', 'grades'));
	}

	$tabs[] = $row;
	echo '<div class="gradedisplay">';
	print_tabs($tabs, $currenttab);
	echo '</div>';
?>
