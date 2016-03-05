## UseCases ##


# MakeQuestion #


| Use Case | MakeQuestion|
|:---------|:------------|
|Identified | TE1         |
| Description: | The MakeQuestion use case models a Teacher adding a Question to an existing Online Test. |
|Actor(s)  | Teacher     |
|Preconditions: | 1. User successfully logged in as Teacher via the LogIn use case. |
|               | 2. Teacher has navigated to the Test GUI. |
|Flow of Events: |1. The use case starts when Teacher selects "New Question". |
|                |2. The system displays a list of distinct question formats, such as Multiple Choice, Fill in the Blank, etc.  The Teacher selects one of these. |
|                |3. The system displays an appropriate form for writing the question.  The Teacher fills out the form as desired. |
|                |3a. If desired, the Teacher can create more detail using the TEQuestionSubmission use case (TE3). |
|                |4. The teacher selects "Add Question". |
|                |4.1 If everything is entered appropriately, the use case is complete. |
|                |4.2 Otherwise, an appropriate error message is displayed, and the use case reroutes to step 3.  The Teacher may also choose "Cancel" to terminate the use case. |
|Post Condition:| 1. The Teacher is routed back to the Test GUI, with the proper modifications displayed. |