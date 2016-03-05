## UseCases ##


# BatchDownload #


| Use Case | BatchDownload |
|:---------|:--------------|
|Identified | T8            |
| Description: | The BatchDownload use case models Teacher downloading a group of related file from VINL to his computer in a single operation. |
|Actor(s)  | Teacher       |
|Preconditions: | 1. User successfully logged in as Teacher via the LogIn use case. |
|Flow of Events: |1. The use case starts when Teacher clicks on Batch Download.|
|                |2. Teacher presented with a list of options: Assignment, Student, and Selection. |
|                |2.1. If "Assignment" is chosen, Teacher presented with a list of assignments he has created; when Teacher selects one, proceed to step 3.1. |
|                |2.2. If "Student" is chosen, Teacher presented with a list of students in any of his classes; when Teacher selects one, proceed to step 3.2. |
|                |2.3. If "Selection" is chosen, Teacher presented with a list of documents submitted by any of his students for any assignments he has created; when Teacher selects one or more of these, proceed to step 3.3. |
|                |3. Teacher prompted to choose a download location for the documents on his local computer. |
|                |3.1. If Teacher chose "Assignment," all documents that have been submitted for that assignment are downloaded sequentially to the chosen download location. |
|                |3.2. If Teacher chose "Student," all documents that have been submitted by that student are downloaded sequentially to the chosen download location. |
|                |3.3. If Teacher chose "Selection," all documents that Teacher highlighted/selected are downloaded sequentially to the chosen download location. |
|                |4. If a valid location is chosen, the download begins, with an accompanying progress bar notifying the User of download status. |
|                |4.1. Else an error message is displayed indicating that the documents may not be downloaded to that location.|

|Post Condition:| 1. The chosen documents are on User's local computer in the location specified.|