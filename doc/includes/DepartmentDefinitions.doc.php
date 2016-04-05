<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 12/31/15
 * Time: 4:30 PM
 */

/**
 * @apiDefine DepartmentParameters
 * @apiParam (Department Parameters) {Boolean} academic Signifies if the department is considered an academic department.
 * @apiParam (Department Parameters) {String} code The department's unique identifier string.
 * @apiParam (Department Parameters) {String} name The department's name, this is a label.
 */

/**
 * @apiDefine DepartmentSuccess
 * @apiSuccess (Success 2xx: Department) {Integer} id The numeric id assigned to the department by the database.
 * @apiSuccess (Success 2xx: Department) {Boolean} academic Signifies if the department is considered an academic department.
 * @apiSuccess (Success 2xx: Department) {String} code The department's unique identifier string.
 * @apiSuccess (Success 2xx: Department) {String} name The department's name, this is a label.
 */


/**
 * @apiDefine AssignmentDepartmentUserParams
 * @apiParam user_id {Integer} The database ID of the user.
 * @apiParam department_id {Integer} The database ID of the department.
 */

/**
 * @apiDefine AssignmentDepartmentUserIDParams
 * @apiParam identifier {String} The unique identifier string associated with a user.
 * @apiParam department_id {Integer} The database ID of the department.
 */

/**
 * @apiDefine AssignmentDepartmentUsernameIDParams
 * @apiParam username {String} The unique username string associated with a user.
 * @apiParam department_id {Integer} The database ID of the department.
 */

/**
 * @apiDefine AssignmentDepartmentCodeUserParams
 * @apiParam user_id {Integer} The database ID of the user
 * @apiParam department_code {String} The unique code string of the department.
 */

/**
 * @apiDefine AssignmentDepartmentCodeUserIDParams
 * @apiParam identifier {String} The unique identifier string associated with a user.
 * @apiParam department_code {String} The unique code string of the department.
 */

/**
 * @apiDefine AssignmentDepartmentCodeUsernameIDParams
 * @apiParam username {String} The unique username string associated with a user.
 * @apiParam department_code {String} The unique code string of the department.
 */

/**
 * @apiDefine GetDepartmentsSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 20,
 *              "current_page": 1,
 *              "result_limit": 5,
 *              "next_page": "api\/v1\/departments?limit=5&page=2",
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "academic": true,
 *                  "code": "Qui.",
 *                  "name": "Lebsack, Renner and Orn"
 *              },
 *              {
 *                  "id": 2,
 *                  "academic": true,
 *                  "code": "Id.",
 *                  "name": "Hayes, Medhurst and Schaden"
 *              },
 *              {
 *                  "id": 3,
 *                  "academic": false,
 *                  "code": "Quas.",
 *                  "name": "Harvey Ltd"
 *              },
 *              {
 *                  "id": 4,
 *                  "academic": false,
 *                  "code": "Et eos.",
 *                  "name": "Crist and Sons"
 *              },
 *              {
 *                  "id": 5,
 *                  "academic": false,
 *                  "code": "Et et.",
 *                  "name": "Larkin, Okuneva and Hand"
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetDepartmentSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 1,
 *              "academic": true,
 *              "code": "Qui.",
 *              "name": "Lebsack, Renner and Orn"
 *          }
 *      }
 */

/**
 * @apiDefine AssignPresentDepartmentResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "message": "Assignment Already Present",
 *              "id": {
 *                  "user": 20,
 *                  "role": 1
 *              }
 *          }
 *      }
 */

/**
 * @apiDefine AssignNewDepartmentResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "message": "Assigned",
 *              "id": {
 *                  "user": 20,
 *                  "role": 1
 *              }
 *          }
 *      }
 */

/**
 * @apiDefine AssignmentNotPresentDepartmentResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "message": "Assignment Not Present",
 *              "id": {
 *                  "user": 20,
 *                  "role": 1
 *              }
 *          }
 *      }
 */

/**
 * @apiDefine UnassignDepartmentResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "message": "Unassigned",
 *              "id": {
 *                  "user": 20,
 *                  "role": 1
 *              }
 *          }
 *      }
 */