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