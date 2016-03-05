## UseCases ##


# View Reminder #


| Use Case | ViewReminder|
|:---------|:------------|
|Identified | TS5         |
| Description: | The ViewReminder use case models Teacher or Student viewing his Reminders.|
|Actors    | Teacher, Student|
| Preconditions: | 1. User must be successfully logged in via the Login use case.|
|Flow of Events: |1. The use case starts when User selects View Reminders.|
|                |2. User presented with a list of Reminders.|
|                |2.1 If User has no Reminders, a message reflecting that User has no reminders is displayed.|
|                |2.2 Else, User views Reminders.|
|Post Condition:| 1. User is presented with a list of Reminders.|