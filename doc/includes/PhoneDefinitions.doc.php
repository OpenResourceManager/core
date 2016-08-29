<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 12/31/15
 * Time: 4:30 PM
 */

/**
 * @apiDefine PhoneParameters
 * @apiParam (Phone Parameters) {Integer} user_id The user that this phone belongs to.
 * @apiParam (Phone Parameters) {Integer} number The phone number.
 * @apiParam (Phone Parameters) {Integer} [ext] The phone number's extension, if there is one.
 * @apiParam (Phone Parameters) {Boolean} is_cell Signifies if the phone number is a mobile number.
 * @apiParam (Phone Parameters) {Integer} [mobile_carrier_id] The mobile carrier id.
 */

/**
 * @apiDefine PhoneSuccess
 * @apiSuccess (Success 2xx: Phone) {Integer} id The numeric id assigned to the email by the database.
 * @apiSuccess (Success 2xx: Phone) {Integer} user_id The user that this phone belongs to.
 * @apiSuccess (Success 2xx: Phone) {Integer} number The phone number.
 * @apiSuccess (Success 2xx: Phone) {Integer} ext The phone number's extension, if there is one.
 * @apiSuccess (Success 2xx: Phone) {Boolean} is_cell Signifies if the phone number is a mobile number.
 * @apiSuccess (Success 2xx: Phone) {Integer} [mobile_carrier_id] The mobile carrier id.
 */

/**
 * @apiDefine GetPhonesSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 100,
 *              "current_page": 1,
 *              "result_limit": 5,
 *              "next_page": "api\/v1\/phones?limit=5&page=2",
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "user_id": 67,
 *                  "number": 16441181126,
 *                  "ext": 0,
 *                  "is_cell": false,
 *                  "mobile_carrier_id": null
 *              },
 *              {
 *                  "id": 2,
 *                  "user_id": 83,
 *                  "number": 14235907536,
 *                  "ext": 355,
 *                  "is_cell": false,
 *                  "mobile_carrier_id": null
 *              },
 *              {
 *                  "id": 3,
 *                  "user_id": 85,
 *                  "number": 13716372143,
 *                  "ext": null,
 *                  "is_cell": true,
 *                  "carrier": {
 *                      "id": 4,
 *                      "code": "TMO",
 *                      "name": "T-Mobile"
 *                  }
 *              },
 *              {
 *                  "id": 4,
 *                  "user_id": 83,
 *                  "number": 11862830925,
 *                  "ext": null,
 *                  "is_cell": true,
 *                  "carrier": {
 *                      "id": 1,
 *                      "code": "VZW",
 *                      "name": "Verizon Wireless"
 *                  }
 *              },
 *              {
 *                  "id": 5,
 *                  "user_id": 3,
 *                  "number": 19551878346,
 *                  "ext": 769,
 *                  "is_cell": false,
 *                  "carrier": null
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetPhoneSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 1,
 *              "user_id": 67,
 *              "number": 16441181126,
 *              "ext": 0,
 *              "is_cell": false,
 *              "carrier": null
 *          }
 *      }
 */
