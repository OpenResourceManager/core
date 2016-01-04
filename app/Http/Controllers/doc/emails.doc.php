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
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_id=151" \
 *      --data "email=skywalker@yahoo.com" \
 *      --url https://databridge.sage.edu/api/v1/emails/
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiUse EmailParameters
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
 * @apiUse PaginationParams
 *
 * @apiExample {curl} Curl
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
 * @apiParam {Integer} id The email's unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/emails/1
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
 * @apiParam {Integer} id The email's unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/emails/151
 *
 * @apiUse ModelNotFoundError
 */


