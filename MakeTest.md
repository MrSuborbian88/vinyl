## UseCases ##


# MakeTest #


| Use Case | MakeTest |
|:---------|:---------|
|Identified | T6       |
| Description: | The MakeTest use case models Teacher creating an Online Test. |
|Actor(s)  | Teacher  |
|Preconditions: | 1. User successfully logged in as Teacher via the LogIn use case. |
|Flow of Events: |1. The use case starts when Teacher navigates to the "My Tests" page.|
|                |2. The system displays a list of Teacher's usable tests.  Teacher begins making a new test. |
|                |3. A Graphical Interface for creating a test will be displayed.  Consult the Test Editor (TE-) use cases for details.|
|                |4. When Teacher is finished making the test:|
|                |4.1 Teacher saves the test. |
|                |4.2 Teacher discards the test. |
|                |5. The system will display an appropriate confirmation message for the Teacher's requested action.  This completes the use case. |
|Post Condition:| 1. Teacher is routed back to their "My Tests" page, where, if completed/saved, the new test is shown. |