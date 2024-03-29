<?PHP // $Id: enrol_manual.php,v 1.3.2.2 2008/12/06 21:21:55 skodak Exp $ 
	  // enrol_manual.php - created with Moodle 1.7 beta + (2006101003)


$string['description'] = 'This is the default form of enrollment. There are two main ways a student can be enrolled in a particular course.
<ul>
<li>A teacher or admin can enroll them manually using the link in the Course Administration menu 
	within the course.</li>
<li>A course can have a password defined, known as an \"enrollment key\".  Anyone who knows this key is 
	able to add themselves to a course.</li>
</ul>';
$string['enrolmentkeyerror'] = 'That enrollment key was incorrect, please try again.';
$string['enrolname'] = 'Internal Enrollment';
$string['enrol_manual_requirekey'] = 'Require course enrollment keys in new courses and prevent removing of existing keys.';
$string['enrol_manual_showhint'] = 'Enable this setting to reveal the first character of the enrollment key as a hint if one enters an incorrect key.';
$string['enrol_manual_usepasswordpolicy'] = 'Use current user password policy for course enrollment keys.';
$string['keyholderrole' ] = 'The role of the user that holds the enrollment key for a course. Displayed to students attempting to enroll on the course.';
?>
