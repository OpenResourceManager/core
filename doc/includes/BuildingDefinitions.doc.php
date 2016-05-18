<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 12/31/15
 * Time: 4:30 PM
 */

/**
 * @apiDefine BuildingParameters
 * @apiParam (Building Parameters) {Integer} campus_id The id number assigned to the parent campus by the database.
 * @apiParam (Building Parameters) {String} code The building's name unique identifier string.
 * @apiParam (Building Parameters) {String} name The building's name, this is a label.
 */

/**
 * @apiDefine BuildingParametersCampusCode
 * @apiParam (Building Parameters) {String} campus_code The code assigned to the parent campus.
 * @apiParam (Building Parameters) {String} code The building's name unique identifier string.
 * @apiParam (Building Parameters) {String} name The building's name, this is a label.
 */

/**
 * @apiDefine BuildingSuccess
 * @apiSuccess (Success 2xx: Building) {Integer} id The numeric id assigned to the building by the database.
 * @apiSuccess (Success 2xx: Building) {Integer} campus_id The id number assigned to the parent campus by the database.
 * @apiSuccess (Success 2xx: Building) {String} code The building's unique identifier string.
 * @apiSuccess (Success 2xx: Building) {String} name The building's name, this is a label.
 */

/**
 * @apiDefine GetBuildingsSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 40,
 *              "current_page": 1,
 *              "result_limit": 5,
 *              "next_page": "api\/v1\/buildings?limit=5&page=2",
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "campus_id": 1,
 *                  "code": "TER438",
 *                  "name": "Terry Course Pavilion"
 *              },
 *              {
 *                  "id": 2,
 *                  "campus_id": 4,
 *                  "code": "MAY264",
 *                  "name": "Mayert Camp Annex"
 *              },
 *              {
 *                  "id": 3,
 *                  "campus_id": 1,
 *                  "code": "EAS726",
 *                  "name": "East Building"
 *              },
 *              {
 *                  "id": 4,
 *                  "campus_id": 1,
 *                  "code": "LAV72",
 *                  "name": "Lavinia Hodkiewicz House"
 *              },
 *              {
 *                  "id": 5,
 *                  "campus_id": 3,
 *                  "code": "SOU692",
 *                  "name": "South Schulist Pavilion"
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetBuildingSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 1,
 *              "campus_id": 1,
 *              "code": "TER438",
 *              "name": "Terry Course Pavilion"
 *          }
 *      }
 */