<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/4/16
 * Time: 10:25 AM
 */

/**
 * @api {post} /users/ POST: Create/Update User
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method creates a new user, or updates a user with the specified `user_identifier`.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_identifier=0979659" \
 *      --data "name_prefix=MR." \
 *      --data "name_first=Luke" \
 *      --data "name_last=Skywalker" \
 *      --data "username=skywal" \
 *      --url https://databridge.sage.edu/api/v1/users/
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiUse UserParameters
 */

/**
 * @api {delete} /users/:id DELETE: Destroy User
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method deletes a User object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/users/151
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /users/username/:username DELETE: Destroy via Username
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method deletes a User object, a username value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/users/username/skywal
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /users/user_id/:user_identifier DELETE: Destroy via Identifier
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method deletes a User object, a user_identifier is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} user_identifier The user's unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/users/user_id/0979659
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users/ GET: Request Users
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns pages of User objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse PaginationParams
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/
 *
 * @apiUse PaginatedSuccess
 * @apiUse UserSuccess
 * @apiUse GetUsersSuccessResultExample
 */

/**
 * @api {get} /users/:id GET: Request User
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns a User object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/1
 *
 * @apiUse UserSuccess
 * @apiUse GetUserSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users/username/:username GET: Request via Username
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns a User object, a username is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/username/skywal
 *
 * @apiUse UserSuccess
 * @apiUse GetUserSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users/user_id/:user_identifier GET: Request via Identifier
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns a User object, a user_identifier is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} user_identifier The user's unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/user_id/6223406
 *
 * @apiUse UserSuccess
 * @apiUse GetUserSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users/:id/email GET: Emails via ID
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns Email objects associated with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/153/email
 *
 * @apiUse EmailSuccess
 * @apiUse GetUsersEmailsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users/username/:username/email GET: Emails via Username
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns Email objects associated with the Username that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/username/skywal/email
 *
 * @apiUse EmailSuccess
 * @apiUse GetUsersEmailsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users/user_id/:user_identifier/email GET: Emails via Identifier
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns Email objects associated with the Identifier that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} user_identifier The user's unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/user_id/979659/email
 *
 * @apiUse EmailSuccess
 * @apiUse GetUsersEmailsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users/:id/phone GET: Phones via ID
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns Phone objects associated with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/153/phone
 *
 * @apiUse PhoneSuccess
 * @apiUse GetUsersPhonesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users/username/:username/phone GET: Phones via Username
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns Phone objects associated with the Username that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/username/skywal/phone
 *
 * @apiUse PhoneSuccess
 * @apiUse GetUsersPhonesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users/user_id/:user_identifier/phone GET: Phones via Identifier
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns Phone objects associated with the Identifier that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} user_identifier The user's unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/user_id/979659/phone
 *
 * @apiUse PhoneSuccess
 * @apiUse GetUsersPhonesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */
