<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/6/16
 * Time: 9:50 PM
 */

/**
 * @api {post} /campuses/ POST: Create/Update Campus
 * @apiVersion 1.0.0
 * @apiGroup Campuses
 * @apiDescription This method creates a new campus, or updates a campus with the specified `code`.
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
 *      uud -o campuses -m post -d "name=Troy&code=TRY"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "name=Troy" \
 *      --data "code=TRY" \
 *      --url https://databridge.sage.edu/api/v1/campuses/
 *
 * @apiUse CampusParameters1.0.0
 */

/**
 * @api {delete} /campuses/:id DELETE: Destroy Campus
 * @apiVersion 1.0.0
 * @apiGroup Campuses
 * @apiDescription This method deletes a Campus object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The campuses' unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o campuses -p 4
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/campuses/4
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /campuses/code/:code DELETE: Destroy by Code
 * @apiVersion 1.0.0
 * @apiGroup Campuses
 * @apiDescription This method deletes a Campus object, the objects unique `code` is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} code The campuses' unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o campuses -m delete -p code/TRY
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/campuses/code/TRY
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /campuses/ GET: Request Campuses
 * @apiVersion 1.0.0
 * @apiGroup Campuses
 * @apiDescription This method returns pages of Campus objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse PaginationParams
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o campuses
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/campuses/
 *
 * @apiUse PaginatedSuccess
 * @apiUse CampusSuccess1.0.0
 * @apiUse GetCampusesSuccessResultExample1.0.0
 */

/**
 * @api {get} /campuses/:id GET: Request Campus
 * @apiVersion 1.0.0
 * @apiGroup Campuses
 * @apiDescription This method returns a Campus object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The campuses' unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o campuses -p 2
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/campuses/2
 *
 * @apiUse CampusSuccess1.0.0
 * @apiUse GetCampusSuccessResultExample1.0.0
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /campuses/code/:code GET: Request by Code
 * @apiVersion 1.0.0
 * @apiGroup Campuses
 * @apiDescription This method returns a Campus object, the objects unique `code` is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} code The campuses' unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o campuses -p code/TRY
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/campuses/code/TRY
 *
 * @apiUse CampusSuccess1.0.0
 * @apiUse GetCampusSuccessResultExample1.0.0
 *
 * @apiUse ModelNotFoundError
 */