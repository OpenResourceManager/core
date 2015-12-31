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
 * @apiError (Authorization Error: 4xx) MissingHeaderOption The `X-Authorization` header option was not supplied to the API.
 * @apiErrorExample {json} Error: Missing Header Option
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "error": [
 *              "X-Authorization: Header Option Not Found."
 *          ]
 *      }
 * @apiError (Authorization Error: 4xx) NotPrivileged The key supplied is not authorized to perform the requested operation.
 * @apiErrorExample {json} Error: Not Privileged
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": [
 *              "X-Authorization: Insufficient privileges."
 *          ]
 *      }
 * @apiError (Authorization Error: 4xx) InvalidApiKey The key that has been supplied to the API is not valid.
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
 * @apiParam {Integer} [limit=25] The max number of objects returned. The max that will be honored by the api is 100.
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