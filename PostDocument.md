## UseCases ##


# PostDocument #


| Use Case | PostDocument|
|:---------|:------------|
|Identified | T4          |
| Description: | The PostDocument use case models Teacher posting a Document from his or her personal computer to VINL.|
|Actors    | Teacher     |
| Preconditions: | 1. User successfully logged in as Teacher via the Login use case.|
|Flow of Events: |1. The use case starts when Teacher decides to post a document.|
|                |2. Teacher is presented with a list of classes.|
|                |2.1 Teacher chooses a class from the list.|
|                |3. Teacher prompted to locate the file(s) on his or her personal computer.|
|                |4. Teacher uploads the document.|
|                | 4.1 If files upload successfully, Teacher receives the message, “Document(s) successfully uploaded.” |
|                |4.2 If files did not upload successfully, Teacher receives an error message reflecting the error.|
|                |4.2.1 Teacher returns to step 3. |
|Post Condition:| 1. The chosen document(s) from Teacher’s computer uploaded to VINL.|
|               | 2.Users associated with the chosen class can view the documents via the ReadDocument use case.|
|               | 3.Users associated with the chosen class can download the documents via the DownloadDocument use case.|