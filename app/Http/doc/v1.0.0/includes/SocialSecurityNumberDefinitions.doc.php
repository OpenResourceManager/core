<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 4/5/16
 * Time: 6:31 PM
 */

/**
 * @apiDefine SSNParameters
 * @apiParam (SSN Parameters) {Integer} user_id The user that this ssn belongs to.
 * @apiParam (SSN Parameters) {String} ssn The unencrypted 4 digit social security number string.
 */

/**
 * @apiDefine SSNSuccess
 * @apiSuccess (Success 2xx: SSN) {Integer} id The numeric id assigned to the password by the database.
 * @apiSuccess (Success 2xx: SSN) {Integer} user_id The user that this ssn belongs to.
 * @apiSuccess (Success 2xx: SSN) {String} ssn The unencrypted 4 digit social security number string.
 */

/**
 * @apiDefine GetSSNsSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 20,
 *              "current_page": 1,
 *              "result_limit": 5,
 *              "next_page": "api\/v1\/ssn?limit=5&page=2",
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "user_id": 1,
 *                  "ssn": "9743"
 *              },
 *              {
 *                  "id": 2,
 *                  "user_id": 2,
 *                  "ssn": "6253"
 *              },
 *              {
 *                  "id": 3,
 *                  "user_id": 3,
 *                  "ssn": "7463"
 *              },
 *              {
 *                  "id": 4,
 *                  "user_id": 4,
 *                  "ssn": "8367"
 *              },
 *              {
 *                  "id": 5,
 *                  "user_id": 5,
 *                  "ssn": "4242"
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetSSNSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 1,
 *              "user_id": 1,
 *              "ssn": "9743"
 *          }
 *      }
 */
