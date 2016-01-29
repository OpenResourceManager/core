<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/29/16
 * Time: 2:23 PM
 */


/**
 * @api {post} /mobilecarriers/ POST: Create/Update MobileCarrier
 * @apiVersion 1.1.1
 * @apiGroup MobileCarriers
 * @apiDescription This method creates a new mobile carrier, or updates a mobile carrier with the specified `code`.
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
 *      uud -o carriers -m post -d "name=T-Mobile&code=TMO"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "name=T-Mobile" \
 *      --data "code=TMO" \
 *      --url https://databridge.sage.edu/api/v1/mobilecarriers/
 *
 * @apiUse MobileCarrierParameters
 */

/**
 * @api {delete} /mobilecarriers/:id DELETE: Destroy MobileCarrier
 * @apiVersion 1.1.1
 * @apiGroup MobileCarriers
 * @apiDescription This method deletes a MobileCarrier object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The mobile carrier's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o carriers -p 4
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/mobilecarriers/4
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /mobilecarriers/code/:code DELETE: Destroy by Code
 * @apiVersion 1.1.1
 * @apiGroup MobileCarriers
 * @apiDescription This method deletes a MobileCarrier object, the objects unique `code` is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} code The mobile carrier's unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o carriers -m delete -p code/TMO
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/mobilecarriers/code/TMO
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /mobilecarriers/ GET: Request MobileCarrieres
 * @apiVersion 1.1.1
 * @apiGroup MobileCarriers
 * @apiDescription This method returns pages of MobileCarrier objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse PaginationParams
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o carriers
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/mobilecarriers/
 *
 * @apiUse PaginatedSuccess
 * @apiUse MobileCarrierSuccess
 * @apiUse GetMobileCarriersSuccessResultExample
 */

/**
 * @api {get} /mobilecarriers/:id GET: Request MobileCarrier
 * @apiVersion 1.1.1
 * @apiGroup MobileCarriers
 * @apiDescription This method returns a MobileCarrier object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The mobile carrier's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o carriers -p 2
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/mobilecarriers/2
 *
 * @apiUse MobileCarrierSuccess
 * @apiUse GetMobileCarrierSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /mobilecarriers/code/:code GET: Request by Code
 * @apiVersion 1.1.1
 * @apiGroup MobileCarriers
 * @apiDescription This method returns a MobileCarrier object, the objects unique `code` is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} code The mobile carrier's unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o carriers -p code/TMO
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/mobilecarriers/code/TMO
 *
 * @apiUse MobileCarrierSuccess
 * @apiUse GetMobileCarrierSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */