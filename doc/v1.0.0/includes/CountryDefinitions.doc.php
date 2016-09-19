<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/16
 * Time: 12:50 AM
 */

/**
 * @apiDefine CountryParameters1.0.0
 * @apiParam (Country Parameters) {String} code The countries' name unique identifier string.
 * @apiParam (Country Parameters) {String} name The countries' name, this is a label.
 * @apiParam (Country Parameters) {String} abbreviation The countries' shortened name.
 */

/**
 * @apiDefine CountrySuccess1.0.0
 * @apiSuccess (Success 2xx: Country) {Integer} id The numeric id assigned to the country by the database.
 * @apiSuccess (Success 2xx: Country) {String} code The countries' unique identifier string.
 * @apiSuccess (Success 2xx: Country) {String} name The countries' name, this is a label.
 * @apiSuccess (Success 2xx: Country) {String} abbreviation The countries' shortened name.
 */

/**
 * @apiDefine GetCountriesSuccessResultExample1.0.0
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 20,
 *              "current_page": 1,
 *              "result_limit": 5,
 *              "next_page": "api\/v1\/countries?limit=5&page=2",
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "abbreviation": "AF",
 *                  "code": "AFG",
 *                  "name": "Afghanistan"
 *              },
 *              {
 *                  "id": 2,
 *                  "abbreviation": "AL",
 *                  "code": "ALB",
 *                  "name": "Albania"
 *              },
 *              {
 *                  "id": 3,
 *                  "abbreviation": "DZ",
 *                  "code": "DZA",
 *                  "name": "Algeria"
 *              },
 *              {
 *                  "id": 4,
 *                  "abbreviation": "AS",
 *                  "code": "ASM",
 *                  "name": "American Samoa"
 *              },
 *              {
 *                  "id": 5,
 *                  "abbreviation": "AD",
 *                  "code": "AND",
 *                  "name": "Andorra"
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetCountrySuccessResultExample1.0.0
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 226,
 *              "abbreviation": "US",
 *              "code": "USA",
 *              "name": "United States"
 *          }
 *      }
 */