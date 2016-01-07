<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/6/16
 * Time: 10:11 PM
 */

/**
 * @api {post} /buildings/ POST: Create/Update Building
 * @apiVersion 1.1.1
 * @apiGroup Buildings
 * @apiDescription This method creates a new building, or updates a building with the specified `code`.
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
 *      --data "name=CAR469" \
 *      --data "code=Carter Turnpike Court" \
 *      --url https://databridge.sage.edu/api/v1/buildings/
 *
 * @apiUse BuildingParameters
 */

/**
 * @api {get} /buildings/campus/:id GET: By Campus ID
 * @apiVersion 1.1.1
 * @apiGroup Buildings
 * @apiDescription This method returns a Building object, a campus `id` is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The campuses' unique database ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/buildings/campus/2
 *
 * @apiUse PaginatedSuccess
 * @apiUse BuildingSuccess
 * @apiUse GetBuildingsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /buildings/campus/code/:code GET: By Campus Code
 * @apiVersion 1.1.1
 * @apiGroup Buildings
 * @apiDescription This method returns a Building object, a campus unique `code` is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} code The campuses' unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/buildings/campus/code/TRY
 *
 * @apiUse PaginatedSuccess
 * @apiUse BuildingSuccess
 * @apiUse GetBuildingsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /buildings/:id DELETE: Destroy Building
 * @apiVersion 1.1.1
 * @apiGroup Buildings
 * @apiDescription This method deletes a Building object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The building's unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/buildings/14
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /buildings/code/:code DELETE: Destroy by Code
 * @apiVersion 1.1.1
 * @apiGroup Buildings
 * @apiDescription This method deletes a Building object, the objects unique `code` is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} code The building's unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/buildings/code/WES514
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /buildings/ GET: Request Buildings
 * @apiVersion 1.1.1
 * @apiGroup Buildings
 * @apiDescription This method returns pages of Building objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse PaginationParams
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/buildings/
 *
 * @apiUse PaginatedSuccess
 * @apiUse BuildingSuccess
 * @apiUse GetBuildingsSuccessResultExample
 */

/**
 * @api {get} /buildings/:id GET: Request Building
 * @apiVersion 1.1.1
 * @apiGroup Buildings
 * @apiDescription This method returns a Building object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The building's unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/buildings/14
 *
 * @apiUse BuildingSuccess
 * @apiUse GetBuildingSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /buildings/code/:code GET: Request by Code
 * @apiVersion 1.1.1
 * @apiGroup Buildings
 * @apiDescription This method returns a Building object, the objects unique `code` is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} code The building's unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/buildings/code/WES514
 *
 * @apiUse BuildingSuccess
 * @apiUse GetBuildingSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */