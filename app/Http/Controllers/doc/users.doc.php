<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 12/30/15
 * Time: 2:43 PM
 */

/**
 * @apiDefine UsersSuccess
 * @apiSuccess {Boolean} success Tells the application if the request was successful.
 * @apiSuccess {Integer} status_code The HTTP status code of the request, this is also available in the header.
 * @apiSuccess {Object[]} result An array of User objects.
 */

/**
 * @apiDefine UserSuccess
 * @apiSuccess (User) {Integer} id The numeric id assigned to the user by the database.
 * @apiSuccess (User) {String} user_identifier The user's unique identifier string.
 * @apiSuccess (User) {String} username The user's username string.
 * @apiSuccess (User) {String} name_prefix The user's name prefix, if there is one.
 * @apiSuccess (User) {String} name_first The user's fist name.
 * @apiSuccess (User) {String} name_middle The user's middle name or initial, if there is one.
 * @apiSuccess (User) {String} name_last The user's last name.
 * @apiSuccess (User) {String} name_postfix The user's name postfix, if there is one.
 * @apiSuccess (User) {String} name_phonetic The phonetic user's name, if there is one.
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
 * @api {get} /users/ Get: Request Users
 * @apiVersion 1.1.1
 * @apiName GetUsers
 * @apiGroup Users
 * @apiDescription This method returns pages of User objects.
 *
 * @apiUse AuthorizationHeader
 * @apiUse PaginationParams
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/
 *
 * @apiUse PaginatedSuccess
 * @apiUse UsersSuccess
 * @apiUse UserSuccess
 * @apiUse GetUsersSuccessResultExample
 */

/**
 * @api {get} /users/:id Get: Request a User
 * @apiVersion 1.1.1
 * @apiName GetUser
 * @apiGroup Users
 * @apiDescription This method returns a User object.
 *
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id Users unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/1
 *
 * @apiSuccess {Object} pagination Will be null, there can only be one user returned.
 * @apiSuccess {Object} result The User object.
 * @apiUse UserSuccess
 * @apiUse GetUserSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */