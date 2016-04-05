<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/7/16
 * Time: 9:20 PM
 */

/**
 * @api {post} /courses/ POST: Create/Update Course
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method creates a new course, or updates a course with the specified `number`.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m post -d "department_id=34&code=SPAN101&name=Spanish 101&course_level=100"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "department_id=34" \
 *      --data "code=SPAN101" \
 *      --data "name=Spanish 101" \
 *      --data "course_level=100" \
 *      --url https://databridge.sage.edu/api/v1/courses/
 *
 * @apiUse CourseParameters
 */

/**
 * @api {post} /courses/department/code POST: Create/Update Course with Department Code
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method creates a new course, or updates a course with the specified Department code.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m post -p department/code -d "department_code=LANG&code=SPAN101&name=Spanish 101&course_level=100"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "department_code=LANG" \
 *      --data "code=SPAN101" \
 *      --data "name=Spanish 101" \
 *      --data "course_level=100" \
 *      --url https://databridge.sage.edu/api/v1/courses/department/code
 *
 * @apiParam (Course Parameters) {Integer} department_code The code assigned to the parent department.
 * @apiParam (Course Parameters) {String} code The courses' unique identifier string.
 * @apiParam (Course Parameters) {Integer} course_level The academic level of a course.
 * @apiParam (Course Parameters) {String} name The courses' name, this is a label.
 */

/**
 * @api {delete} /courses/:id DELETE: Destroy Course
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method deletes a Course object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The courses' unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m delete -p 4
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/courses/4
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /courses/code/:code DELETE: Destroy By Code
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method deletes a Course object,  a courses' unique code is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} code The courses' unique code.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m delete -p code/SPAN101
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/courses/code/SPAN101
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /courses/ GET: Request Courses
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method returns pages of Course objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse PaginationParams
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/courses/
 *
 * @apiUse PaginatedSuccess
 * @apiUse CourseSuccess
 * @apiUse GetCoursesSuccessResultExample
 */

/**
 * @api {get} /courses/:id GET: Request Course
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method returns a Course object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The courses' unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -p 12
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/courses/12
 *
 * @apiUse CourseSuccess
 * @apiUse GetCourseSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /courses/code/:code GET: Course by Code
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method returns a Course object, a courses' unique code is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} code The courses' unique code.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -p code/SPAN101
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/courses/code/SPAN101
 *
 * @apiUse CourseSuccess
 * @apiUse GetCourseSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /courses/user/:id GET: By User ID
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method returns Course objects associated with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -p user/153
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/courses/user/153
 *
 * @apiUse CourseSuccess
 * @apiUse GetCoursesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /courses/username/:username GET: By Username
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method returns Course objects associated with the Username that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -p username/skywal
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/courses/username/skywal
 *
 * @apiUse CourseSuccess
 * @apiUse GetCoursesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /courses/identifier/:identifier GET: By User Identifier
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method returns Course objects associated with the Identifier that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} identifier The user's unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -p identifier/979659
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/courses/identifier/979659
 *
 * @apiUse CourseSuccess
 * @apiUse GetCoursesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /courses/department/:id GET: By Department ID
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method returns Course objects associated with the department's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The departments unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -p department/23
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/courses/department/23
 *
 * @apiUse CourseSuccess
 * @apiUse GetCoursesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /courses/department/code/:code GET: By Department Code
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method returns Course objects associated with the department's code.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {string} code The departments unique code.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m department/code/MIS
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/courses/department/code/MIS
 *
 * @apiUse CourseSuccess
 * @apiUse GetCoursesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {post} /courses/user POST: Assign to User
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method assigns a course to a user, using the user and course database id values.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewCourseResultExample
 * @apiUse AssignPresentCourseResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m post -p user -d "user=25&course_id=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user=25" \
 *      --data "course_id=1" \
 *      --url https://databridge.sage.edu/api/v1/courses/user
 *
 * @apiUse AssignmentCourseUserParams
 */

/**
 * @api {post} /courses/identifier POST: Assign to Identifier
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method assigns a course to a user, using the identifier value and course database id value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewCourseResultExample
 * @apiUse AssignPresentCourseResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m post -p identifier -d "identifier=0958757&course_id=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "identifier=0958757" \
 *      --data "course_id=1" \
 *      --url https://databridge.sage.edu/api/v1/courses/identifier
 *
 * @apiUse AssignmentCourseUserIDParams
 */

/**
 * @api {post} /courses/username POST: Assign to Username
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method assigns a course to a user, using the username value and course database id value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewCourseResultExample
 * @apiUse AssignPresentCourseResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m post -p username -d "username=0958757&course_id=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "username=skywal" \
 *      --data "course_id=1" \
 *      --url https://databridge.sage.edu/api/v1/courses/username
 *
 * @apiUse AssignmentCourseUsernameIDParams
 */

/**
 * @api {post} /courses/code/user POST: Assign Code to User
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method assigns a course to a user, using the user and course code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewCourseResultExample
 * @apiUse AssignPresentCourseResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m post -p code/user -d "user=25&course_code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user=25" \
 *      --data "course_code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/courses/code/user
 *
 * @apiUse AssignmentCourseCodeUserParams
 */

/**
 * @api {post} /courses/code/identifier POST: Assign Code to Identifier
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method assigns a course to a user, using the identifier value and course code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewCourseResultExample
 * @apiUse AssignPresentCourseResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m post -p code/identifier -d "identifier=0958757&course_code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "identifier=0958757" \
 *      --data "course_code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/courses/code/identifier
 *
 * @apiUse AssignmentCourseCodeUserIDParams
 */

/**
 * @api {post} /courses/code/username POST: Assign Code to Username
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method assigns a course to a user, using the username value and course code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewCourseResultExample
 * @apiUse AssignPresentCourseResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m post -p code/username -d "username=skywal&course_code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "username=skywal" \
 *      --data "course_code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/courses/code/username
 *
 * @apiUse AssignmentCourseCodeUsernameIDParams
 */

/**
 * @api {delete} /courses/user DELETE: Unassign User
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method unassigns a user from a course a user, using the user and course database id values.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignCourseResultExample
 * @apiUse AssignmentNotPresentCourseResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m delete -p user -d "user=25&course_id=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "user=25" \
 *      --data "course_id=1" \
 *      --url https://databridge.sage.edu/api/v1/courses/user
 *
 * @apiUse AssignmentCourseUserParams
 */

/**
 * @api {delete} /courses/identifier DELETE: Unassign from Identifier
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method unassigns a user from a course a user, using the identifier value and course database id value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignCourseResultExample
 * @apiUse AssignmentNotPresentCourseResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m delete -p identifier -d "identifier=0958757&course_id=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "identifier=0958757" \
 *      --data "course_id=1" \
 *      --url https://databridge.sage.edu/api/v1/courses/identifier
 *
 * @apiUse AssignmentCourseUserIDParams
 */

/**
 * @api {delete} /courses/username DELETE: Unassign from Username
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method unassigns a user from a course a user, using the username value and course database id value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignCourseResultExample
 * @apiUse AssignmentNotPresentCourseResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m delete -p username -d "username=skywal&course_id=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "username=skywal" \
 *      --data "course_id=1" \
 *      --url https://databridge.sage.edu/api/v1/courses/username
 *
 * @apiUse AssignmentCourseUsernameIDParams
 */

/**
 * @api {delete} /courses/code/user DELETE: Unassign Code from User
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method unassigns a user from a course a user, using the user and course code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignCourseResultExample
 * @apiUse AssignmentNotPresentCourseResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m delete -p code/user -d "user=25&course_code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "user=25" \
 *      --data "course_code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/courses/code/user
 *
 * @apiUse AssignmentCourseCodeUserParams
 */

/**
 * @api {delete} /courses/code/identifier DELETE: Unassign Code from Identifier
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method unassigns a user from a course a user, using the identifier value and course code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignCourseResultExample
 * @apiUse AssignmentNotPresentCourseResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m delete -p code/identifier -d "identifier=0958757&course_code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "identifier=0958757" \
 *      --data "course_code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/courses/code/identifier
 *
 * @apiUse AssignmentCourseCodeUserIDParams
 */

/**
 * @api {delete} /courses/code/username DELETE: Unassign Code from Username
 * @apiVersion 1.1.1
 * @apiGroup Courses
 * @apiDescription This method unassigns a user from a course a user, using the username value and course code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignCourseResultExample
 * @apiUse AssignmentNotPresentCourseResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o courses -m delete -p code/username -d "username=skywal&course_code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "username=skywal" \
 *      --data "course_code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/courses/code/username
 *
 * @apiUse AssignmentCourseCodeUsernameIDParams
 */