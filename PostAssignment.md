## UseCases ##


# PostAssignment #


| Use Case | PostAssignment |
|:---------|:---------------|
|Identified | T2             |
| Description: | The PostAssignment use case models Teacher posting an Assignment on VINL. |
|Actors    | Teacher        |
| Preconditions: | 1. User successfully logged as Teacher via the LogIn use case. |
|Flow of Events: |1. The use case starts when Teacher selects Post Assignment.|
|                |2. Teacher asked to select a class from list of options. |
|                |2.1 If Teacher selects a class, move on to step 3. |
|                |2.2        If Teacher fails to select class, error message will occur reflecting that a class has not been chosen.|
|                |3. Teacher prompted to enter text.|
|                |3.1 Teacher enters desired message. |
|                |3.2 Optionally, Teacher may indicate that one or more files are to be submitted for the assignment.|
|                |3.3 Optionally, Teacher may enter a due date for the assignment.|
|                |3.4 Teacher posts the assignment. |
|                |4. If Teacher fails to enter text, an error message will occur reflecting that text has not been entered. |
|                |5. Else, Teacher receives a message, “Assignment Successfully Posted” |
|Post Condition:| 1. The assignment is available for viewing by the appropriate parties through the ReadAssignment use case.|