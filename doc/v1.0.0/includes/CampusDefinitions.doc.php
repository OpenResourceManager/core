<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 12/31/15
 * Time: 4:30 PM
 */

/**
 * @apiDefine CampusParameters1.0.0
 * @apiParam (Campus Parameters) {String} code The campuses' name unique identifier string.
 * @apiParam (Campus Parameters) {String} name The campuses' name, this is a label.
 */

/**
 * @apiDefine CampusSuccess1.0.0
 * @apiSuccess (Success 2xx: Campus) {Integer} id The numeric id assigned to the course by the database.
 * @apiSuccess (Success 2xx: Campus) {String} code The campuses' unique identifier string.
 * @apiSuccess (Success 2xx: Campus) {String} name The campuses' name, this is a label.
 */

/**
 * @apiDefine GetCampusesSuccessResultExample1.0.0
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
 *                  "code": "KUB8",
 *                  "name": "Kubberg"
 *              },
 *              {
 *                  "id": 2,
 *                  "code": "MOS7",
 *                  "name": "Mosciskiport"
 *              },
 *              {
 *                  "id": 3,
 *                  "code": "POR3",
 *                  "name": "Port Maymieberg"
 *              },
 *              {
 *                  "id": 4,
 *                  "code": "EAS1",
 *                  "name": "East Geoburgh"
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetCampusSuccessResultExample1.0.0
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 1,
 *              "code": "KUB8",
 *              "name": "Kubberg"
 *          }
 *      }
 */