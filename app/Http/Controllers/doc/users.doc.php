<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 12/30/15
 * Time: 2:43 PM
 */

/**
 * @apiDefine UserSuccess
 * @apiSuccess (Success 2xx: User) {Integer} id The numeric id assigned to the user by the database.
 * @apiSuccess (Success 2xx: User) {String} user_identifier The user's unique identifier string.
 * @apiSuccess (Success 2xx: User) {String} username The user's username string.
 * @apiSuccess (Success 2xx: User) {String} name_prefix The user's name prefix, if there is one.
 * @apiSuccess (Success 2xx: User) {String} name_first The user's fist name.
 * @apiSuccess (Success 2xx: User) {String} name_middle The user's middle name or initial, if there is one.
 * @apiSuccess (Success 2xx: User) {String} name_last The user's last name.
 * @apiSuccess (Success 2xx: User) {String} name_postfix The user's name postfix, if there is one.
 * @apiSuccess (Success 2xx: User) {String} name_phonetic The user's phonetic name, if there is one.
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
 * @apiDefine CreateUserSuccessResultExample
 * @apiSuccessExample {json} Success Create:
 *      HTTP/1.1 201 Created
 *      {
 *          "success": true,
 *          "status_code": 201,
 *          "pagination": [],
 *          "result": {
 *              "message": "Created",
 *              "id": 151
 *          }
 *      }
 */

/**
 * @apiDefine UpdateUserSuccessResultExample
 * @apiSuccessExample {json} Success Update:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "message": "Updated",
 *              "id": 151
 *          }
 *      }
 */

/**
 * @api {post} /users/ POST: Create/Update User
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method creates a new user, or updates a user with the specified `user_identifier`.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_identifier=0979659" \
 *      --data "name_prefix=MR." \
 *      --data "name_first=Luke" \
 *      --data "name_last=Skywalker" \
 *      --data "username=skywal" \
 *      --url https://databridge.sage.edu/api/v1/users/
 *
 * @apiUse CreateUserSuccessResultExample
 * @apiUse UpdateUserSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 */

/**
 * @api {post} /users/ POST: Create/Update User
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method creates a new user, or updates a user with the specified `user_identifier`.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_identifier=0979659" \
 *      --data "name_prefix=MR." \
 *      --data "name_first=Luke" \
 *      --data "name_last=Skywalker" \
 *      --data "username=skywal" \
 *      --url https://databridge.sage.edu/api/v1/users/
 *
 * @apiUse CreateUserSuccessResultExample
 * @apiUse UpdateUserSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 */

/**
 * @api {get} /users/ GET: Request Users
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns pages of User objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse PaginationParams
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/
 *
 * @apiUse PaginatedSuccess
 * @apiUse UserSuccess
 * @apiUse GetUsersSuccessResultExample
 */

/**
 * @api {get} /users/:id GET: Request User
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns a User object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/1
 *
 * @apiUse UserSuccess
 * @apiUse GetUserSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users/username/:username GET: Request User via Username
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns a User object, a username is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/username/Caitlyn62
 *
 * @apiUse UserSuccess
 * @apiUse GetUserSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users/user_id/:user_identifier GET: Request User via Identifier
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns a User object, a user_identifier is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} user_identifier The user's unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/user_id/6223406
 *
 * @apiUse UserSuccess
 * @apiUse GetUserSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /users/user_id/:user_identifier DELETE: User via Identifier
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method deletes a User object, a user_identifier is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} user_identifier The user's unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/user_id/6223406
 *
 * @apiUse UserSuccess
 * @apiUse GetUserSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */