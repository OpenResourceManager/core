<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 12/30/15
 * Time: 3:23 PM
 */

/**
 * @apiDefine ApiErrorFields
 * @apiError (Error: 4xx) {Boolean} success Tells the application if the request was successful.
 * @apiError (Error: 4xx) {Integer} status_code The HTTP status code of the request, this is also available in the header.
 * @apiError (Error: 4xx) {String[]} error An array containing a descriptions of each error.
 */

/**
 * @apiDefine ApiSuccessFields
 * @apiSuccess (Success: 2xx) {Boolean} success Tells the application if the request was successful.
 * @apiSuccess (Success: 2xx) {Integer} status_code The HTTP status code of the request, this is also available in the header.
 * @apiSuccess (Success: 2xx) {Object_Or_Null} pagination A key to reference for paginated results, this may be null if only a single object has been returned.
 * @apiSuccess (Success: 2xx) {Object[]_Or_Object} result An array of objects or a single object.
 */

/**
 * @apiDefine ApiSuccessExampleDestroy
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": "Object Destroyed"
 *      }
 */

/**
 * @apiDefine AuthorizationHeader
 * @apiHeader {String} X-Authorization The application's unique access-key.
 *
 * @apiError (Authorization Error: 4xx) {String} MissingHeaderOption The `X-Authorization` header option was not supplied to the API.
 * @apiErrorExample {json} Error: Missing Header Option
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "error": [
 *              "X-Authorization: Header Option Not Found."
 *          ]
 *      }
 * @apiError (Authorization Error: 4xx) {String} NotPrivileged The key supplied is not authorized to perform the requested operation.
 * @apiErrorExample {json} Error: Not Privileged
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": [
 *              "X-Authorization: Insufficient privileges."
 *          ]
 *      }
 * @apiError (Authorization Error: 4xx) {String} InvalidApiKey The key that has been supplied to the API is not valid.
 * @apiErrorExample {json} Error: Invalid API Key
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": [
 *              "X-Authorization: API Key is not valid."
 *          ]
 *      }
 */

/**
 * @apiDefine PaginationParams
 * @apiParam {Integer} [limit=100] The max number of objects returned. The max that will be honored by the api is 1500.
 * @apiParam {Integer} [page=1] The page of results to return.
 */

/**
 * @apiDefine PaginatedSuccess
 * @apiSuccess (Pagination) {Integer} total_pages The total number of pages available.
 * @apiSuccess (Pagination) {Integer} current_page The currently selected page.
 * @apiSuccess (Pagination) {Integer} result_limit The max amount of results returned per request.
 * @apiSuccess (Pagination) {String} next_page The next page available in url form.
 * @apiSuccess (Pagination) {String} previous_page The previous page in url form.
 */

/**
 * @apiDefine ModelNotFoundError
 * @apiError (Model Error: 4xx) {String} ModelNotFound The API was unable to find the requested model or the model type.
 * @apiErrorExample {json} Error: Not Found
 *      HTTP/1.1 404 Not Found
 *      {
 *          "success": false,
 *          "status_code": 404,
 *          "error": [
 *              "No query results for model <Model Name>."
 *          ]
 *      }
 */

/**
 * @apiDefine UnprocessableEntityErrors
 * @apiError (Model Error: 4xx) {String} UnprocessableEntity The API unable to complete the request. This is generally caused by a violation of various constraints, such as maximum characters or missing a required data field.
 * @apiErrorExample {json} Error: Unprocessable Entity
 *      HTTP/1.1 422 Unprocessable Entity
 *      {
 *          "success": false,
 *          "status_code": 422,
 *          "error": [
 *              "The <Field Name> field is required.",
 *              "The <Field Name> must be at least <Minimum Number> characters.",
 *              "The <Field Name> may not be greater than <Maximum Number> characters."
 *          ]
 *      }
 */

/**
 * @apiDefine CreateSuccessResultExample
 * @apiSuccessExample {json} Success Create:
 *      HTTP/1.1 201 Created
 *      {
 *          "success": true,
 *          "status_code": 201,
 *          "pagination": [],
 *          "result": {
 *              "message": "Created",
 *              "id": <ID of the new object.>
 *          }
 *      }
 */

/**
 * @apiDefine UpdateSuccessResultExample
 * @apiSuccessExample {json} Success Update:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "message": "Updated",
 *              "id": <ID of the object that was updated.>
 *          }
 *      }
 */

/**
 * @apiDefine AssignmentRoomUserParams
 * @apiParam user {Integer} The database ID of the user.
 * @apiParam room {Integer} The database ID of the room.
 */

/**
 * @apiDefine AssignmentRoomUserIDParams
 * @apiParam user_id {String} The unique identifier string associated with a user.
 * @apiParam room {Integer} The database ID of the room.
 */

/**
 * @apiDefine AssignmentRoomUsernameIDParams
 * @apiParam username {String} The unique username string associated with a user.
 * @apiParam room {Integer} The database ID of the room.
 */

/**
 * @apiDefine AssignmentRoomCodeUserParams
 * @apiParam user {Integer} The database ID of the user
 * @apiParam room {String} The unique code string of the room.
 */

/**
 * @apiDefine AssignmentRoomCodeUserIDParams
 * @apiParam user_id {String} The unique identifier string associated with a user.
 * @apiParam room {String} The unique code string of the room.
 */

/**
 * @apiDefine AssignmentRoomCodeUsernameIDParams
 * @apiParam username {String} The unique username string associated with a user.
 * @apiParam room {String} The unique code string of the room.
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
 * @apiDefine AssignPresentRoomResultExample
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
 *                  "room": 1
 *              }
 *          }
 *      }
 */

/**
 * @apiDefine AssignNewRoomResultExample
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
 *                  "room": 1
 *              }
 *          }
 *      }
 */

/**
 * @apiDefine AssignmentNotPresentRoomResultExample
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
 *                  "room": 1
 *              }
 *          }
 *      }
 */

/**
 * @apiDefine UnassignRoomResultExample
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
 *                  "room": 1
 *              }
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