# Introduction #

_Include a complete set of requirements for your project.  Use the FURPS+ model to find any and all requirements for your project.  The functional requirement list must include requirements drawn out of the use cases.  All requirements must be numbered and have an assigned priority using a ranking system such as MoSCoW._

## Functionality ##
| REQ # | Priority | Summary |
|:------|:---------|:--------|
| F01   | M        | Must be capable of storing user and class data in an SQL database |
| F02   | M        | Must be capable of storing uploaded files on the server for later retrieval |
| F03   | C        | Must be capable of offering different GUIs based on user privileges |
| F04   | S        | Must be capable of handling at least 100 concurrent student accesses at once |
| F05   | S        | Must store passwords in an encrypted format (MD5) |
| F06   | M        | Must prevent students from accessing other students' information |
| F07   | C        | Must restrict teachers to accessing the information about students in their own classes |
| F08   | M        | Must prevent students from accessing teacher functionality |
| F09   | M        | Must prevent students and teachers from accessing admin functionality |
| F10   | C        | Must use no more than 4 steps (button clicks/screens/etc.) to accomplish a given task |
| F11   | S        | Must provide some form of user feedback |

## Usability ##
| REQ # | Priority | Summary |
|:------|:---------|:--------|
| U01   | C        | Must possess customizable graphical background and color scheme |
| U02   | S        | Must label and/or provide tooltips for all user-interactive features as such (buttons/links/etc.) |
| U03   | S        | Consistent design and format of screens throughout VINL |
| U04   | M        | Must provide explanation of all features and how to use them |
| U05   | C        | Must provide tutorial for first-time users |
| U06   | M        | System failure should result in error messages rather than crashes |
| U07   | S        | In the case of failure, users must be notified |
| U08   | M        | Must exhibit partitioned failure—one failure shouldn't cause another component to fail |
| U09   | S        | Must log all errors to allow determination of what error(s) occurred in case of failure |

## Reliability ##
| REQ # | Priority | Summary |
|:------|:---------|:--------|
| RO1   | M        | Must deliver same results every time a given command is used |
| RO2   | S        | Mean time to failure shall be no less than one scholastic year |

## Performance ##
| REQ # | Priority | Summary |
|:------|:---------|:--------|
| P01   | S        | System start up will take at most 2 minutes |
| P02   | S        | System shut down will take at most 2 minutes|
| P03   | C        | System will respond to all user requests in at most 3 seconds |

## Supportability ##
| REQ # | Priority | Summary |
|:------|:---------|:--------|
| S01   | S        | System installation will take at most 10 minutes |
| S02   | M        | System will support multiple languages |
| S03   | M        | New module installation will not require changes to other modules |

## + (Miscellaneous) ##
| REQ # | Priority | Summary |
|:------|:---------|:--------|
| M01   | S        | At least 7 out of 10 test users will agree the system interface is user friendly |