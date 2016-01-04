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
 * @apiDefine GetDepartmentSuccessResultExample
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