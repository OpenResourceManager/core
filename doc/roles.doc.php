<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/7/16
 * Time: 9:59 PM
 */

/**
 * @api {post} /roles/ POST: Create/Update Role
 * @apiVersion 1.1.1
 * @apiGroup Roles
 * @apiDescription This method creates a new role, or updates a role with the specified `number`.
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
 *      --data "code=EMP" \
 *      --data "name=Employee" \
 *      --url https://databridge.sage.edu/api/v1/roles/
 *
 * @apiUse RoleParameters
 */

/**
 * @api {delete} /roles/:id DELETE: Destroy Role
 * @apiVersion 1.1.1
 * @apiGroup Roles
 * @apiDescription This method deletes a Role object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The role's unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/roles/4
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /roles/code/:code DELETE: Destroy By Code
 * @apiVersion 1.1.1
 * @apiGroup Roles
 * @apiDescription This method deletes a Role object,  a role's unique code is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} code The role's unique code.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/roles/EMP
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /roles/ GET: Request Roles
 * @apiVersion 1.1.1
 * @apiGroup Roles
 * @apiDescription This method returns pages of Role objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse PaginationParams
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/roles/
 *
 * @apiUse PaginatedSuccess
 * @apiUse RoleSuccess
 * @apiUse GetRolesSuccessResultExample
 */

/**
 * @api {get} /roles/:id GET: Request Role
 * @apiVersion 1.1.1
 * @apiGroup Roles
 * @apiDescription This method returns a Role object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The role's unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/roles/3
 *
 * @apiUse RoleSuccess
 * @apiUse GetRoleSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /roles/code/:code GET: Role by Code
 * @apiVersion 1.1.1
 * @apiGroup Roles
 * @apiDescription This method returns a Role object, a role's unique code is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} code The role's unique code.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/roles/EMP
 *
 * @apiUse RoleSuccess
 * @apiUse GetRoleSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /roles/user/:id GET: By User ID
 * @apiVersion 1.1.1
 * @apiGroup Roles
 * @apiDescription This method returns Role objects associated with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/roles/user/153
 *
 * @apiUse RoleSuccess
 * @apiUse GetRolesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /roles/user/username/:username GET: By Username
 * @apiVersion 1.1.1
 * @apiGroup Roles
 * @apiDescription This method returns Role objects associated with the Username that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/roles/user/username/skywal
 *
 * @apiUse RoleSuccess
 * @apiUse GetRolesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /roles/user/user_id/:user_identifier GET: By User Identifier
 * @apiVersion 1.1.1
 * @apiGroup Roles
 * @apiDescription This method returns Role objects associated with the Identifier that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} user_identifier The user's unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/roles/user/user_id/979659
 *
 * @apiUse RoleSuccess
 * @apiUse GetRolesSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */