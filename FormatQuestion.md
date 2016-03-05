## UseCases ##


# FormatQuestion #


| Use Case | FormatQuestion |
|:---------|:---------------|
|Identified | TE2            |
| Description: | The FormatQuestion use case models a Teacher editing a question on an Online Test. |
|Actor(s)  | Teacher        |
|Preconditions: | 1. User successfully logged in as Teacher via the LogIn use case. |
|               | 2. User has navigated to the desired Online Test in the Test GUI. |
|Flow of Events: |1. The use case starts when Teacher has navigated to the Test GUI. |
|                |2. The Teacher selects the Question they wish to modify. |
|                |3. The Teacher selects the "Edit Question" option. |
|                |4. The system will display an appropriate interface for editing the question.  An option for changing the type of question will be visible. |
|Post Condition:| 1. Refer to step 3 of the MakeQuestion (TE1) use case to continue.  The use cases play out nearly identically from here, save for some minor differences.  For example, the option "Add Question" in TE1 will be replaced by "Save Changes". |