## UseCases ##


# DownloadDocument #


| Use Case | DownloadDocument |
|:---------|:-----------------|
|Identified | TS4              |
| Description: | The DownloadDocument use case models Student or Teacher downloading a file from VINL to their respective computer. |
|Actor(s)  | Student, Teacher |
|Preconditions: | 1. User must be successfully logged in via the LogIn use case. |
|Flow of Events: |1. The use case starts when User clicks on a link to a Document stored in VINL.|
|                |2. If User has the necessary privileges to download the chosen Document, proceed to step 3. |
|                |2.1. Else an error message is displayed indicating that User is forbidden to download the specified Document. |
|                |3. User prompted to choose a download location for the Document on his local computer. |
|                |4. If a valid location is chosen, the download begins, with an accompanying progress bar notifying User of download status. |
|                |4.1. Else an error message is displayed indicating that the Document may not be downloaded to that location.|

|Post Condition:| 1. The chosen Document is downloaded to User's local computer in the location specified.|