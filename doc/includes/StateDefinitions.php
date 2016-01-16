<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/16
 * Time: 1:42 AM
 */

/**
 * @apiDefine StateParameters
 * @apiParam (State Parameters) {String} code The state's name unique identifier string.
 * @apiParam (State Parameters) {String} name The state's name, this is a label.
 * @apiParam (State Parameters) {String} abbreviation The state's shortened name.
 */

/**
 * @apiDefine StateSuccess
 * @apiSuccess (Success 2xx: State) {Integer} id The numeric id assigned to the course by the database.
 * @apiSuccess (Success 2xx: State) {String} code The state's unique identifier string.
 * @apiSuccess (Success 2xx: State) {String} name The state's name, this is a label.
 * @apiSuccess (Success 2xx: State) {String} abbreviation The state's shortened name.
 */

/**
 * @apiDefine GetStatesSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 20,
 *              "current_page": 1,
 *              "result_limit": 5,
 *              "next_page": "api\/v1\/states?limit=5&page=2",
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "country_id": 226,
 *                  "code": "AL",
 *                  "name": "Alabama"
 *              },
 *              {
 *                  "id": 2,
 *                  "country_id": 226,
 *                  "code": "AK",
 *                  "name": "Alaska"
 *              },
 *              {
 *                  "id": 3,
 *                  "country_id": 226,
 *                  "code": "AZ",
 *                  "name": "Arizona"
 *              },
 *              {
 *                  "id": 4,
 *                  "country_id": 226,
 *                  "code": "AR",
 *                  "name": "Arkansas"
 *              },
 *              {
 *                  "id": 5,
 *                  "country_id": 226,
 *                  "code": "CA",
 *                  "name": "California"
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetStateSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 226,
 *              "country_id": 226,
 *              "code": "NY",
 *              "name": "New York"
 *          }
 *      }
 */