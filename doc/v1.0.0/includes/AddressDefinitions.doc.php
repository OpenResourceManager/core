<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/16
 * Time: 1:42 AM
 *
 * @todo Version all include method names so api docs can be versioned easily
 */

/**
 * @apiDefine AddressParameters1.0.0
 * @apiParam (Address Parameters) {Integer} user_id The user who is associated with this address.
 * @apiParam (Address Parameters) {String} [addressee] The name of the addressee if different from the user's name.
 * @apiParam (Address Parameters) {String} [organization] The organization that the addressee belongs to.
 * @apiParam (Address Parameters) {String} line_1 The first address line.
 * @apiParam (Address Parameters) {String} [line_2] The second address line.
 * @apiParam (Address Parameters) {String} city The city line of the address.
 * @apiParam (Address Parameters) {Integer} state_id The id of the state or territory that the address resides in.
 * @apiParam (Address Parameters) {String} zip The zip code that the address resides in.
 * @apiParam (Address Parameters) {Integer} country_id The id of the country that the address resides in.
 * @apiParam (Address Parameters) {Float} [latitude] The latitude of the address.
 * @apiParam (Address Parameters) {Float} [longitude] The longitude of the address.
 */

/**
 * @apiDefine AddressSuccess1.0.0
 * @apiSuccess (Success 2xx: Address) {Integer} id The numeric id assigned to the address by the database.
 * @apiSuccess (Success 2xx: Address) {Integer} user_id The user who is associated with this address.
 * @apiSuccess (Success 2xx: Address) {String} addressee The name of the addressee if different from the user's name.
 * @apiSuccess (Success 2xx: Address) {String} organization The organization that the addressee belongs to.
 * @apiSuccess (Success 2xx: Address) {String} line_1 The first address line.
 * @apiSuccess (Success 2xx: Address) {String} line_2 The second address line.
 * @apiSuccess (Success 2xx: Address) {String} city The city line of the address.
 * @apiSuccess (Success 2xx: Address) {Integer} state_id The id of the state or territory that the address resides in.
 * @apiSuccess (Success 2xx: Address) {String} zip The zip code that the address resides in.
 * @apiSuccess (Success 2xx: Address) {Integer} country_id The id of the country that the address resides in.
 * @apiSuccess (Success 2xx: Address) {Float} latitude The latitude of the address.
 * @apiSuccess (Success 2xx: Address) {Float} longitude The longitude of the address.
 */

/**
 * @apiDefine GetAddressesSuccessResultExample1.0.0
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 80,
 *              "current_page": 1,
 *              "result_limit": 5,
 *              "next_page": "api\/v1\/addresses?limit=5&page=2",
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "user_id": 142,
 *                  "addressee": " Terrill Pfannerstill",
 *                  "organization": null,
 *                  "line_1": "8782 Ortiz Stravenue Apt. 102\nWest Hassiechester",
 *                  "line_2": null,
 *                  "city": "Rosaliaside",
 *                  "state_id": 38,
 *                  "zip": "80",
 *                  "country_id": 226,
 *                  "latitude": 0,
 *                  "longitude": 0
 *              },
 *              {
 *                  "id": 2,
 *                  "user_id": 106,
 *                  "addressee": " Yolanda Keenan Ullrich Mr.",
 *                  "organization": "Sipes, Smitham and Pollich",
 *                  "line_1": "17127 Leannon Trafficway Suite 727\nPort Nestormout",
 *                  "line_2": null,
 *                  "city": "Bechtelarland",
 *                  "state_id": 2,
 *                  "zip": "27837978",
 *                  "country_id": 226,
 *                  "latitude": 0,
 *                  "longitude": 0
 *              },
 *              {
 *                  "id": 3,
 *                  "user_id": 93,
 *                  "addressee": null,
 *                  "organization": null,
 *                  "line_1": "850 Karianne Crest Suite 374\nGabrielleberg, ID 654",
 *                  "line_2": null,
 *                  "city": "Nickolasmouth",
 *                  "state_id": 5,
 *                  "zip": "9905561",
 *                  "country_id": 226,
 *                  "latitude": 0,
 *                  "longitude": 999999.99
 *              },
 *              {
 *                  "id": 4,
 *                  "user_id": 117,
 *                  "addressee": "Prof. Cordia Iva Grant Dr.",
 *                  "organization": null,
 *                  "line_1": "8304 Bernadine Tunnel Apt. 583\nReeseport, NM 32332",
 *                  "line_2": "repellat",
 *                  "city": "West Kaliport",
 *                  "state_id": 17,
 *                  "zip": "0",
 *                  "country_id": 226,
 *                  "latitude": 0,
 *                  "longitude": 0
 *              },
 *              {
 *                  "id": 5,
 *                  "user_id": 4,
 *                  "addressee": "Mrs. Regan  Cruickshank ",
 *                  "organization": null,
 *                  "line_1": "1897 Ryan Cape\nPort Hobarttown, NV 87404",
 *                  "line_2": null,
 *                  "city": "Everetttown",
 *                  "state_id": 43,
 *                  "zip": "90",
 *                  "country_id": 226,
 *                  "latitude": 0,
 *                  "longitude": 0
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetAddressSuccessResultExample1.0.0
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 1,
 *              "user_id": 142,
 *              "addressee": " Terrill Pfannerstill",
 *              "organization": null,
 *              "line_1": "8782 Ortiz Stravenue Apt. 102\nWest Hassiechester",
 *              "line_2": null,
 *              "city": "Rosaliaside",
 *              "state_id": 38,
 *              "zip": "80",
 *              "country_id": 226,
 *              "latitude": 0,
 *              "longitude": 0
 *          }
 *      }
 */