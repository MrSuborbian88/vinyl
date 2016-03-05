## UseCases ##


# LeaveClass #


| Use Case | LeaveClass |
|:---------|:-----------|
|Identified | S2         |
| Description: | The LeaveClass use case models Student removing membership status for a Class. |
|Actors    | Student    |
| Preconditions: |1. User must be successfully logged in via the LogIn use case.|
|Flow of Events: |1. The use case starts when Student selects View Active Classes.|
|                |2. The system displays a list of Student's current Classes. |
|                |3. Student selects "Drop Class" for a chosen class. |
|                |4. The system displays a confirmation/warning message. |
|                |4.1 The Student chooses "Confirm".  The system displays a confirmation message. |
|                |4.2 The Student chooses "Cancel".  |
|                |5. The Student returns to the View Active Classes screen.  |
|Post Condition:| 1. If a Class was dropped, it is no longer displayed on the screen, and Student is no longer associated with that Class.|