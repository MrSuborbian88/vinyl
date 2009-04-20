<?php
	//Some of these may not be needed, depending on what's needed to create the quiz object
	require_once("../../config.php");
	require_once($CFG->dirroot.'/mod/quiz/editlib.php');
	require_once($CFG->dirroot.'/mod/quiz/lib.php');
	require_once($CFG->dirroot.'/course/lib.php');
	require_once($CFG->libdir.'/gradelib.php');
	
	$id = required_param('id', PARAM_INT);
	if (!$course = get_record("course", "id", $id)) {
		error("Course ID is incorrect");
	}
	
	$questions = required_param('questions', PARAM_INT);
	$questionsarray = split(",", $_GET{questions});
	$quiz = optional_param('quiz', PARAM_INT);
	
	if (!$quiz){
		//Do stuff to create an object that has quiz parameters, put it in $quiz
		
	}
	
	//Create a quiz from the object
	if(!$quizid = quiz_add_instance($quiz)) {
		error("There was a problem creating the quiz");
	}
	
	//Add each question to the quiz
	foreach ($questionsarray as $questionid){
		quiz_add_quiz_question($questionid, &$quizid);
	}
	
	//Where do we want to go after this?
	//redirect();
?>
