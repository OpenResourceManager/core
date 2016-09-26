<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 2:01 PM
 */

/**
 * @api {post} /passwords POST: Create/Update Password
 * @apiVersion 1.0.0
 * @apiGroup Passwords
 * @apiDescription This method creates a new password, or updates an password object with the specified user database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o passwords -m post -d "user_id=151&password=qwertyuiop1234567890"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_id=151" \
 *      --data "password=qwertyuiop1234567890" \
 *      --url https://api.example.tld/api/v1/passwords/
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiUse PasswordParameters
 */

/**
 * @api {post} /passwords/username POST: Create/Update Password by Username
 * @apiVersion 1.0.0
 * @apiGroup Passwords
 * @apiDescription This method creates a new password, or updates an password object with the specified username.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o passwords -m post -p username -d "username=skywal&password=qwertyuiop1234567890"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "username=skywal" \
 *      --data "password=qwertyuiop1234567890" \
 *      --url https://api.example.tld/api/v1/passwords/username
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiParam (Password Parameters) {String} username The user's unique username string.
 * @apiParam (Password Parameters) {String} password The unencrypted password string.
 */

/**
 * @api {post} /passwords/identifier POST: Create/Update Password by User Identifier
 * @apiVersion 1.0.0
 * @apiGroup Passwords
 * @apiDescription This method creates a new password, or updates an password object with the specified user identifier.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o passwords -m post -p identifier -d "identifier=04986732&password=qwertyuiop1234567890"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "identifier=04986732" \
 *      --data "password=qwertyuiop1234567890" \
 *      --url https://api.example.tld/api/v1/passwords/identifier
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiParam (Password Parameters) {String} identifier The user's unique identifier string.
 * @apiParam (Password Parameters) {String} password The unencrypted password string.
 */

/**
 * @api {get} /passwords GET: Request Passwords
 * @apiVersion 1.0.0
 * @apiGroup Passwords
 * @apiDescription This method returns pages of Password objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse PaginationParams
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o passwords
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/passwords/
 *
 * @apiUse PaginatedSuccess
 * @apiUse PasswordSuccess
 * @apiUse GetPasswordsSuccessResultExample
 */

/**
 * @api {get} /passwords/:id GET: Request Password
 * @apiVersion 1.0.0
 * @apiGroup Passwords
 * @apiDescription This method returns a Password object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The password's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o passwords -p 501
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/passwords/501
 *
 * @apiUse PasswordSuccess
 * @apiUse GetPasswordSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /passwords/:id DELETE: Destroy Password
 * @apiVersion 1.0.0
 * @apiGroup Passwords
 * @apiDescription This method deletes a Password object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The password's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o passwords -m delete -p 501
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://api.example.tld/api/v1/passwords/501
 *
 * @apiUse ModelNotFoundError
 */


/**
 * @api {delete} /passwords/user DELETE: Destroy by User
 * @apiVersion 1.0.0
 * @apiGroup Passwords
 * @apiDescription This method deletes a Password object, the database ID value of the user is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} user The user's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o passwords -m delete -p user -d "user=151"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "user=151" \
 *      --url https://api.example.tld/api/v1/passwords/user
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /passwords/identifier DELETE: Destroy by User Identifier
 * @apiVersion 1.0.0
 * @apiGroup Passwords
 * @apiDescription This method deletes a Password object, a user's unique identifier string is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} identifier The user's unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o passwords -m delete -p identifier -d "identifier=04986732"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "identifier=04986732" \
 *      --url https://api.example.tld/api/v1/passwords/identifier
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /passwords/username DELETE: Destroy by Username
 * @apiVersion 1.0.0
 * @apiGroup Passwords
 * @apiDescription This method deletes a Password object, a user's unique username string is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} username The user's unique username string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o passwords -m delete -p username -d "username=skywal"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "username=skywal" \
 *      --url https://api.example.tld/api/v1/passwords/username
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /passwords/user/:id GET: By User ID
 * @apiVersion 1.0.0
 * @apiGroup Passwords
 * @apiDescription This method returns Password objects associated with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o passwords -p user/153
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/passwords/user/153
 *
 * @apiUse PasswordSuccess
 * @apiUse GetPasswordSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /passwords/username/:username GET: By Username
 * @apiVersion 1.0.0
 * @apiGroup Passwords
 * @apiDescription This method returns Password objects associated with the Username that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o passwords -p username/skywal
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/passwords/username/skywal
 *
 * @apiUse PasswordSuccess
 * @apiUse GetPasswordSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /passwords/identifier/:identifier GET: By User Identifier
 * @apiVersion 1.0.0
 * @apiGroup Passwords
 * @apiDescription This method returns Password objects associated with the Identifier that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} identifier The user's unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o passwords -p identifier/979659
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/passwords/identifier/979659
 *
 * @apiUse PasswordSuccess
 * @apiUse GetPasswordSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */