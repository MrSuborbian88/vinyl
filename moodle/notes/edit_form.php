<?php  // $Id: edit_form.php,v 1.5.2.2 2008/11/30 19:25:49 skodak Exp $

require_once($CFG->libdir.'/formslib.php');

class note_edit_form extends moodleform {

	function definition() {
		$mform	=& $this->_form;
		$strcontent = get_string('content', 'notes');
		$strpublishstate = get_string('publishstate', 'notes');
		$mform->addElement('header', 'general', get_string('note', 'notes'));

		$mform->addElement('textarea', 'content', $strcontent, array('rows'=>15, 'cols'=>40));
		$mform->setType('content', PARAM_RAW);
		$mform->addRule('content', get_string('nocontent', 'notes'), 'required', null, 'client');

		$mform->addElement('select', 'publishstate', $strpublishstate, note_get_state_names());
		$mform->setDefault('publishstate', NOTES_STATE_PUBLIC);
		$mform->setType('publishstate', PARAM_ALPHA);
		$mform->setHelpButton('publishstate', array('status', $strpublishstate, 'notes'));

		$this->add_action_buttons();

		$mform->addElement('hidden', 'courseid');
		$mform->setType('course', PARAM_INT);

		$mform->addElement('hidden', 'userid');
		$mform->setType('user', PARAM_INT);

		$mform->addElement('hidden', 'id');
		$mform->setType('id', PARAM_INT);
	}
}
?>