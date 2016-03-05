## UseCases ##


# TEQuestionSubmission #


| Use Case | TEQuestionSubmission |
|:---------|:---------------------|
|Identified | TE3                  |
| Description: | The TEQuestionSubmission use case models a Teacher specifying Answer Submission rules for a Question. |
|Actor(s)  | Teacher              |
|Preconditions: | 1. Teacher has successfully navigated to the desired question via the Edit/Design Question (TE2) use case. |
|Flow of Events: |1. The use case starts when the Teacher selects the "Customize Submission Rules" option. |
|                |2. The GUI will display a form for outlining the submission rules for this particular question.  |
|                |3. The makes the design modificiations he/she desires.  For details on how the Answer Submission Rules work, consult the documentation. |
|                |4. When the Teacher is finished, he/she selects "Save Changes".  This completes the use case. |
|Post Condition:| 1. Teacher is routed back to the Question Editing GUI, as utilized in the FormatQuestion (TE2) use case. |