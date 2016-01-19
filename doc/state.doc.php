<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/16
 * Time: 11:40 AM
 */

/**
 * @api {post} /states POST: Create/Update State
 * @apiVersion 1.1.1
 * @apiGroup States
 * @apiDescription This method creates a new state, or updates a state with the specified `code`.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o states -m post -d "name=New York&code=NY&country_id=226"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "name=New York" \
 *      --data "code=NY" \
 *      --data "country_id=226" \
 *      --url https://databridge.sage.edu/api/v1/states
 *
 * @apiUse StateParameters
 */

/**
 * @api {delete} /states/:id DELETE: Destroy State
 * @apiVersion 1.1.1
 * @apiGroup States
 * @apiDescription This method deletes a State object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The state's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o states -m delete -p 4
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/states/4
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /states/code/:code DELETE: Destroy by Code
 * @apiVersion 1.1.1
 * @apiGroup States
 * @apiDescription This method deletes a State object, the objects unique `code` is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} code The state's unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o states -m delete -p code/NY
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/states/code/NY
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /states GET: Request States
 * @apiVersion 1.1.1
 * @apiGroup States
 * @apiDescription This method returns pages of State objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse PaginationParams
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o states
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/states
 *
 * @apiUse PaginatedSuccess
 * @apiUse StateSuccess
 * @apiUse GetStatesSuccessResultExample
 */

/**
 * @api {get} /states/:id GET: Request State
 * @apiVersion 1.1.1
 * @apiGroup States
 * @apiDescription This method returns a State object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The state's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o states -p 2
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/states/2
 *
 * @apiUse StateSuccess
 * @apiUse GetStateSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /states/code/:code GET: Request by Code
 * @apiVersion 1.1.1
 * @apiGroup States
 * @apiDescription This method returns a State object, the objects unique `code` is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} code The state's unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o states -p code/NY
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/states/code/NY
 *
 * @apiUse StateSuccess
 * @apiUse GetStateSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */