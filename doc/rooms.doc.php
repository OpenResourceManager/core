<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/7/16
 * Time: 12:19 PM
 */

/**
 * @api {post} /rooms POST: Create/Update Room
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method creates a new room, or updates an room object with the specified room address.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -m post -d "user_id=151&building_id=11&floor_number=2&floor_name=The Second Floor&room_number=204&room_name=West Mohawk Room"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user_id=151" \
 *      --data "building_id=11" \
 *      --data "floor_number=2" \
 *      --data "floor_name=The Second Floor" \
 *      --data "room_number=204" \
 *      --data "room_name=West Mohawk Room" \
 *      --url https://databridge.sage.edu/api/v1/rooms
 *
 * @apiUse CreateSuccessResultExample
 * @apiUse UpdateSuccessResultExample
 * @apiUse UnprocessableEntityErrors
 * @apiUse RoomParameters
 */

/**
 * @api {get} /rooms GET: Request Rooms
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method returns pages of Room objects.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse PaginationParams
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/rooms
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
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The room's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -p 501
 *
 * @apiExample {bash} Curl
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
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The room's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -m delete -p 501
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/rooms/501
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {delete} /rooms/code/:code DELETE: Destroy By Code
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method deletes a Room object, a room's unique code is supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiSuccessExampleDestroy
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} code The room's unique code.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -m delete -p code/ACK303
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --url https://databridge.sage.edu/api/v1/rooms/code/ACK303
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
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The users unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -p user/153
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/rooms/user/153
 *
 * @apiUse RoomSuccess
 * @apiUse GetRoomsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /rooms/username/:username GET: By Username
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method returns Room objects associated with the Username that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} username The users unique username.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -p username/skywal
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/rooms/username/skywal
 *
 * @apiUse RoomSuccess
 * @apiUse GetRoomsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {get} /rooms/identifier/:identifier GET: By User Identifier
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method returns Room objects associated with the Identifier that was supplied.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiParam {String} identifier The user's unique identifier string.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -p identifier/979659
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/rooms/identifier/979659
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
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The campuses' unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -p campus/3
 *
 * @apiExample {bash} Curl
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
 * @apiUse InternalServerErrors
 * @apiParam {String} code The campuses' unique code.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -p campus/code/TRY
 *
 * @apiExample {bash} Curl
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
 * @apiUse InternalServerErrors
 * @apiParam {Integer} id The building's unique ID.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -p building/3
 *
 * @apiExample {bash} Curl
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
 * @apiUse InternalServerErrors
 * @apiParam {String} code The building's unique code.
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -p building/code/WES514
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" --url https://databridge.sage.edu/api/v1/rooms/building/code/WES514
 *
 * @apiUse RoomSuccess
 * @apiUse GetRoomsSuccessResultExample
 *
 * @apiUse ModelNotFoundError
 */

/**
 * @api {post} /rooms/user POST: Assign to User
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method assigns a room to a user, using the user and room database id values.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewRoomResultExample
 * @apiUse AssignPresentRoomResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -m post -d "user=25&room=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user=25" \
 *      --data "room=1" \
 *      --url https://databridge.sage.edu/api/v1/rooms/user
 *
 * @apiUse AssignmentRoomUserParams
 */

/**
 * @api {post} /rooms/identifier POST: Assign to Identifier
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method assigns a room to a user, using the identifier value and room database id value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewRoomResultExample
 * @apiUse AssignPresentRoomResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -m post -d "identifier=0958757&room=1'
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "identifier=0958757" \
 *      --data "room=1" \
 *      --url https://databridge.sage.edu/api/v1/rooms/identifier
 *
 * @apiUse AssignmentRoomUserIDParams
 */

/**
 * @api {post} /rooms/username POST: Assign to Username
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method assigns a room to a user, using the username value and room database id value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewRoomResultExample
 * @apiUse AssignPresentRoomResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -m post -d "username=skywal&room=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "username=skywal" \
 *      --data "room=1" \
 *      --url https://databridge.sage.edu/api/v1/rooms/username
 *
 * @apiUse AssignmentRoomUsernameIDParams
 */

/**
 * @api {post} /rooms/code/user POST: Assign Code to User
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method assigns a room to a user, using the user and room code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewRoomResultExample
 * @apiUse AssignPresentRoomResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -m post -p code/user -d "user=25&code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "user=25" \
 *      --data "code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/rooms/code/user
 *
 * @apiUse AssignmentRoomCodeUserParams
 */

/**
 * @api {post} /rooms/code/identifier/ POST: Assign Code to Identifier
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method assigns a room to a user, using the identifier value and room code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewRoomResultExample
 * @apiUse AssignPresentRoomResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -m post -p code/identifier -d "identifier=0958757&code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "identifier=0958757" \
 *      --data "code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/rooms/code/identifier/
 *
 * @apiUse AssignmentRoomCodeUserIDParams
 */

/**
 * @api {post} /rooms/code/username POST: Assign Code to Username
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method assigns a room to a user, using the username value and room code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse AssignNewRoomResultExample
 * @apiUse AssignPresentRoomResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -m post -p code/username -d "username=skywal&code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "POST" \
 *      --data "username=skywal" \
 *      --data "code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/rooms/code/username
 *
 * @apiUse AssignmentRoomCodeUsernameIDParams
 */

/**
 * @api {delete} /rooms/user DELETE: Unassign User
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method unassigns a user from a room a user, using the user and room database id values.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignRoomResultExample
 * @apiUse AssignmentNotPresentRoomResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -m delete -p user -d "user=25&room=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "user=25" \
 *      --data "room=1" \
 *      --url https://databridge.sage.edu/api/v1/rooms/user
 *
 * @apiUse AssignmentRoomUserParams
 */

/**
 * @api {delete} /rooms/identifier DELETE: Unassign from Identifier
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method unassigns a user from a room a user, using the identifier value and room database id value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignRoomResultExample
 * @apiUse AssignmentNotPresentRoomResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -m delete -p identifier -d "identifier=0958757&room=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "identifier=0958757" \
 *      --data "room=1" \
 *      --url https://databridge.sage.edu/api/v1/rooms/identifier
 *
 * @apiUse AssignmentRoomUserIDParams
 */

/**
 * @api {delete} /rooms/username DELETE: Unassign from Username
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method unassigns a user from a room a user, using the username value and room database id value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignRoomResultExample
 * @apiUse AssignmentNotPresentRoomResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -m delete -p username -d "username=skywal&room=1"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "username=skywal" \
 *      --data "room=1" \
 *      --url https://databridge.sage.edu/api/v1/rooms/username
 *
 * @apiUse AssignmentRoomUsernameIDParams
 */

/**
 * @api {delete} /rooms/code/user DELETE: Unassign Code from User
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method unassigns a user from a room a user, using the user and room code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignRoomResultExample
 * @apiUse AssignmentNotPresentRoomResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -m delete -p code/user -d "user=25&code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "user=25" \
 *      --data "code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/rooms/code/user
 *
 * @apiUse AssignmentRoomCodeUserParams
 */

/**
 * @api {delete} /rooms/code/identifier DELETE: Unassign Code from Identifier
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method unassigns a user from a room a user, using the identifier value and room code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignRoomResultExample
 * @apiUse AssignmentNotPresentRoomResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -m delete -p code/identifier -d "identifier=0958757&code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "identifier=0958757" \
 *      --data "code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/rooms/code/identifier
 *
 * @apiUse AssignmentRoomCodeUserIDParams
 */

/**
 * @api {delete} /rooms/code/username DELETE: Unassign Code from Username
 * @apiVersion 1.1.1
 * @apiGroup Rooms
 * @apiDescription This method unassigns a user from a room a user, using the username value and room code value.
 *
 * @apiUse ApiSuccessFields
 * @apiUse ApiErrorFields
 * @apiUse AuthorizationHeader
 * @apiUse InternalServerErrors
 * @apiUse UnprocessableEntityErrors
 *
 * @apiUse UnassignRoomResultExample
 * @apiUse AssignmentNotPresentRoomResultExample
 *
 * @apiExample {bash} UUD Client
 *      # This example uses the UUD Client: https://gitlab.sage.edu/UniversalUserData/uud-client
 *      uud -o rooms -m delete -p code/username -d "username=skywal&code=STUDENT"
 *
 * @apiExample {bash} Curl
 *      curl -H "X-Authorization: <Your-API-Key>" \
 *      -X "DELETE" \
 *      --data "username=skywal" \
 *      --data "code=STUDENT" \
 *      --url https://databridge.sage.edu/api/v1/rooms/code/username
 *
 * @apiUse AssignmentRoomCodeUsernameIDParams
 */
