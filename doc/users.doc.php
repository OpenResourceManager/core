<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/4/16
 * Time: 10:25 AM
 */

/**
 * @api {post} /users POST: Create/Update User
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method creates a new user, or updates a user with the specified `user_identifier`.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o users -p post -d "user_identifier=0979659&name_prefix=MR.&name_first=Luke&name_last=Skywalker&username=skywal"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_identifier=0979659" \
 *      --data "name_prefix=MR." \
 *      --data "name_first=Luke" \
 *      --data "name_last=Skywalker" \
 *      --data "username=skywal" \
 *      --url https://databridge.sage.edu/api/v1/users
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
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o users -m delete -p 151
 *
 * @apiExample {bash} Curl
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
 * @apiUse InternalServerErrors
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o users -m delete -p username/skywal
 *
 * @apiExample {bash} Curl
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
 * @apiUse InternalServerErrors
 * @apiParam {String} user_identifier The user's unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o users -m delete -p user_id/0979659
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/users/user_id/0979659
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users GET: Request Users
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns pages of User objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse PaginationParams
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o users
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users
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
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o users -p 1
 *
 * @apiExample {bash} Curl
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
 * @apiUse InternalServerErrors
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o users -p username/skywal
 *
 * @apiExample {bash} Curl
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
 * @apiUse InternalServerErrors
 * @apiParam {String} user_identifier The user's unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o users -p user_id/62223406
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/user_id/6223406
 *
 * @apiUse UserSuccess
 * @apiUse GetUserSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users/room/:id GET: By Room ID
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns User objects, associated with the room ID.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The room's unique database id.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o users -p room/31
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/room/31
 *
 * @apiUse UserSuccess
 * @apiUse GetUsersSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users/role/:id GET: By Role ID
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns User objects, associated with the role ID.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The role's unique database id.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o users -p role/2
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/role/2
 *
 * @apiUse UserSuccess
 * @apiUse GetUsersSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users/role/code/:code GET: By Role Code
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns User objects, associated with the role code.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} code The role's unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o users -p role/code/STUDENT
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/role/code/STUDENT
 *
 * @apiUse UserSuccess
 * @apiUse GetUsersSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users/course/:id GET: By Course ID
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns User objects, associated with the course ID.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The courses' unique database id.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o users -p course/13
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/course/13
 *
 * @apiUse UserSuccess
 * @apiUse GetUsersSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /users/course/code/:code GET: By Course Code
 * @apiVersion 1.1.1
 * @apiGroup Users
 * @apiDescription This method returns User objects, associated with the course code.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} code The course' unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o users -p course/code/Ab.427
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/users/course/code/Ab.427
 *
 * @apiUse UserSuccess
 * @apiUse GetUsersSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */
