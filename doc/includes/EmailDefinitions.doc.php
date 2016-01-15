<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 12/31/15
 * Time: 4:30 PM
 */

/**
 * @apiDefine EmailParameters
 * @apiParam (Email Parameters) {Integer} user_id The user that this email address belongs to.
 * @apiParam (Email Parameters) {String} email The email address string.
 */

/**
 * @apiDefine EmailSuccess
 * @apiSuccess (Success 2xx: Email) {Integer} id The numeric id assigned to the email by the database.
 * @apiSuccess (Success 2xx: Email) {Integer} user_id The user that this email address belongs to.
 * @apiSuccess (Success 2xx: Email) {String} email The email address string.
 */

/**
 * @apiDefine GetEmailsSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 20,
 *              "current_page": 1,
 *              "result_limit": 5,
 *              "next_page": "api\/v1\/emails?limit=5&page=2",
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "user_id": 53,
 *                  "email": "Lizzie60@Schamberger.info"
 *              },
 *              {
 *                  "id": 2,
 *                  "user_id": 6,
 *                  "email": "Myrl.Berge@yahoo.com"
 *              },
 *              {
 *                  "id": 3,
 *                  "user_id": 147,
 *                  "email": "Crist.Anabel@Lowe.com"
 *              },
 *              {
 *                  "id": 4,
 *                  "user_id": 24,
 *                  "email": "Maryjane71@yahoo.com"
 *              },
 *              {
 *                  "id": 5,
 *                  "user_id": 73,
 *                  "email": "Hoyt71@yahoo.com"
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetEmailSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 1,
 *              "user_id": 53,
 *              "email": "Lizzie60@Schamberger.info"
 *          }
 *      }
 */
