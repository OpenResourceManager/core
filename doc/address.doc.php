<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/16
 * Time: 11:45 AM
 */

/**
 * @api {post} /addresses/ POST: Create/Update Address
 * @apiVersion 1.1.1
 * @apiGroup Addresses
 * @apiDescription This method creates a new address, or updates a address with the specified `code`.
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
 *      --data "name=Troy" \
 *      --data "code=TRY" \
 *      --url https://databridge.sage.edu/api/v1/addresses/
 *
 * @apiUse AddressParameters
 */

/**
 * @api {delete} /addresses/:id DELETE: Destroy Address
 * @apiVersion 1.1.1
 * @apiGroup Addresses
 * @apiDescription This method deletes a Address object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The addresses' unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/addresses/4
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /addresses/ GET: Request Addresses
 * @apiVersion 1.1.1
 * @apiGroup Addresses
 * @apiDescription This method returns pages of Address objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse PaginationParams
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/addresses/
 *
 * @apiUse PaginatedSuccess
 * @apiUse AddressSuccess
 * @apiUse GetAddressesSuccessResultExample
 */

/**
 * @api {get} /addresses/:id GET: Request Address
 * @apiVersion 1.1.1
 * @apiGroup Addresses
 * @apiDescription This method returns a Address object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The addresses' unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/addresses/2
 *
 * @apiUse AddressSuccess
 * @apiUse GetAddressSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /addresses/user/:id GET: By user id
 * @apiVersion 1.1.1
 * @apiGroup Addresses
 * @apiDescription This method returns a Address objects, with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/addresses/user/3
 *
 * @apiUse AddressSuccess
 * @apiUse GetAddressesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /addresses/username/:username GET: By Username
 * @apiVersion 1.1.1
 * @apiGroup Addresses
 * @apiDescription This method returns a Address objects, with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} id The username of the user.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/addresses/username/skywal
 *
 * @apiUse AddressSuccess
 * @apiUse GetAddressesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /addresses/user_id/:user_id GET: By User Identifier
 * @apiVersion 1.1.1
 * @apiGroup Addresses
 * @apiDescription This method returns a Address objects, with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} user_id The user's unique identifier.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/addresses/user_id/9748523
 *
 * @apiUse AddressSuccess
 * @apiUse GetAddressesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */