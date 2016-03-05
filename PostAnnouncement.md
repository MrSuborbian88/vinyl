## UseCases ##


# PostAnnouncement #


| Use Case | PostAnnouncement |
|:---------|:-----------------|
|Identified | T1               |
| Description: | The PostAnnouncement use case models Teacher posting an Announcement on VINL. |
|Actors    | Teacher          |
| Preconditions: | 1. User successfully logged in as Teacher via the LogIn use case. |
|Flow of Events: |1. The use case starts when Teacher selects Post Announcement.|
|                |2. Teacher asked to select a class from list of options. |
|                |2.1 If Teacher selects a class, move on to step 3. |
|                |2.2        If Teacher fails to select class, error message will occur reflecting that a class has not been chosen.|
|                |3. Teacher prompted to enter text.|
|                |3.1 Teacher enters desired message. |
|                |3.2 Teacher posts the announcement. |
|                |4. If Teacher fails to enter text, an error message will occur reflecting that text has not been entered. |
|                |5. Else, Teacher receives a message, “Announcement Successfully Posted” |
|Post Condition:| 1. The Assignment is available for viewing by the appropriate parties through the ReadAnnouncement use case.|