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
 * @apiParam (Phone Parameters) {Number} number The phone number.
 * @apiParam (Phone Parameters) {Number} [country_code] The phone numbers country code.
 * @apiParam (Phone Parameters) {Number} [ext] The phone number's extension, if there is one.
 * @apiParam (Phone Parameters) {Boolean} is_cell Signifies if the phone number is a mobile number.
 * @apiParam (Phone Parameters) {Boolean} [verified] Signifies if the phone number is a verified number.
 * @apiParam (Phone Parameters) {Integer} [mobile_carrier_id] The mobile carrier id.
 */

/**
 * @apiDefine PhoneSuccess
 * @apiSuccess (Success 2xx: Phone) {Integer} id The numeric id assigned to the email by the database.
 * @apiSuccess (Success 2xx: Phone) {Integer} user_id The user that this phone belongs to.
 * @apiSuccess (Success 2xx: Phone) {Number} number The phone number.
 * @apiSuccess (Success 2xx: Phone) {Number} country_code The phone number's country code.
 * @apiSuccess (Success 2xx: Phone) {Number} ext The phone number's extension, if there is one.
 * @apiSuccess (Success 2xx: Phone) {Boolean} is_cell Signifies if the phone number is a mobile number.
 * @apiSuccess (Success 2xx: Phone) {Boolean} verified Signifies if the phone number is a verified number.
 * @apiSuccess (Success 2xx: Phone) {String} verify_token The verification token sent to an number used to verify them.
 * @apiSuccess (Success 2xx: Phone) {Object} carrier The mobile carrier that the phone number belongs to.
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
 *                  "number": "6441181126",
 *                  "country_code": "1",
 *                  "ext": null,
 *                  "is_cell": false,
 *                  "verified": false,
 *                  "verify_token": null,
 *                  "carrier": null
 *              },
 *              {
 *                  "id": 2,
 *                  "user_id": 83,
 *                  "number": "4235907536",
 *                  "country_code": "1",
 *                  "ext": "355",
 *                  "is_cell": false,
 *                  "verified": false,
 *                  "verify_token": null,
 *                  "carrier": null
 *              },
 *              {
 *                  "id": 3,
 *                  "user_id": 85,
 *                  "number": "3716372143",
 *                  "country_code": "1",
 *                  "ext": null,
 *                  "is_cell": true,
 *                  "verified": true,
 *                  "verify_token": null,
 *                  "carrier": {
 *                      "id": 4,
 *                      "code": "TMO",
 *                      "name": "T-Mobile"
 *                  }
 *              },
 *              {
 *                  "id": 4,
 *                  "user_id": 83,
 *                  "number": "1862830925",
 *                  "country_code": "1",
 *                  "ext": null,
 *                  "is_cell": true,
 *                  "verified": true,
 *                  "verify_token": "jkfn98df89s3",
 *                  "carrier": {
 *                      "id": 1,
 *                      "code": "VZW",
 *                      "name": "Verizon Wireless"
 *                  }
 *              },
 *              {
 *                  "id": 5,
 *                  "user_id": 3,
 *                  "number": "9551878346",
 *                  "country_code": "1",
 *                  "ext": "769",
 *                  "is_cell": false,
 *                  "verified": false,
 *                  "verify_token": null,
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
 *              "number": "6441181126",
 *              "country_code": "1",
 *              "ext": null,
 *              "is_cell": true,
 *              "verified": false,
 *              "verify_token": "mfknawj7efe",
 *              "carrier": {
 *                      "id": 1,
 *                      "code": "VZW",
 *                      "name": "Verizon Wireless"
 *                  }
 *          }
 *      }
 */

/**
 * @apiDefine GetUsersPhonesSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 1,
 *              "current_page": 1,
 *              "result_limit": 15,
 *              "next_page": null,
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 504,
 *                  "user_id": 153,
 *                  "number": 6549758012,
 *                  "country_code": "1",
 *                  "ext": 0,
 *                  "is_cell": true,
 *                  "verified": true,
 *                  "verify_token": null,
 *                  "carrier": {
 *                      "id": 1,
 *                      "code": "VZW",
 *                      "name": "Verizon Wireless"
 *                  }
 *              },
 *              {
 *                  "id": 504,
 *                  "user_id": 153,
 *                  "number": 569758012,
 *                  "country_code": "1",
 *                  "ext": 0,
 *                  "verified": false,
 *                  "verify_token": null,
 *                  "is_cell": false,
 *                  "carrier": null
 *              }
 *          ]
 *      }
 */
