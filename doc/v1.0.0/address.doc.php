<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/16
 * Time: 11:45 AM
 */

/**
 * @api {post} /addresses/ POST: Create Address
 * @apiVersion 1.0.0
 * @apiGroup Addresses
 * @apiDescription This method creates a new address.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o addresses -m post -d "user_id=142&addressee=Sir Luke Skywalker&organization=The Jedi Knight Academy&line_1=65 1st Street&line_2=Cowee Building&city=Troy&state=33&zip=12180&country_id=226&latitude=42.7274609&longitude=-73.6964327"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_id=142" \
 *      --data "addressee=Sir Luke Skywalker" \
 *      --data "organization=The Jedi Knight Academy" \
 *      --data "line_1=65 1st Street" \
 *      --data "line_2=Cowee Building" \
 *      --data "city=Troy" \
 *      --data "state=33" \
 *      --data "zip=12180" \
 *      --data "country_id=226" \
 *      --data "latitude=42.7274609" \
 *      --data "longitude=-73.6964327" \
 *      --url https://databridge.sage.edu/api/v1/addresses/
 *
 * @apiUse AddressParameters1.0.0
 */

/**
 * @api {delete} /addresses/:id DELETE: Destroy Address
 * @apiVersion 1.0.0
 * @apiGroup Addresses
 * @apiDescription This method deletes a Address object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The addresses' unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o addresses -m delete -p 4
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/addresses/4
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /addresses/ GET: Request Addresses
 * @apiVersion 1.0.0
 * @apiGroup Addresses
 * @apiDescription This method returns pages of Address objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse PaginationParams
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o addresses
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/addresses/
 *
 * @apiUse PaginatedSuccess
 * @apiUse AddressSuccess1.0.0
 * @apiUse GetAddressesSuccessResultExample1.0.0
 */

/**
 * @api {get} /addresses/:id GET: Request Address
 * @apiVersion 1.0.0
 * @apiGroup Addresses
 * @apiDescription This method returns a Address object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The addresses' unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o addresses -p 2
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/addresses/2
 *
 * @apiUse AddressSuccess1.0.0
 * @apiUse GetAddressSuccessResultExample1.0.0
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /addresses/user/:id GET: By user id
 * @apiVersion 1.0.0
 * @apiGroup Addresses
 * @apiDescription This method returns a Address objects, with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o addresses -p user/3
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/addresses/user/3
 *
 * @apiUse AddressSuccess1.0.0
 * @apiUse GetAddressesSuccessResultExample1.0.0
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /addresses/username/:username GET: By Username
 * @apiVersion 1.0.0
 * @apiGroup Addresses
 * @apiDescription This method returns a Address objects, with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} id The username of the user.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o addresses -p username/skywal
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/addresses/username/skywal
 *
 * @apiUse AddressSuccess1.0.0
 * @apiUse GetAddressesSuccessResultExample1.0.0
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /addresses/identifier/:identifier GET: By User Identifier
 * @apiVersion 1.0.0
 * @apiGroup Addresses
 * @apiDescription This method returns a Address objects, with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} identifier The user's unique identifier.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o addresses -p identifier/9748523
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/addresses/identifier/9748523
 *
 * @apiUse AddressSuccess1.0.0
 * @apiUse GetAddressesSuccessResultExample1.0.0
 *
 * @apiUse ModelNotFoundError
 */