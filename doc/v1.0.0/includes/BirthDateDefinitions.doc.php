<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 1:57 PM
 */

/**
 * @apiDefine BirthDateParameters1.0.0
 * @apiParam (BirthDate Parameters) {Integer} user_id The user that this password belongs to.
 * @apiParam (BirthDate Parameters) {Date} birth_date The user's birth date. In strtotime format: (https://secure.php.net/manual/en/function.strtotime.php).
 */

/**
 * @apiDefine BirthDateSuccess1.0.0
 * @apiSuccess (Success 2xx: BirthDate) {Integer} id The numeric id assigned to the password by the database.
 * @apiSuccess (Success 2xx: BirthDate) {Integer} user_id The user that this password belongs to.
 * @apiSuccess (Success 2xx: BirthDate) {Date} birth_date The user's birth date.
 */

/**
 * @apiDefine GetBirthDatesSuccessResultExample1.0.0
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 20,
 *              "current_page": 1,
 *              "result_limit": 5,
 *              "next_page": "api\/v1\/birthdates?limit=5&page=2",
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "user_id": 1,
 *                  "birth_date": "1990-09-08"
 *              },
 *              {
 *                  "id": 2,
 *                  "user_id": 2,
 *                  "birth_date": "1929-10-29"
 *              },
 *              {
 *                  "id": 3,
 *                  "user_id": 3,
 *                  "birth_date": "1970-01-01"
 *              },
 *              {
 *                  "id": 4,
 *                  "user_id": 4,
 *                  "birth_date": "1992-01-05"
 *              },
 *              {
 *                  "id": 5,
 *                  "user_id": 5,
 *                  "birth_date": "1776-07-04"
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetBirthDateSuccessResultExample1.0.0
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 1,
 *              "user_id": 1,
 *              "birth_date": "1990-09-08"
 *          }
 *      }
 */
