<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 2:01 PM
 */

/**
 * @api {post} /ssn POST: Create/Update Social Security Number
 * @apiVersion 1.0.0
 * @apiGroup Social Security Numbers
 * @apiDescription This method creates a new social security number, or updates an social security number object with the specified user database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o ssn -m post -d "user_id=151&ssn=qwertyuiop1234567890"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_id=151" \
 *      --data "ssn=qwertyuiop1234567890" \
 *      --url https://api.example.tld/api/v1/ssn/
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiUse SSNParameters
 */

/**
 * @api {post} /ssn/username POST: Create/Update Social Security Number by Username
 * @apiVersion 1.0.0
 * @apiGroup Social Security Numbers
 * @apiDescription This method creates a new social security number, or updates an social security number object with the specified username.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o ssn -m post -p username -d "username=skywal&ssn=qwertyuiop1234567890"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "username=skywal" \
 *      --data "ssn=qwertyuiop1234567890" \
 *      --url https://api.example.tld/api/v1/ssn/username
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiParam (SSN Parameters) {String} username The user's unique username string.
 * @apiParam (SSN Parameters) {String} ssn The unencrypted 4 digit social security number string.
 */

/**
 * @api {post} /ssn/identifier POST: Create/Update Social Security Number by User Identifier
 * @apiVersion 1.0.0
 * @apiGroup Social Security Numbers
 * @apiDescription This method creates a new social security number, or updates an social security number object with the specified user identifier.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o ssn -m post -p identifier -d "identifier=04986732&ssn=qwertyuiop1234567890"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "identifier=04986732" \
 *      --data "ssn=qwertyuiop1234567890" \
 *      --url https://api.example.tld/api/v1/ssn/identifier
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiParam (SSN Parameters) {String} identifier The user's unique identifier string.
 * @apiParam (SSN Parameters) {String} ssn The unencrypted 4 digit social security number string.
 */

/**
 * @api {get} /ssn GET: Request Social Security Numbers
 * @apiVersion 1.0.0
 * @apiGroup Social Security Numbers
 * @apiDescription This method returns pages of SocialSecurityNumber objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse PaginationParams
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o ssn
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/ssn/
 *
 * @apiUse PaginatedSuccess
 * @apiUse SSNSuccess
 * @apiUse GetSSNsSuccessResultExample
 */

/**
 * @api {get} /ssn/:id GET: Request Social Security Number
 * @apiVersion 1.0.0
 * @apiGroup Social Security Numbers
 * @apiDescription This method returns a SocialSecurityNumber object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The social security number's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o ssn -p 501
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/ssn/501
 *
 * @apiUse SSNSuccess
 * @apiUse GetSSNSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /ssn/:id DELETE: Destroy Social Security Number
 * @apiVersion 1.0.0
 * @apiGroup Social Security Numbers
 * @apiDescription This method deletes a SocialSecurityNumber object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The social security number's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o ssn -m delete -p 501
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://api.example.tld/api/v1/ssn/501
 *
 * @apiUse ModelNotFoundError
 */


/**
 * @api {delete} /ssn/user DELETE: Destroy by User
 * @apiVersion 1.0.0
 * @apiGroup Social Security Numbers
 * @apiDescription This method deletes a SocialSecurityNumber object, the database ID value of the user is supplied to the API.
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
 *      uud -o ssn -m delete -p user -d "user=151"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "user=151" \
 *      --url https://api.example.tld/api/v1/ssn/user
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /ssn/identifier DELETE: Destroy by User Identifier
 * @apiVersion 1.0.0
 * @apiGroup Social Security Numbers
 * @apiDescription This method deletes a SocialSecurityNumber object, a user's unique identifier string is supplied.
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
 *      uud -o ssn -m delete -p identifier -d "identifier=04986732"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "identifier=04986732" \
 *      --url https://api.example.tld/api/v1/ssn/identifier
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /ssn/username DELETE: Destroy by Username
 * @apiVersion 1.0.0
 * @apiGroup Social Security Numbers
 * @apiDescription This method deletes a SocialSecurityNumber object, a user's unique username string is supplied.
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
 *      uud -o ssn -m delete -p username -d "username=skywal"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "username=skywal" \
 *      --url https://api.example.tld/api/v1/ssn/username
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /ssn/user/:id GET: By User ID
 * @apiVersion 1.0.0
 * @apiGroup Social Security Numbers
 * @apiDescription This method returns SocialSecurityNumber objects associated with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o ssn -p user/153
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/ssn/user/153
 *
 * @apiUse SSNSuccess
 * @apiUse GetSSNSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /ssn/username/:username GET: By Username
 * @apiVersion 1.0.0
 * @apiGroup Social Security Numbers
 * @apiDescription This method returns SocialSecurityNumber objects associated with the Username that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o ssn -p username/skywal
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/ssn/username/skywal
 *
 * @apiUse SSNSuccess
 * @apiUse GetSSNSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /ssn/identifier/:identifier GET: By User Identifier
 * @apiVersion 1.0.0
 * @apiGroup Social Security Numbers
 * @apiDescription This method returns SocialSecurityNumber objects associated with the Identifier that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} identifier The user's unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o ssn -p identifier/979659
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://api.example.tld/api/v1/ssn/identifier/979659
 *
 * @apiUse SSNSuccess
 * @apiUse GetSSNSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */