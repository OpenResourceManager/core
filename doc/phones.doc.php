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
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_id=151" \
 *      --data "number=15188573007" \
 *      --data "is_cell=1" \
 *      --data "carrier=Sprint" \
 *      --url https://databridge.sage.edu/api/v1/phones/
 *
 * @apiUse PhoneParameters
 */

/**
 * @api {delete} /phones/:id DELETE: Destroy Phone
 * @apiVersion 1.1.1
 * @apiGroup Phones
 * @apiDescription This method deletes a Phone object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The phone's unique ID.
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/phones/4
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /phones/ GET: Request Phones
 * @apiVersion 1.1.1
 * @apiGroup Phones
 * @apiDescription This method returns pages of Phone objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse PaginationParams
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/phones/
 *
 * @apiUse PaginatedSuccess
 * @apiUse PhoneSuccess
 * @apiUse GetPhonesSuccessResultExample
 */

/**
 * @api {get} /phones/:id GET: Request Phone
 * @apiVersion 1.1.1
 * @apiGroup Phones
 * @apiDescription This method returns a Phone object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The phone's unique ID.
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/phones/12
 *
 * @apiUse PhoneSuccess
 * @apiUse GetPhoneSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /phones/user/:id GET: By User ID
 * @apiVersion 1.1.1
 * @apiGroup Phones
 * @apiDescription This method returns Phone objects associated with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/phones/user/153
 *
 * @apiUse PhoneSuccess
 * @apiUse GetUsersPhonesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /phones/user/username/:username GET: By Username
 * @apiVersion 1.1.1
 * @apiGroup Phones
 * @apiDescription This method returns Phone objects associated with the Username that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {bash} Curl
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
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/phones/user/user_id/979659
 *
 * @apiUse PhoneSuccess
 * @apiUse GetUsersPhonesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */