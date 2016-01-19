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
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/departments/MIS
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
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/departments/code/MSI
 *
 * @apiUse ModelNotFoundError
 */