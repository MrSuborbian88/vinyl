## UseCases ##


# ReadAnnouncement #


| Use Case | ReadAnnouncement |
|:---------|:-----------------|
|Identified | TS1              |
| Description: | The ReadAnnouncement use case models Teacher or Student viewing a class Announcement on VINL. |
|Actors    | Teacher and Student |
| Preconditions: | 1. User must be successfully logged in via the LogIn use case. |
|Flow of Events: |1. The use case starts when the User selects View Recent Announcements.|
|                |2. The system displays a list of the most recent posted Announcements. |
|                |2.1 (Optional) User may conduct a search using keywords or specifying a time condition to locate particular Announcements.  |
|                |3. User selects an Announcement to view. |
|Post Condition: | 1. The selected announcement are displayed.|