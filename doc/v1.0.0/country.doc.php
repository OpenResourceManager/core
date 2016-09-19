<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/16
 * Time: 11:34 AM
 */

/**
 * @api {post} /countries/ POST: Create/Update Country
 * @apiVersion 1.0.0
 * @apiGroup Countries
 * @apiDescription This method creates a new country, or updates a country with the specified `code`.
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
 *      uud -o countries -m post -d "name=United States of America&code=USA&abbreviation=US"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "name=United States of America" \
 *      --data "code=USA" \
 *      --data "abbreviation=US" \
 *      --url https://databridge.sage.edu/api/v1/countries/
 *
 * @apiUse CountryParameters1.0.0
 */

/**
 * @api {delete} /countries/:id DELETE: Destroy Country
 * @apiVersion 1.0.0
 * @apiGroup Countries
 * @apiDescription This method deletes a Country object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The country's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o countries -m delete -p 4
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/countries/4
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /countries/code/:code DELETE: Destroy by Code
 * @apiVersion 1.0.0
 * @apiGroup Countries
 * @apiDescription This method deletes a Country object, the objects unique `code` is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} code The country's unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o countries -m delete -p code/USA
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/countries/code/USA
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /countries/ GET: Request Countries
 * @apiVersion 1.0.0
 * @apiGroup Countries
 * @apiDescription This method returns pages of Country objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse PaginationParams
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o countries
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/countries/
 *
 * @apiUse PaginatedSuccess
 * @apiUse CountrySuccess1.0.0
 * @apiUse GetCountriesSuccessResultExample1.0.0
 */

/**
 * @api {get} /countries/:id GET: Request Country
 * @apiVersion 1.0.0
 * @apiGroup Countries
 * @apiDescription This method returns a Country object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The country's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o countries -p 2
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/countries/2
 *
 * @apiUse CountrySuccess1.0.0
 * @apiUse GetCountrySuccessResultExample1.0.0
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /countries/code/:code GET: Request by Code
 * @apiVersion 1.0.0
 * @apiGroup Countries
 * @apiDescription This method returns a Country object, the objects unique `code` is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} code The country's unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o countries -p code/AFG
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/countries/code/AFG
 *
 * @apiUse CountrySuccess1.0.0
 * @apiUse GetCountrySuccessResultExample1.0.0
 *
 * @apiUse ModelNotFoundError
 */