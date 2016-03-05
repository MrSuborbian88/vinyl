# Sequence Diagrams for Construction #

All of the code for the sequence diagrams was made by websequencediagrams.com


# Code for Modify Roster SD #

loop Modify Roster
> Teacher->Course: requestList()

> Course->DatabaseWrapper: queryRoster()

> DatabaseWrapper-->Course: CourseList

> Course->Course: displayroster()

> Course-->Teacher: void

> Teacher->Course: drop/join(x)

> Course->DatabaseWrapper: modifyRoster(x)
alt Success
> DatabaseWrapper-->Course: ReturnStatus

> Course-->Teacher: void
else Error
> DatabaseWrapper-->Course: ReturnError

> Course->Course: displayError()

> Course-->Teacher: void
end
end

# Code for Join/Drop Course #
loop Drop/Join Class
> Student->Course: requestList()

> Course->DatabaseWrapper?: queryRoster()

> DatabaseWrapper?-->Course: CourseList?

> Course->Course: displayroster()

> Course-->Student: void

> Student->Course: drop/join(x)

> Course->DatabaseWrapper?: modifyRoster(x)

alt Success

> DatabaseWrapper?-->Course: ReturnStatus?

> Course-->Student: void

else Error

> DatabaseWrapper?-->Course: ReturnError?

> Course->Course: displayError()

> Course-->Student: void

end end