<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/16
 * Time: 11:34 AM
 */

/**
 * @api {post} /countries/ POST: Create/Update Country
 * @apiVersion 1.1.1
 * @apiGroup Countries
 * @apiDescription This method creates a new country, or updates a country with the specified `code`.
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
 *      --data "name=United States of America" \
 *      --data "code=USA" \
 *      --data "abbreviation=US" \
 *      --url https://databridge.sage.edu/api/v1/countries/
 *
 * @apiUse CountryParameters
 */

/**
 * @api {delete} /countries/:id DELETE: Destroy Country
 * @apiVersion 1.1.1
 * @apiGroup Countries
 * @apiDescription This method deletes a Country object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The country's unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/countries/4
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /countries/code/:code DELETE: Destroy by Code
 * @apiVersion 1.1.1
 * @apiGroup Countries
 * @apiDescription This method deletes a Country object, the objects unique `code` is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} code The country's unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/countries/code/USA
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /countries/ GET: Request Countries
 * @apiVersion 1.1.1
 * @apiGroup Countries
 * @apiDescription This method returns pages of Country objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse PaginationParams
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/countries/
 *
 * @apiUse PaginatedSuccess
 * @apiUse CountrySuccess
 * @apiUse GetCountriesSuccessResultExample
 */

/**
 * @api {get} /countries/:id GET: Request Country
 * @apiVersion 1.1.1
 * @apiGroup Countries
 * @apiDescription This method returns a Country object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The country's unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/countries/2
 *
 * @apiUse CountrySuccess
 * @apiUse GetCountrySuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /countries/code/:code GET: Request by Code
 * @apiVersion 1.1.1
 * @apiGroup Countries
 * @apiDescription This method returns a Country object, the objects unique `code` is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} code The country's unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/countries/code/AFG
 *
 * @apiUse CountrySuccess
 * @apiUse GetCountrySuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */