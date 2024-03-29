<?php  // $Id: request_form.php,v 1.11.2.4 2008/12/10 02:57:52 tjhunt Exp $

///////////////////////////////////////////////////////////////////////////
//																	   //
// NOTICE OF COPYRIGHT												   //
//																	   //
// Moodle - Modular Object-Oriented Dynamic Learning Environment		 //
//		  http://moodle.org											//
//																	   //
// Copyright (C) 1999 onwards Martin Dougiamas  http://dougiamas.com	 //
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

/**
 * Forms associated with requesting courses, and having requests approved.
 * Note that several related forms are defined in this one file.
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package course
 *//** */

require_once($CFG->libdir.'/formslib.php');

/**
 * A form for a user to request a course.
 */
class course_request_form extends moodleform {
	function definition() {
		global $USER;

		$mform =& $this->_form;

		if ($pending = get_records('course_request', 'requester', $USER->id)) {
			$mform->addElement('header', 'pendinglist', get_string('coursespending'));
			$list = array();
			foreach ($pending as $cp) {
				$list[] = format_string($cp->fullname);
			}
			$list = implode(', ', $list);
			$mform->addElement('static', 'pendingcourses', get_string('courses'), $list);
		}

		$mform->addElement('header','coursedetails', get_string('courserequestdetails'));

		$mform->addElement('text', 'fullname', get_string('fullname'), 'maxlength="254" size="50"');
		$mform->setHelpButton('fullname', array('coursefullname', get_string('fullname')), true);
		$mform->addRule('fullname', get_string('missingfullname'), 'required', null, 'client');
		$mform->setType('fullname', PARAM_MULTILANG);

		$mform->addElement('text', 'shortname', get_string('shortname'), 'maxlength="15" size="20"');
		$mform->setHelpButton('shortname', array('courseshortname', get_string('shortname')), true);
		$mform->addRule('shortname', get_string('missingshortname'), 'required', null, 'client');
		$mform->setType('shortname', PARAM_MULTILANG);

		$mform->addElement('htmleditor', 'summary', get_string('summary'), array('rows'=>'15', 'cols'=>'50'));
		$mform->setHelpButton('summary', array('text', get_string('helptext')), true);
		$mform->setType('summary', PARAM_RAW);

		$mform->addElement('passwordunmask', 'password', get_string('enrolmentkey'), 'size="25"');
		$mform->setHelpButton('password', array('enrolmentkey', get_string('enrolmentkey')), true);
		$mform->setDefault('password', '');
		$mform->setType('password', PARAM_RAW);

		$mform->addElement('header','requestreason', get_string('courserequestreason'));

		$mform->addElement('textarea', 'reason', get_string('courserequestsupport'), array('rows'=>'15', 'cols'=>'50'));
		$mform->addRule('reason', get_string('missingreqreason'), 'required', null, 'client');
		$mform->setType('reason', PARAM_TEXT);

		$this->add_action_buttons(true, get_string('requestcourse'));
	}

	function validation($data, $files) {
		$errors = parent::validation($data, $files);
		$foundcourses = null;
		$foundreqcourses = null;

		if (!empty($data['shortname'])) {
			$foundcourses = get_records('course', 'shortname', $data['shortname']);
			$foundreqcourses = get_records('course_request', 'shortname', $data['shortname']);
		}
		if (!empty($foundreqcourses)) {
			if (!empty($foundcourses)) {
				$foundcourses = array_merge($foundcourses, $foundreqcourses);
			} else {
				$foundcourses = $foundreqcourses;
			}
		}

		if (!empty($foundcourses)) {
			foreach ($foundcourses as $foundcourse) {
				if (!empty($foundcourse->requester)) {
					$pending = 1;
					$foundcoursenames[] = $foundcourse->fullname.' [*]';
				} else {
					$foundcoursenames[] = $foundcourse->fullname;
				}
			}
			$foundcoursenamestring = implode(',', $foundcoursenames);

			$errors['shortname'] = get_string('shortnametaken', '', $foundcoursenamestring);
			if (!empty($pending)) {
				$errors['shortname'] .= get_string('starpending');
			}
		}

		return $errors;
	}
}

/**
 * A form for an administrator to reject a course request.
 */
class reject_request_form extends moodleform {
	function definition() {
		$mform =& $this->_form;

		$mform->addElement('hidden', 'reject', 0);

		$mform->addElement('header','coursedetails', get_string('coursereasonforrejecting'));

		$mform->addElement('textarea', 'rejectnotice', get_string('coursereasonforrejectingemail'), array('rows'=>'15', 'cols'=>'50'));
		$mform->addRule('rejectnotice', get_string('missingreqreason'), 'required', null, 'client');
		$mform->setType('rejectnotice', PARAM_TEXT);

		$this->add_action_buttons(true, get_string('reject'));
	}
}
?>
