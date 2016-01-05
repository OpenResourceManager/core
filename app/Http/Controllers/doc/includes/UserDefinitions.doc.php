<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 12/30/15
 * Time: 2:43 PM
 */

/**
 * @apiDefine UserParameters
 * @apiParam (User Parameters) {String} user_identifier The user's unique identifier string.
 * @apiParam (User Parameters) {String} [name_prefix] The user's name prefix, if there is one.
 * @apiParam (User Parameters) {String} name_first The user's fist name.
 * @apiParam (User Parameters) {String} [name_middle] The user's middle name or initial, if there is one.
 * @apiParam (User Parameters) {String} name_last The user's last name.
 * @apiParam (User Parameters) {String} [name_postfix] The user's name postfix, if there is one.
 * @apiParam (User Parameters) {String} [name_phonetic] The user's phonetic name, if there is one.
 * @apiParam (User Parameters) {String} username The user's username string.
 */

/**
 * @apiDefine UserSuccess
 * @apiSuccess (Success 2xx: User) {Integer} id The numeric id assigned to the user by the database.
 * @apiSuccess (Success 2xx: User) {String} user_identifier The user's unique identifier string.
 * @apiSuccess (Success 2xx: User) {String} name_prefix The user's name prefix, if there is one.
 * @apiSuccess (Success 2xx: User) {String} name_first The user's fist name.
 * @apiSuccess (Success 2xx: User) {String} name_middle The user's middle name or initial, if there is one.
 * @apiSuccess (Success 2xx: User) {String} name_last The user's last name.
 * @apiSuccess (Success 2xx: User) {String} name_postfix The user's name postfix, if there is one.
 * @apiSuccess (Success 2xx: User) {String} name_phonetic The user's phonetic name, if there is one.
 * @apiSuccess (Success 2xx: User) {String} username The user's username string.
 */

/**
 * @apiDefine GetUsersSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 30,
 *              "current_page": 1,
 *              "result_limit": 5,
 *              "next_page": "api\/v1\/users?limit=5&page=2",
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "user_identifier": "6223406",
 *                  "username": "Caitlyn62",
 *                  "name_prefix": "Ms.",
 *                  "name_first": "Robb",
 *                  "name_middle": "Irwin",
 *                  "name_last": "Fritsch",
 *                  "name_postfix": "Dr.",
 *                  "name_phonetic": null
 *              },
 *              {
 *                  "id": 2,
 *                  "user_identifier": "4027012",
 *                  "username": "Manley.Hirthe",
 *                  "name_prefix": "Mr.",
 *                  "name_first": "Eunice",
 *                  "name_middle": "Reva",
 *                  "name_last": "Pfeffer",
 *                  "name_postfix": "Dr.",
 *                  "name_phonetic": null
 *              },
 *              {
 *                  "id": 3,
 *                  "user_identifier": "2892039",
 *                  "username": "Tess39",
 *                  "name_prefix": "Ms.",
 *                  "name_first": "Franco",
 *                  "name_middle": null,
 *                  "name_last": "Kirlin",
 *                  "name_postfix": "Mr.",
 *                  "name_phonetic": "Jerald"
 *              },
 *              {
 *                  "id": 4,
 *                  "user_identifier": "9901344",
 *                  "username": "Sauer.Eulalia",
 *                  "name_prefix": null,
 *                  "name_first": "Karianne",
 *                  "name_middle": "Mollie",
 *                  "name_last": "Aufderhar",
 *                  "name_postfix": "Prof.",
 *                  "name_phonetic": "Shanna"
 *              },
 *              {
 *                  "id": 5,
 *                  "user_identifier": "4619979",
 *                  "username": "Lang.Sydnee",
 *                  "name_prefix": null,
 *                  "name_first": "Leopold",
 *                  "name_middle": "Nicholaus",
 *                  "name_last": "Lesch",
 *                  "name_postfix": "Dr.",
 *                  "name_phonetic": "Emanuel"
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetUserSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 1,
 *              "user_identifier": "6223406",
 *              "username": "Caitlyn62",
 *              "name_prefix": "Ms.",
 *              "name_first": "Robb",
 *              "name_middle": "Irwin",
 *              "name_last": "Fritsch",
 *              "name_postfix": "Dr.",
 *              "name_phonetic": null
 *          }
 *      }
 */

/**
 * @apiDefine GetUsersEmailsSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 1,
 *              "current_page": 1,
 *              "result_limit": 15,
 *              "next_page": null,
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 501,
 *                  "user_id": 153,
 *                  "email": "skywalker@yahoo.com"
 *              },
 *              {
 *                  "id": 503,
 *                  "user_id": 153,
 *                  "email": "skywalker@gmail.com"
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetUsersPhonesSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 1,
 *              "current_page": 1,
 *              "result_limit": 15,
 *              "next_page": null,
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 504,
 *                  "user_id": 153,
 *                  "number": 16549758012,
 *                  "ext": 0,
 *                  "is_cell": true,
 *                  "carrier": "Cricket Wireless"
 *              },
 *              {
 *                  "id": 504,
 *                  "user_id": 153,
 *                  "number": 1569758012,
 *                  "ext": 0,
 *                  "is_cell": false,
 *                  "carrier": null
 *              }
 *          ]
 *      }
 */

