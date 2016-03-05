## UseCases ##


# TakeTest #


| Use Case | TakeTest |
|:---------|:---------|
|Identified | S3       |
| Description: | The TakeTest use case models Student completing an Online Test. |
|Actors    | Student  |
| Preconditions: |	 1. User must be successfully logged in as Student via the LogIn use case.  |
|Flow of Events: |1. The use case starts when Student selects View Pending Tests.|
|                |2. The system displays a list of the Online Tests which Student has yet to take. |
|                |3. Student selects "Take/Continue Test" next to the specific Online Test he wishes to take. |
|                |4. Student is routed to the last question on the test that he worked on.|
|                |5.1 Student completes the specified question as via the SubmitAnswer use case.  If this is the last question on the Test, go to step 7.1.  Otherwise, go to step 6. |
|                |5.2 Student selects "Save and Quit".  Go to step 7.2.  |
|                |6. Student may choose to either continue the Test, or save his progress and quit the Test.  For the former, go to step 5.1.  Otherwise, go to step 5.2|
|                |7.1 The system displays a "Test Breakdown" page, showing the Student's final numerical grade and enumerating the Student's answers versus the correct answers.  The Student will click O.K.  This completes the use case.|
|                |7.2 The system displays confirmation message that the Test was saved.  The due date for the Test is also displayed.  Student will click O.K.  This completes the use case.|
|Post Condition:| 1. Student is routed back to the View Pending Tests page.  The modified status of the recently taken test is displayed.|