## UseCases ##


# PostReminder #


| Use Case | PostReminder |
|:---------|:-------------|
|Identified | T4           |
| Description: | The PostReminder use case models Teacher posting a Reminder on VINL.|
|Actors    | Teacher      |
| Preconditions: | 1. Teacher successfully logged in as Teacher via the LogIn use case. |
|Flow of Events: |1. The use case starts when Teacher selects Post Reminder.|
|                |2. Teacher asked to select a class from list of options. |
|                |2.1 If Teacher selects a class, move on to step 3. |
|                |2.2        If Teacher fails to select class, error message will occur reflecting that a class has not been chosen.|
|                |3. Teacher prompted to enter text.|
|                |3.1 Teacher enters desired message. |
|                |3.2 Teacher enters a desired date and time for the reminder to appear. |
|                |3.3 Teacher posts the reminder. |
|                |4. If Teacher fails to enter text, date, and time, Teacher receives an error message reflecting the missing information.|
|                |5. Else Teacher receives a message, “Reminder Successfully Posted” |
|Post Condition:|1. Reminder posted to selected class. |
|               |2. Students in the selected class able to view Reminder via the ViewReminder use case.|