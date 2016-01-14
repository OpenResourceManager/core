<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 12/31/15
 * Time: 4:30 PM
 */

/**
 * @apiDefine RoleParameters
 * @apiParam (Role Parameters) {String} code The role's unique identifier string.
 * @apiParam (Role Parameters) {String} name The role's name, this is a label.
 */

/**
 * @apiDefine RoleSuccess
 * @apiSuccess (Success 2xx: Role) {Integer} id The numeric id assigned to the role by the database.
 * @apiSuccess (Success 2xx: Role) {String} code The role's unique identifier string.
 * @apiSuccess (Success 2xx: Role) {String} name The role's name, this is a label.
 */

/**
 * @apiDefine AssignmentRoleUserParams
 * @apiParam user {Integer} The database ID of the user.
 * @apiParam role {Integer} The database ID of the role.
 */

/**
 * @apiDefine AssignmentRoleUserIDParams
 * @apiParam user_id {String} The unique identifier string associated with a user.
 * @apiParam role {Integer} The database ID of the role.
 */

/**
 * @apiDefine AssignmentRoleUsernameIDParams
 * @apiParam username {String} The unique username string associated with a user.
 * @apiParam role {Integer} The database ID of the role.
 */

/**
 * @apiDefine AssignmentRoleCodeUserParams
 * @apiParam user {Integer} The database ID of the user
 * @apiParam role {String} The unique code string of the role.
 */

/**
 * @apiDefine AssignmentRoleCodeUserIDParams
 * @apiParam user_id {String} The unique identifier string associated with a user.
 * @apiParam role {String} The unique code string of the role.
 */

/**
 * @apiDefine AssignmentRoleCodeUsernameIDParams
 * @apiParam username {String} The unique username string associated with a user.
 * @apiParam role {String} The unique code string of the role.
 */

/**
 * @apiDefine GetRolesSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 1,
 *              "current_page": 1,
 *              "result_limit": 25,
 *              "next_page": null,
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "code": "STUDENT",
 *                  "name": "Student"
 *              },
 *              {
 *                  "id": 2,
 *                  "code": "EMPLOYEE",
 *                  "name": "Employee"
 *              },
 *              {
 *                  "id": 3,
 *                  "code": "FACULTY",
 *                  "name": "Faculty"
 *              },
 *              {
 *                  "id": 4,
 *                  "code": "ADJUNCT",
 *                  "name": "Adjunct"
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetRoleSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 1,
 *              "code": "STUDENT",
 *              "name": "Student"
 *          }
 *      }
 */

/**
 * @apiDefine AssignPresentRoleResultExample
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
 * @apiDefine AssignNewRoleResultExample
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
 * @apiDefine AssignmentNotPresentRoleResultExample
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
 * @apiDefine UnassignRoleResultExample
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
