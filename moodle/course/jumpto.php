<?php  // $Id: jumpto.php,v 1.6 2006/09/11 06:47:38 skodak Exp $

/*
 *  Jumps to a given relative or Moodle absolute URL.
 *  Mostly used for accessibility.
 *
 */

	require('../config.php');

	$jump = optional_param('jump', '', PARAM_RAW);

	if (!confirm_sesskey()) {
		print_error('confirmsesskeybad');
	}

	if (strpos($jump, $CFG->wwwroot) === 0) {			// Anything on this site
		redirect(urldecode($jump));
	} else if (preg_match('/^[a-z]+\.php\?/', $jump)) { 
		redirect(urldecode($jump));
	}

	redirect($_SERVER['HTTP_REFERER']);   // Return to sender, just in case

?>
