## UseCases ##


# JoinClass #


| Use Case | JoinClass |
|:---------|:----------|
|Identified | S1        |
| Description: | The JoinClass use case models Student adding membership status for a Class. |
|Actor(s)  | Student   |
|Preconditions: | 1. User successfully logged in as Student via the LogIn use case. |
|Flow of Events: |1. The use case starts when Student selects Add Class.|
|                |2. Student presented with a list of Classes in which it is possible for Student to register. |
|                |3. Student selects a Class from the list which Student desires to add. |
|                |3.1. Alternately, Student may search for a Class based on teacher, subject, name, or other criteria rather than choosing it from an exhaustive list.|
|                |4. Student is presented with a confirmation/warning message, asking Student to confirm the action. |
|                |4.1 If Student chooses "Confirm," he is notified that he has successfully been added to the Class. |
|                |4.2 Else if Student chooses "Cancel," he returns to the list of Classes that he may join.|
|                |5. Student is redirected to the View Active Classes screen.  |
|Post Condition:| 1. The added class is now displayed on Student's View Active Classes screen, and Student begins receiving messages, announcements, etc. related to the new Class.|