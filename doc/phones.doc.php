<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/5/16
 * Time: 12:44 PM
 */

/**
 * @api {post} /phones/ POST: Create/Update Phone
 * @apiVersion 1.1.1
 * @apiGroup Phones
 * @apiDescription This method creates a new phone, or updates a phone with the specified `number`.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_id=151" \
 *      --data "number=15188573007" \
 *      --data "is_cell=true" \
 *      --data "carrier=Sprint" \
 *      --url https://databridge.sage.edu/api/v1/phones/
 *
 * @apiUse PhoneParameters
 */

/**
 * @api {get} /phones/user/:id/phone GET: By User ID
 * @apiVersion 1.1.1
 * @apiGroup Phones
 * @apiDescription This method returns Phone objects associated with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/phones/user/153
 *
 * @apiUse PhoneSuccess
 * @apiUse GetUsersPhonesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /phones/user/username/:username/phone GET: By Username
 * @apiVersion 1.1.1
 * @apiGroup Phones
 * @apiDescription This method returns Phone objects associated with the Username that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/phones/user/username/skywal
 *
 * @apiUse PhoneSuccess
 * @apiUse GetUsersPhonesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /phones/user/user_id/:user_identifier GET: By User Identifier
 * @apiVersion 1.1.1
 * @apiGroup Phones
 * @apiDescription This method returns Phone objects associated with the Identifier that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} user_identifier The user's unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/phones/user/user_id/979659
 *
 * @apiUse PhoneSuccess
 * @apiUse GetUsersPhonesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */