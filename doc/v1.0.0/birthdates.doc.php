<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 2:01 PM
 */

/**
 * @api {post} /birthdates POST: Create/Update BirthDate
 * @apiVersion 1.0.0
 * @apiGroup BirthDates
 * @apiDescription This method creates a new password, or updates an password object with the specified user database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o birthdates -m post -d "user_id=151&birth_date=1992-01-05"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_id=151" \
 *      --data "birth_date=1992-01-05" \
 *      --url https://databridge.sage.edu/api/v1/birthdates/
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiUse BirthDateParameters1.0.0
 */

/**
 * @api {post} /birthdates/username POST: Create/Update BirthDate by Username
 * @apiVersion 1.0.0
 * @apiGroup BirthDates
 * @apiDescription This method creates a new password, or updates an password object with the specified username.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o birthdates -m post -p username -d "username=skywal&birth_date=1992-01-05"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "username=skywal" \
 *      --data "birth_date=1992-01-05" \
 *      --url https://databridge.sage.edu/api/v1/birthdates/username
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiParam (BirthDate Parameters) {String} username The user's unique username string.
 * @apiParam (BirthDate Parameters) {Date} birth_date The user's birth date. In strtotime format: (https://secure.php.net/manual/en/function.strtotime.php).
 */

/**
 * @api {post} /birthdates/identifier POST: Create/Update BirthDate by User Identifier
 * @apiVersion 1.0.0
 * @apiGroup BirthDates
 * @apiDescription This method creates a new password, or updates an password object with the specified user identifier.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o birthdates -m post -p identifier -d "identifier=04986732&birth_date=1992-01-05"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "identifier=04986732" \
 *      --data "birth_date=1992-01-05" \
 *      --url https://databridge.sage.edu/api/v1/birthdates/identifier
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiParam (BirthDate Parameters) {String} identifier The user's unique identifier string.
 * @apiParam (BirthDate Parameters) {Date} birth_date The user's birth date. In strtotime format: (https://secure.php.net/manual/en/function.strtotime.php).
 */

/**
 * @api {get} /birthdates GET: Request BirthDates
 * @apiVersion 1.0.0
 * @apiGroup BirthDates
 * @apiDescription This method returns pages of BirthDate objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse PaginationParams
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o birthdates
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/birthdates/
 *
 * @apiUse PaginatedSuccess
 * @apiUse BirthDateSuccess1.0.0
 * @apiUse GetBirthDatesSuccessResultExample1.0.0
 */

/**
 * @api {get} /birthdates/:id GET: Request BirthDate
 * @apiVersion 1.0.0
 * @apiGroup BirthDates
 * @apiDescription This method returns a BirthDate object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The password's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o birthdates -p 501
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/birthdates/501
 *
 * @apiUse BirthDateSuccess1.0.0
 * @apiUse GetBirthDateSuccessResultExample1.0.0
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /birthdates/:id DELETE: Destroy BirthDate
 * @apiVersion 1.0.0
 * @apiGroup BirthDates
 * @apiDescription This method deletes a BirthDate object, the database ID value is supplied to the API.
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
 *      uud -o birthdates -m delete -p 501
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/birthdates/501
 *
 * @apiUse ModelNotFoundError
 */


/**
 * @api {delete} /birthdates/user DELETE: Destroy by User
 * @apiVersion 1.0.0
 * @apiGroup BirthDates
 * @apiDescription This method deletes a BirthDate object, the database ID value of the user is supplied to the API.
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
 *      uud -o birthdates -m delete -p user -d "user=151"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "user=151" \
 *      --url https://databridge.sage.edu/api/v1/birthdates/user
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /birthdates/identifier DELETE: Destroy by User Identifier
 * @apiVersion 1.0.0
 * @apiGroup BirthDates
 * @apiDescription This method deletes a BirthDate object, a user's unique identifier string is supplied.
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
 *      uud -o birthdates -m delete -p identifier -d "identifier=04986732"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "identifier=04986732" \
 *      --url https://databridge.sage.edu/api/v1/birthdates/identifier
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /birthdates/username DELETE: Destroy by Username
 * @apiVersion 1.0.0
 * @apiGroup BirthDates
 * @apiDescription This method deletes a BirthDate object, a user's unique username string is supplied.
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
 *      uud -o birthdates -m delete -p username -d "username=skywal"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "username=skywal" \
 *      --url https://databridge.sage.edu/api/v1/birthdates/username
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /birthdates/user/:id GET: By User ID
 * @apiVersion 1.0.0
 * @apiGroup BirthDates
 * @apiDescription This method returns BirthDate objects associated with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o birthdates -p user/153
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/birthdates/user/153
 *
 * @apiUse BirthDateSuccess1.0.0
 * @apiUse GetBirthDateSuccessResultExample1.0.0
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /birthdates/username/:username GET: By Username
 * @apiVersion 1.0.0
 * @apiGroup BirthDates
 * @apiDescription This method returns BirthDate objects associated with the Username that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o birthdates -p username/skywal
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/birthdates/username/skywal
 *
 * @apiUse BirthDateSuccess1.0.0
 * @apiUse GetBirthDateSuccessResultExample1.0.0
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /birthdates/identifier/:identifier GET: By User Identifier
 * @apiVersion 1.0.0
 * @apiGroup BirthDates
 * @apiDescription This method returns BirthDate objects associated with the Identifier that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} identifier The user's unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o birthdates -p identifier/979659
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/birthdates/identifier/979659
 *
 * @apiUse BirthDateSuccess1.0.0
 * @apiUse GetBirthDateSuccessResultExample1.0.0
 *
 * @apiUse ModelNotFoundError
 */