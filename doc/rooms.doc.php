<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/7/16
 * Time: 12:19 PM
 */

/**
 * @api {post} /rooms/ POST: Create/Update Room
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method creates a new room, or updates an room object with the specified room address.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_id=151" \
 *      --data "building_id=11" \
 *      --data "floor_number=2" \
 *      --data "floor_name=The Second Floor" \
 *      --data "room_number=204" \
 *      --data "room_name=West Mohawk Room" \
 *      --url https://databridge.sage.edu/api/v1/rooms/
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiUse RoomParameters
 */

/**
 * @api {get} /rooms/ GET: Request Rooms
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method returns pages of Room objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse PaginationParams
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/rooms/
 *
 * @apiUse PaginatedSuccess
 * @apiUse RoomSuccess
 * @apiUse GetRoomsSuccessResultExample
 */

/**
 * @api {get} /rooms/:id GET: Request Room
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method returns a Room object, an id is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The room's unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/rooms/501
 *
 * @apiUse RoomSuccess
 * @apiUse GetRoomSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /rooms/:id DELETE: Destroy Room
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method deletes an Room object, the database ID value is supplied to the API.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The room's unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/rooms/501
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /rooms/user/:id GET: By User ID
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method returns Room objects associated with the user's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/rooms/user/153
 *
 * @apiUse RoomSuccess
 * @apiUse GetRoomsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /rooms/user/username/:username GET: By Username
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method returns Room objects associated with the Username that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/rooms/user/username/skywal
 *
 * @apiUse RoomSuccess
 * @apiUse GetRoomsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /rooms/user/user_id/:user_identifier GET: By User Identifier
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method returns Room objects associated with the Identifier that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} user_identifier The user's unique identifier string.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/rooms/user/user_id/979659
 *
 * @apiUse RoomSuccess
 * @apiUse GetRoomsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /rooms/campus/:id GET: By Campus ID
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method returns Room objects associated with the campuses' database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The campuses' unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/rooms/campus/3
 *
 * @apiUse RoomSuccess
 * @apiUse GetRoomsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /rooms/campus/code/:code GET: By Campus Code
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method returns Room objects associated with the campuses' unique code.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} code The campuses' unique code.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/rooms/campus/code/TRY
 *
 * @apiUse RoomSuccess
 * @apiUse GetRoomsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /rooms/building/:id GET: By Building ID
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method returns Room objects associated with the building's database id.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {Integer} id The building's unique ID.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/rooms/building/3
 *
 * @apiUse RoomSuccess
 * @apiUse GetRoomsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /rooms/building/code/:code GET: By Building Code
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method returns Room objects associated with the building's unique code.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiParam {String} code The building's unique code.
 *
 * @apiExample {curl} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/rooms/building/code/WES514
 *
 * @apiUse RoomSuccess
 * @apiUse GetRoomsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */