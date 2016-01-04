<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 12/31/15
 * Time: 4:30 PM
 */

/**
 * @apiDefine RoomParameters
 * @apiParam (Room Parameters) {Integer} user_id The id number assigned to the parent user by the database.
 * @apiParam (Room Parameters) {Integer} building_id The id number assigned to the parent building by the database.
 * @apiParam (Room Parameters) {Integer} [floor_number] The floor's number.
 * @apiParam (Room Parameters) {String} [floor_name] The floor's name, this is a label.
 * @apiParam (Room Parameters) {Integer} room_number The room's number.
 * @apiParam (Room Parameters) {String} [room_name] The room's name, this is a label.
 */

/**
 * @apiDefine RoomSuccess
 * @apiSuccess (Success 2xx: Room) {Integer} id The numeric id assigned to the building by the database.
 * @apiSuccess (Success 2xx: Room) {Integer} user_id The id number assigned to the parent user by the database.
 * @apiSuccess (Success 2xx: Room) {Integer} building_id The id number assigned to the parent building by the database.
 * @apiSuccess (Success 2xx: Room) {Integer} floor_number The floor's number.
 * @apiSuccess (Success 2xx: Room) {String} floor_name The floor's name, this is a label.
 * @apiSuccess (Success 2xx: Room) {Integer} room_number The room's number.
 * @apiSuccess (Success 2xx: Room) {String} room_name The room's name, this is a label.
 */

/**
 * @apiDefine GetRoomSuccessResultExample
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
 *                  "user_id": 2,
 *                  "building_id": 31,
 *                  "floor_number": 0,
 *                  "floor_name": null,
 *                  "room_number": 423,
 *                  "room_name": null
 *              },
 *              {
 *                  "id": 2,
 *                  "user_id": 19,
 *                  "building_id": 1,
 *                  "floor_number": 0,
 *                  "floor_name": null,
 *                  "room_number": 272,
 *                  "room_name": null
 *              },
 *              {
 *                  "id": 3,
 *                  "user_id": 46,
 *                  "building_id": 143,
 *                  "floor_number": 0,
 *                  "floor_name": null,
 *                  "room_number": 272,
 *                  "room_name": null
 *              },
 *              {
 *                  "id": 4,
 *                  "user_id": 44,
 *                  "building_id": 176,
 *                  "floor_number": 3,
 *                  "floor_name": "Third Floor",
 *                  "room_number": 317,
 *                  "room_name": null
 *              },
 *              {
 *                  "id": 5,
 *                  "user_id": 33,
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
 *              "user_id": 2,
 *              "building_id": 31,
 *              "floor_number": 0,
 *              "floor_name": null,
 *              "room_number": 423,
 *              "room_name": null
 *          }
 *      }
 */