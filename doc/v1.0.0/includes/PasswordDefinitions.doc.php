<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 1:57 PM
 */

/**
 * @apiDefine PasswordParameters
 * @apiParam (Password Parameters) {Integer} user_id The user that this password belongs to.
 * @apiParam (Password Parameters) {String} password The unencrypted password string.
 */

/**
 * @apiDefine PasswordSuccess
 * @apiSuccess (Success 2xx: Password) {Integer} id The numeric id assigned to the password by the database.
 * @apiSuccess (Success 2xx: Password) {Integer} user_id The user that this password belongs to.
 * @apiSuccess (Success 2xx: Password) {String} password The unencrypted password string.
 */

/**
 * @apiDefine GetPasswordsSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 20,
 *              "current_page": 1,
 *              "result_limit": 5,
 *              "next_page": "api\/v1\/passwords?limit=5&page=2",
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "user_id": 1,
 *                  "password": "dicta"
 *              },
 *              {
 *                  "id": 2,
 *                  "user_id": 2,
 *                  "password": "voluptatem"
 *              },
 *              {
 *                  "id": 3,
 *                  "user_id": 3,
 *                  "password": "exercitationem"
 *              },
 *              {
 *                  "id": 4,
 *                  "user_id": 4,
 *                  "password": "consequatur"
 *              },
 *              {
 *                  "id": 5,
 *                  "user_id": 5,
 *                  "password": "possimus"
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetPasswordSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 1,
 *              "user_id": 1,
 *              "password": "dicta"
 *          }
 *      }
 */
