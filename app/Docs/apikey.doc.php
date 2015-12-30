<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 12/30/15
 * Time: 12:07 PM
 */

/**
 * @apiDefine AuthorizationHeader
 *
 * @apiHeader {String} X-Authorization The application's unique access-key.
 *
 */

/**
 * @apiDefine AuthorizationErrors
 *
 * @apiErrorExample {json} Error: Missing Header Option
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "success": false,
 *          "error": "X-Authorization: Header Option Not Found."
 *      }
 * @apiErrorExample {json} Error: Not Privileged
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": "X-Authorization: Insufficient privileges."
 *      }
 *
 * @apiErrorExample {json} Error: Invalid API Key
 *      HTTP/1.1 403 Forbidden
 *      {
 *          "success": false,
 *          "error": "X-Authorization: API Key is not valid."
 *      }
 */