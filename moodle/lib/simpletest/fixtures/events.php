<?php // $Id: events.php,v 1.3 2007/10/10 05:29:35 nicolasconnault Exp $

///////////////////////////////////////////////////////////////////////////
//																	   //
// NOTICE OF COPYRIGHT												   //
//																	   //
// Moodle - Modular Object-Oriented Dynamic Learning Environment		 //
//		  http://moodle.org											//
//																	   //
// Copyright (C) 1999 onwards Martin Dougiamas  http://dougiamas.com	   //
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


$handlers = array (
   'test_instant' => array (
		'handlerfile'	  => '/lib/simpletest/testeventslib.php',
		'handlerfunction'  => 'sample_function_handler',
		'schedule'		 => 'instant'
	),

   'test_cron' => array (
		'handlerfile'	  => '/lib/simpletest/testeventslib.php',
		'handlerfunction'  => array('sample_handler_class', 'static_method'),
		'schedule'		 => 'cron'
	)
);

?>
