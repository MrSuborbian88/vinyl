<?php // $Id: edit.php,v 1.21.2.1 2007/11/02 16:20:22 tjhunt Exp $

/**
 * Page to display Quick Quiz Creator
 * Author: Project VINL Team :)
 *
 * Copied code from "question/edit.php" and modified the <body> output to print the Applet
 * WARNING: Known Bug -
 *	After uploading a Quiz with the QQC, you need to close the page and open VINL in
 *	a new tab/window in order to continue browsing
 */

	require_once("../config.php");
	require_once("editlib.php");

	list($thispageurl, $contexts, $cmid, $cm, $module, $pagevars) = question_edit_setup('questions');

	question_showbank_actions($thispageurl, $cm);

	$context = $contexts->lowest();
	$streditingquestions = get_string('quizcreator');
	if ($cm!==null) {
		$strupdatemodule = has_capability('moodle/course:manageactivities', $contexts->lowest())
			? update_module_button($cm->id, $COURSE->id, get_string('modulename', $cm->modname))
			: "";
		$navlinks = array();
		$navlinks[] = array('name' => get_string('modulenameplural', $cm->modname), 'link' => "$CFG->wwwroot/mod/{$cm->modname}/index.php?id=$COURSE->id", 'type' => 'activity');
		$navlinks[] = array('name' => format_string($module->name), 'link' => "$CFG->wwwroot/mod/{$cm->modname}/view.php?id={$cm->id}", 'type' => 'title');
		$navlinks[] = array('name' => $streditingquestions, 'link' => '', 'type' => 'title');
		$navigation = build_navigation($navlinks);
		print_header_simple($streditingquestions, '', $navigation, "", "", true, $strupdatemodule);
	} else {
		// Print basic page layout.
		$navlinks = array();
		$navlinks[] = array('name' => $streditingquestions, 'link' => '', 'type' => 'title');
		$navigation = build_navigation($navlinks);

		print_header_simple($streditingquestions, '', $navigation);
	}

	// HTML Code for the QQC
	echo "<div id='applet'>";
	echo "<center><br><applet code='QuizCreator.class' width=640 height=480>";
	echo "<param name=\"courseid\" value=\"".optional_param("courseid", 0, PARAM_INT)."\" />";
	echo "<param name=\"cfgroot\" value=\"".$CFG->wwwroot."/\" />";
	echo "</applet></center>";
	echo "</div>";

	print_footer($COURSE);
?>