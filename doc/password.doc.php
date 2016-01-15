<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 2:01 PM
 */

/**
 * @api {post} /passwords/ POST: Create/Update Password
 * @apiVersion 1.1.1
 * @apiGroup Passwords
 * @apiDescription This method creates a new password, or updates an password object with the specified password address.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_id=151" \
 *      --data "password=qwertyuiop1234567890" \
 *      --url https://databridge.sage.edu/api/v1/passwords/
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiUse PasswordParameters
 */

/**
 * @api {get} /passwords/ GET: Request Passwords
 * @apiVersion 1.1.1
 * @apiGroup Passwords
 * @apiDescription This method returns pages of Password objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse PaginationParams
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/passwords/
 *
 * @apiUse PaginatedSuccess
 * @apiUse PasswordSuccess
 * @apiUse GetPasswordsSuccessResultExample
 */

/**
 * @api {get} /passwords/:id GET: Request Password
 * @apiVersion 1.1.1
 * @apiGroup Passwords
 * @apiDescription This method returns a Password object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The password's unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/passwords/501
 *
 * @apiUse PasswordSuccess
 * @apiUse GetPasswordSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /passwords/:id DELETE: Destroy Password
 * @apiVersion 1.1.1
 * @apiGroup Passwords
 * @apiDescription This method deletes an Password object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The password's unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/passwords/501
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /passwords/user/:id GET: By User ID
 * @apiVersion 1.1.1
 * @apiGroup Passwords
 * @apiDescription This method returns Password objects associated with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/passwords/user/153
 *
 * @apiUse PasswordSuccess
 * @apiUse GetPasswordSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /passwords/user/username/:username GET: By Username
 * @apiVersion 1.1.1
 * @apiGroup Passwords
 * @apiDescription This method returns Password objects associated with the Username that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/passwords/user/username/skywal
 *
 * @apiUse PasswordSuccess
 * @apiUse GetPasswordSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /passwords/user/user_id/:user_identifier GET: By User Identifier
 * @apiVersion 1.1.1
 * @apiGroup Passwords
 * @apiDescription This method returns Password objects associated with the Identifier that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} user_identifier The user's unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/passwords/user/user_id/979659
 *
 * @apiUse PasswordSuccess
 * @apiUse GetPasswordSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */