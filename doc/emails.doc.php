<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/4/16
 * Time: 10:25 AM
 */

/**
 * @api {post} /emails/ POST: Create/Update Email
 * @apiVersion 1.1.1
 * @apiGroup Emails
 * @apiDescription This method creates a new email, or updates an email object with the specified email address.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o emails -m post -d "user_id=151&email=skywalker@yahoo.com&verified=0&verification_token=fhu9e9fds3"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_id=151" \
 *      --data "email=skywalker@yahoo.com" \
 *      --data "verified=0" \
 *      --data "verification_token=fhu9e9fds3" \
 *      --url https://databridge.sage.edu/api/v1/emails/
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiUse EmailParameters
 */

/**
 * @api {post} /emails/username POST: Create/Update Email by Username
 * @apiVersion 1.1.1
 * @apiGroup Emails
 * @apiDescription This method creates a new email, or updates an email object with the specified username.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o emails -m post -p username -d "username=skywal&email=skywalker@yahoo.com&verified=0&verification_token=fhu9e9fds3"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "username=skywal" \
 *      --data "email=skywalker@yahoo.com" \
 *      --data "verified=0" \
 *      --data "verification_token=fhu9e9fds3" \
 *      --url https://databridge.sage.edu/api/v1/emails/username
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiParam (Email Parameters) {String} username The user's unique username.
 * @apiParam (Email Parameters) {String} email The email address string.
 */

/**
 * @api {post} /emails/identifier POST: Create/Update Email by User Identifier
 * @apiVersion 1.1.1
 * @apiGroup Emails
 * @apiDescription This method creates a new email, or updates an email object with the specified identifier.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o emails -m post -p identifier -d "identifier=04986732&email=skywalker@yahoo.com&verified=0&verification_token=fhu9e9fds3"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "identifier=04986732" \
 *      --data "email=skywalker@yahoo.com" \
 *      --data "verified=0" \
 *      --data "verification_token=fhu9e9fds3" \
 *      --url https://databridge.sage.edu/api/v1/emails/identifier
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiParam (Email Parameters) {String} identifier The user's unique identifier string.
 * @apiParam (Email Parameters) {String} email The email address string.
 */


/**
 * @api {get} /emails/ GET: Request Emails
 * @apiVersion 1.1.1
 * @apiGroup Emails
 * @apiDescription This method returns pages of Email objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse PaginationParams
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o emails
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/emails/
 *
 * @apiUse PaginatedSuccess
 * @apiUse EmailSuccess
 * @apiUse GetEmailsSuccessResultExample
 */

/**
 * @api {get} /emails/:id GET: Request Email
 * @apiVersion 1.1.1
 * @apiGroup Emails
 * @apiDescription This method returns a Email object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The email's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o emails -p 501
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/emails/501
 *
 * @apiUse EmailSuccess
 * @apiUse GetEmailSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /emails/:id DELETE: Destroy Email
 * @apiVersion 1.1.1
 * @apiGroup Emails
 * @apiDescription This method deletes an Email object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The email's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o emails -m delete -p 501
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/emails/501
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /emails/address DELETE: Destroy Email by Email Address
 * @apiVersion 1.1.1
 * @apiGroup Emails
 * @apiDescription This method deletes an Email object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} email The email address.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o emails -p address -m delete -p "email=skywalker@yahoo.com"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "email=skywalker@yahoo.com" \
 *      --url https://databridge.sage.edu/api/v1/emails/address
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /emails/user/:id GET: By User ID
 * @apiVersion 1.1.1
 * @apiGroup Emails
 * @apiDescription This method returns Email objects associated with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o emails -p user/153
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/emails/user/153
 *
 * @apiUse EmailSuccess
 * @apiUse GetUsersEmailsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /emails/username/:username GET: By Username
 * @apiVersion 1.1.1
 * @apiGroup Emails
 * @apiDescription This method returns Email objects associated with the Username that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o emails -p username/skywal
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/emails/username/skywal
 *
 * @apiUse EmailSuccess
 * @apiUse GetUsersEmailsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /emails/identifier/:identifier GET: By User Identifier
 * @apiVersion 1.1.1
 * @apiGroup Emails
 * @apiDescription This method returns Email objects associated with the Identifier that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} identifier The user's unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o emails -p identifier/979659
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/emails/identifier/979659
 *
 * @apiUse EmailSuccess
 * @apiUse GetUsersEmailsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */