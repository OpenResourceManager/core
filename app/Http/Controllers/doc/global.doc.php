<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 12/30/15
 * Time: 3:23 PM
 */

/**
 * @apiDefine ApiErrorFields
 * @apiError {Boolean} success Tells the application if the request was successful.
 * @apiError {Integer} status_code The HTTP status code of the request, this is also available in the header.
 * @apiError {String[]} error An array containing a descriptions of each error.
 */

/**
 * @apiDefine ApiSuccessFields
 * @apiSuccess {Boolean} success Tells the application if the request was successful.
 * @apiSuccess {Integer} status_code The HTTP status code of the request, this is also available in the header.
 * @apiSuccess {Object_Null} pagination A key to reference for paginated results, this may be null if only a single object has been returned.
 * @apiSuccess {Object[]_Object} result An array of objects or a single object.
 */

/**
 * @apiDefine AuthorizationHeader
 * @apiHeader {String} X-Authorization The application's unique access-key.
 *
 * @apiErrorExample {json} Error: Missing Header Option
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "error": [
 *              "X-Authorization: Header Option Not Found."
 *          ]
 *      }
 * @apiErrorExample {json} Error: Not Privileged
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": [
 *              "X-Authorization: Insufficient privileges."
 *          ]
 *      }
 *
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