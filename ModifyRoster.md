## UseCases ##


# ModifyRoster #


| Use Case | ModifyRoster |
|:---------|:-------------|
|Identified | T5           |
| Description: | The ModifyRoster use case models Teacher adding and/or removing one or more student from a class.|
|Actors    | Teacher      |
| Preconditions: | 1. User successfully logged in as Teacher via the LogIn use case. |
|Flow of Events: |1. The use case starts when Teacher selects Modify Roster.|
|                |2. Teacher asked to select a class from list of options. |
|                |2.1 If Teacher selects a class, move on to step 3. |
|                |2.2 If Teacher fails to select class, an error message will be shown reflecting that a class has not been chosen.|
|                |3. Teacher presented with a roster for the chosen class.|
|                |3.1 Teacher optionally selects one or more students to remove from the chosen class. |
|                |3.2 Teacher optionally selects/types (method TBD) the name of one or more students to add to the chosen course. |
|                |4. Teacher receives a message, “Roster Successfully Modified” along with a list of changes made to the roster. |
|Post Condition:| 1. The Roster for the modified class shows the updated class list.|