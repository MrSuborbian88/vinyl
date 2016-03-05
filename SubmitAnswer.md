## UseCases ##


# SubmitAnswer #

| Use Case | SubmitAnswer |
|:---------|:-------------|
|Identified | S3A          |
| Description: | The SubmitAnswer use case models Student submitting the answer to a question via the Online Test interface. |
|Actor(s)  | Student      |
|Preconditions: | 1. User must be successfully logged in as Student via the LogIn use case. |
|               | 2. Student must have completed the appropriate steps in the TakeTest use case. |
|Flow of Events: |1. The use case starts when Student navigates to the question he desires to answer.  |
|                |2. The system displays the question in a specific format. |
|                |3. Student does the necessary work to compute the answer, and then enters it depending on the format. |
|                |3.1 For Multiple-choice/True-False questions, Student must select an answer from a list of options to submit.|
|                |3.2 For other questions, or combination questions, Student must enter text in the appropriate fields. |
|                |4. Student selects "Submit" when the answer is prepared: |
|                |4.1 If Student has omitted a certain portion or not-filled it out properly, an appropriate error message will be displayed.  Return to step 3. |
|                |4.2 If the test is equipped with a feedback/correction system, and Student has not run out of chances, appropriate feedback is given to Student.  Return to step 3. |
|                |4.3 If Student is out of submission chances or the submitted answer is verified to be correct, an appropriate message is displayed.  This completes the use case. |
|Post Condition:| 1. The system outputs that the question is closed and/or correct.  The Online Test continues as outlined in the TakeTest use case. |