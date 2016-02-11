<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/7/16
 * Time: 8:18 PM
 */

/**
 * @api {post} /departments/ POST: Create/Update Department
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method creates a new department, or updates a department with the specified `code`.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -m post -d "academic=0&code=MIS&name=Management Information Systems"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "academic=0" \
 *      --data "code=MIS" \
 *      --data "name=Management Information Systems" \
 *      --url https://databridge.sage.edu/api/v1/departments
 *
 * @apiUse DepartmentParameters
 */

/**
 * @api {delete} /departments/:id DELETE: Destroy Department
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method deletes a Department object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The department's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -m delete -p 4
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/departments/4
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /departments/ GET: Request Departments
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method returns pages of Department objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse PaginationParams
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/departments
 *
 * @apiUse PaginatedSuccess
 * @apiUse DepartmentSuccess
 * @apiUse GetDepartmentsSuccessResultExample
 */

/**
 * @api {get} /departments/:id GET: Department by ID
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method returns a Department object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The department's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -p 12
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/departments/12
 *
 * @apiUse DepartmentSuccess
 * @apiUse GetDepartmentSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /departments/code/:code GET: Department by Code
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method returns a Department object, a department's unique code is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} id The department's unique code.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -p code/MIS
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/departments/code/MIS
 *
 * @apiUse DepartmentSuccess
 * @apiUse GetDepartmentSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /departments/course/{id} GET: By Course ID
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method returns pages of Department objects, based on the course ID passed in.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse PaginationParams
 *
 * @apiParam {Integer} id The courses' unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -p course/3
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/departments/course/3
 *
 * @apiUse PaginatedSuccess
 * @apiUse DepartmentSuccess
 * @apiUse GetDepartmentsSuccessResultExample
 */

/**
 * @api {get} /departments/course/code/{code} GET: By Course Code
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method returns pages of Department objects, based on the course ID passed in.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse PaginationParams
 *
 * @apiParam {String} id The courses' unique code.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -p course/code/SPAN101
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/departments/course/code/SPAN101
 *
 * @apiUse PaginatedSuccess
 * @apiUse DepartmentSuccess
 * @apiUse GetDepartmentsSuccessResultExample
 */

/**
 * @api {delete} /departments/code/:code DELETE: Destroy by Code
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method deletes a Department object, a department code is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} code The department's unique code.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -m delete -p code/MIS
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/departments/code/MSI
 *
 * @apiUse ModelNotFoundError
 */






/**
 * @api {post} /departments/user POST: Assign to User
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method assigns a department to a user, using the user and department database id values.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewDepartmentResultExample
 * @apiUse AssignPresentDepartmentResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -m post -p user -d "user=25&department_id=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user=25" \
 *      --data "department_id=1" \
 *      --url https://databridge.sage.edu/api/v1/departments/user
 *
 * @apiUse AssignmentDepartmentUserParams
 */

/**
 * @api {post} /departments/user_identifier POST: Assign to Identifier
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method assigns a department to a user, using the user_identifier value and department database id value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewDepartmentResultExample
 * @apiUse AssignPresentDepartmentResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -m post -p user_identifier -d "user_identifier=0958757&department_id=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_identifier=0958757" \
 *      --data "department_id=1" \
 *      --url https://databridge.sage.edu/api/v1/departments/user_identifier
 *
 * @apiUse AssignmentDepartmentUserIDParams
 */

/**
 * @api {post} /departments/username POST: Assign to Username
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method assigns a department to a user, using the username value and department database id value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewDepartmentResultExample
 * @apiUse AssignPresentDepartmentResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -m post -p username -d "username=0958757&department_id=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "username=skywal" \
 *      --data "department_id=1" \
 *      --url https://databridge.sage.edu/api/v1/departments/username
 *
 * @apiUse AssignmentDepartmentUsernameIDParams
 */

/**
 * @api {post} /departments/code/user POST: Assign Code to User
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method assigns a department to a user, using the user and department code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewDepartmentResultExample
 * @apiUse AssignPresentDepartmentResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -m post -p code/user -d "user=25&department_code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user=25" \
 *      --data "department_code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/departments/code/user
 *
 * @apiUse AssignmentDepartmentCodeUserParams
 */

/**
 * @api {post} /departments/code/user_identifier POST: Assign Code to Identifier
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method assigns a department to a user, using the user_identifier value and department code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewDepartmentResultExample
 * @apiUse AssignPresentDepartmentResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -m post -p code/user_identifier -d "user_identifier=0958757&department_code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_identifier=0958757" \
 *      --data "department_code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/departments/code/user_identifier
 *
 * @apiUse AssignmentDepartmentCodeUserIDParams
 */

/**
 * @api {post} /departments/code/username POST: Assign Code to Username
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method assigns a department to a user, using the username value and department code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewDepartmentResultExample
 * @apiUse AssignPresentDepartmentResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -m post -p code/username -d "username=skywal&department_code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "username=skywal" \
 *      --data "department_code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/departments/code/username
 *
 * @apiUse AssignmentDepartmentCodeUsernameIDParams
 */

/**
 * @api {delete} /departments/user DELETE: Unassign User
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method unassigns a user from a department a user, using the user and department database id values.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignDepartmentResultExample
 * @apiUse AssignmentNotPresentDepartmentResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -m delete -p user -d "user=25&department_id=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "user=25" \
 *      --data "department_id=1" \
 *      --url https://databridge.sage.edu/api/v1/departments/user
 *
 * @apiUse AssignmentDepartmentUserParams
 */

/**
 * @api {delete} /departments/user_identifier DELETE: Unassign from Identifier
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method unassigns a user from a department a user, using the user_identifier value and department database id value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignDepartmentResultExample
 * @apiUse AssignmentNotPresentDepartmentResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -m delete -p user_identifier -d "user_identifier=0958757&department_id=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "user_identifier=0958757" \
 *      --data "department_id=1" \
 *      --url https://databridge.sage.edu/api/v1/departments/user_identifier
 *
 * @apiUse AssignmentDepartmentUserIDParams
 */

/**
 * @api {delete} /departments/username DELETE: Unassign from Username
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method unassigns a user from a department a user, using the username value and department database id value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignDepartmentResultExample
 * @apiUse AssignmentNotPresentDepartmentResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -m delete -p username -d "username=skywal&department_id=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "username=skywal" \
 *      --data "department_id=1" \
 *      --url https://databridge.sage.edu/api/v1/departments/username
 *
 * @apiUse AssignmentDepartmentUsernameIDParams
 */

/**
 * @api {delete} /departments/code/user DELETE: Unassign Code from User
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method unassigns a user from a department a user, using the user and department code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignDepartmentResultExample
 * @apiUse AssignmentNotPresentDepartmentResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -m delete -p code/user -d "user=25&department_code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "user=25" \
 *      --data "department_code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/departments/code/user
 *
 * @apiUse AssignmentDepartmentCodeUserParams
 */

/**
 * @api {delete} /departments/code/user_identifier DELETE: Unassign Code from Identifier
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method unassigns a user from a department a user, using the user_identifier value and department code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignDepartmentResultExample
 * @apiUse AssignmentNotPresentDepartmentResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -m delete -p code/user_identifier -d "user_identifier=0958757&department_code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "user_identifier=0958757" \
 *      --data "department_code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/departments/code/user_identifier
 *
 * @apiUse AssignmentDepartmentCodeUserIDParams
 */

/**
 * @api {delete} /departments/code/username DELETE: Unassign Code from Username
 * @apiVersion 1.1.1
 * @apiGroup Departments
 * @apiDescription This method unassigns a user from a department a user, using the username value and department code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignDepartmentResultExample
 * @apiUse AssignmentNotPresentDepartmentResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o departments -m delete -p code/username -d "username=skywal&department_code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "username=skywal" \
 *      --data "department_code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/departments/code/username
 *
 * @apiUse AssignmentDepartmentCodeUsernameIDParams
 */