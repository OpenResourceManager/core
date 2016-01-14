<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 12/31/15
 * Time: 4:30 PM
 */

/**
 * @apiDefine RoomParameters
 * @apiParam (Room Parameters) {String} code A unique string that needs to be assigned to a room.
 * @apiParam (Room Parameters) {Integer} building_id The id number assigned to the parent building by the database.
 * @apiParam (Room Parameters) {Integer} [floor_number] The floor's number.
 * @apiParam (Room Parameters) {String} [floor_name] The floor's name, this is a label.
 * @apiParam (Room Parameters) {Integer} room_number The room's number.
 * @apiParam (Room Parameters) {String} [room_name] The room's name, this is a label.
 */

/**
 * @apiDefine RoomSuccess
 * @apiSuccess (Success 2xx: Room) {Integer} id The numeric id assigned to the building by the database.
 * @apiSuccess (Success 2xx: Room) {String} code A unique string that needs to be assigned to a room.
 * @apiSuccess (Success 2xx: Room) {Integer} building_id The id number assigned to the parent building by the database.
 * @apiSuccess (Success 2xx: Room) {Integer} floor_number The floor's number.
 * @apiSuccess (Success 2xx: Room) {String} floor_name The floor's name, this is a label.
 * @apiSuccess (Success 2xx: Room) {Integer} room_number The room's number.
 * @apiSuccess (Success 2xx: Room) {String} room_name The room's name, this is a label.
 */

/**
 * @apiDefine AssignmentRoomUserParams
 * @apiParam user {Integer} The database ID of the user.
 * @apiParam room {Integer} The database ID of the room.
 */

/**
 * @apiDefine AssignmentRoomUserIDParams
 * @apiParam user_id {String} The unique identifier string associated with a user.
 * @apiParam room {Integer} The database ID of the room.
 */

/**
 * @apiDefine AssignmentRoomUsernameIDParams
 * @apiParam username {String} The unique username string associated with a user.
 * @apiParam room {Integer} The database ID of the room.
 */

/**
 * @apiDefine AssignmentRoomCodeUserParams
 * @apiParam user {Integer} The database ID of the user
 * @apiParam room {String} The unique code string of the room.
 */

/**
 * @apiDefine AssignmentRoomCodeUserIDParams
 * @apiParam user_id {String} The unique identifier string associated with a user.
 * @apiParam room {String} The unique code string of the room.
 */

/**
 * @apiDefine AssignmentRoomCodeUsernameIDParams
 * @apiParam username {String} The unique username string associated with a user.
 * @apiParam room {String} The unique code string of the room.
 */

/**
 * @apiDefine GetRoomsSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 40,
 *              "current_page": 1,
 *              "result_limit": 5,
 *              "next_page": "api\/v1\/rooms?limit=5&page=2",
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "code": "ACK423",
 *                  "building_id": 31,
 *                  "floor_number": 0,
 *                  "floor_name": null,
 *                  "room_number": 423,
 *                  "room_name": null
 *              },
 *              {
 *                  "id": 2,
 *                  "code": "COWE272",
 *                  "building_id": 1,
 *                  "floor_number": 0,
 *                  "floor_name": null,
 *                  "room_number": 272,
 *                  "room_name": null
 *              },
 *              {
 *                  "id": 3,
 *                  "code": "GURL272",
 *                  "building_id": 143,
 *                  "floor_number": 0,
 *                  "floor_name": null,
 *                  "room_number": 272,
 *                  "room_name": null
 *              },
 *              {
 *                  "id": 4,
 *                  "code": "WEST317",
 *                  "building_id": 176,
 *                  "floor_number": 3,
 *                  "floor_name": "Third Floor",
 *                  "room_number": 317,
 *                  "room_name": null
 *              },
 *              {
 *                  "id": 5,
 *                  "code": "HART137",
 *                  "building_id": 83,
 *                  "floor_number": 0,
 *                  "floor_name": null,
 *                  "room_number": 137,
 *                  "room_name": null
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetRoomSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 1,
 *              "code": "ACK423",
 *              "building_id": 31,
 *              "floor_number": 0,
 *              "floor_name": null,
 *              "room_number": 423,
 *              "room_name": null
 *          }
 *      }
 */

/**
 * @apiDefine AssignPresentRoomResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "message": "Assignment Already Present",
 *              "id": {
 *                  "user": 20,
 *                  "room": 1
 *              }
 *          }
 *      }
 */

/**
 * @apiDefine AssignNewRoomResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "message": "Assigned",
 *              "id": {
 *                  "user": 20,
 *                  "room": 1
 *              }
 *          }
 *      }
 */

/**
 * @apiDefine AssignmentNotPresentRoomResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "message": "Assignment Not Present",
 *              "id": {
 *                  "user": 20,
 *                  "room": 1
 *              }
 *          }
 *      }
 */

/**
 * @apiDefine UnassignRoomResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "message": "Unassigned",
 *              "id": {
 *                  "user": 20,
 *                  "room": 1
 *              }
 *          }
 *      }
 */
