<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/6/16
 * Time: 9:50 PM
 */

/**
 * @api {post} /campuses/ POST: Create/Update Campus
 * @apiVersion 1.1.1
 * @apiGroup Campuses
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
 *      --data "name=Troy" \
 *      --data "code=TRY" \
 *      --url https://databridge.sage.edu/api/v1/campuses/
 *
 * @apiUse CampusParameters
 */

/**
 * @api {delete} /campuses/:id DELETE: Destroy Campus
 * @apiVersion 1.1.1
 * @apiGroup Campuses
 * @apiDescription This method deletes a Campus object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The campuses' unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/campuses/4
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /campuses/code/:code DELETE: Destroy by Code
 * @apiVersion 1.1.1
 * @apiGroup Campuses
 * @apiDescription This method deletes a Campus object, the objects unique `code` is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} code The campuses' unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/campuses/code/TRY
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /campuses/ GET: Request Campuses
 * @apiVersion 1.1.1
 * @apiGroup Campuses
 * @apiDescription This method returns pages of Campus objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse PaginationParams
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/campuses/
 *
 * @apiUse PaginatedSuccess
 * @apiUse CampusSuccess
 * @apiUse GetCampusesSuccessResultExample
 */

/**
 * @api {get} /campuses/:id GET: Request Campus
 * @apiVersion 1.1.1
 * @apiGroup Campuses
 * @apiDescription This method returns a Campus object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The campuses' unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/campuses/2
 *
 * @apiUse CampusSuccess
 * @apiUse GetCampusSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /campuses/code/:code GET: Request by Code
 * @apiVersion 1.1.1
 * @apiGroup Campuses
 * @apiDescription This method returns a Campus object, the objects unique `code` is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} code The campuses' unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/campuses/code/TRY
 *
 * @apiUse CampusSuccess
 * @apiUse GetCampusSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */