<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/29/16
 * Time: 2:23 PM
 */

/**
 * @apiDefine MobileCarrierParameters
 * @apiParam (MobileCarrier Parameters) {String} code The mobile carrier's name unique identifier string.
 * @apiParam (MobileCarrier Parameters) {String} name The mobile carrier's name, this is a label.
 */

/**
 * @apiDefine MobileCarrierSuccess
 * @apiSuccess (Success 2xx: MobileCarrier) {Integer} id The numeric id assigned to the course by the database.
 * @apiSuccess (Success 2xx: MobileCarrier) {String} code The mobile carrier's unique identifier string.
 * @apiSuccess (Success 2xx: MobileCarrier) {String} name The mobile carrier's name, this is a label.
 */

/**
 * @apiDefine GetMobileCarriersSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 1,
 *              "current_page": 1,
 *              "result_limit": 25,
 *              "next_page": "null",
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "code": "VZW",
 *                  "name": "Verizon Wireless"
 *              },
 *              {
 *                  "id": 2,
 *                  "code": "ATT",
 *                  "name": "AT&T"
 *              },
 *              {
 *                  "id": 3,
 *                  "code": "SPT",
 *                  "name": "Sprint"
 *              },
 *              {
 *                  "id": 4,
 *                  "code": "TMO",
 *                  "name": "T-Mobile"
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetMobileCarrierSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 1,
 *              "code": "VZW",
 *              "name": "Verizon Wireless"
 *          }
 *      }
 */