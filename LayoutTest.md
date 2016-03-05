## UseCases ##


# LayoutTest #


| Use Case | LayoutTest |
|:---------|:-----------|
|Identified | TE4        |
| Description: | The LayoutTest use case models Teacher modifying the Layout of an Online Test. |
|Actor(s)  | Teacher    |
|Preconditions: | 1. User successfully logged in as Teacher via the LogIn use case. |
|               | 2. The User has navigated to the desired Test in the Test GUI. |
|Flow of Events: |1. The use case starts when Teacher navigates to the aforementioned page. |
|                |2. The system displays a drag-and-drop interface for ordering questions on the Test. |
|                |3. The Teacher may change the order of the questions by use of the drag-and-drop interface. |
|                |3a. The Teacher may also choose to create Random Order groups, or utilize other such features. |
|                |4. The use case terminates when the Teacher selects "Save Changes". |
|Post Condition:| 1. The Teacher is routed back to the "My Tests" page. |