<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 12/31/15
 * Time: 4:30 PM
 */

/**
 * @apiDefine CourseParameters1.0.0
 * @apiParam (Course Parameters) {Integer} department_id The id number assigned to the parent department by the database.
 * @apiParam (Course Parameters) {String} code The courses' unique identifier string.
 * @apiParam (Course Parameters) {Integer} course_level The academic level of a course.
 * @apiParam (Course Parameters) {String} name The courses' name, this is a label.
 */

/**
 * @apiDefine CourseSuccess1.0.0
 * @apiSuccess (Success 2xx: Course) {Integer} id The numeric id assigned to the course by the database.
 * @apiSuccess (Success 2xx: Course) {Integer} department_id The id number assigned to the parent department by the database.
 * @apiSuccess (Success 2xx: Course) {String} code The courses' unique identifier string.
 * @apiSuccess (Success 2xx: Course) {Integer} course_level The academic level of a course.
 * @apiSuccess (Success 2xx: Course) {String} name The courses' name, this is a label.
 */

/**
 * @apiDefine AssignmentCourseUserParams1.0.0
 * @apiParam user_id {Integer} The database ID of the user.
 * @apiParam course_id {Integer} The database ID of the course.
 */

/**
 * @apiDefine AssignmentCourseUserIDParams
 * @apiParam identifier {String} The unique identifier string associated with a user.
 * @apiParam course_id {Integer} The database ID of the course.
 */

/**
 * @apiDefine AssignmentCourseUsernameIDParams
 * @apiParam username {String} The unique username string associated with a user.
 * @apiParam course_id {Integer} The database ID of the course.
 */

/**
 * @apiDefine AssignmentCourseCodeUserParams
 * @apiParam user_id {Integer} The database ID of the user
 * @apiParam course_code {String} The unique code string of the course.
 */

/**
 * @apiDefine AssignmentCourseCodeUserIDParams
 * @apiParam identifier {String} The unique identifier string associated with a user.
 * @apiParam course_code {String} The unique code string of the course.
 */

/**
 * @apiDefine AssignmentCourseCodeUsernameIDParams
 * @apiParam username {String} The unique username string associated with a user.
 * @apiParam course_code {String} The unique code string of the course.
 */

/**
 * @apiDefine GetCoursesSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": {
 *              "total_pages": 60,
 *              "current_page": 1,
 *              "result_limit": 5,
 *              "next_page": "api\/v1\/courses?limit=5&page=2",
 *              "previous_page": null
 *          },
 *          "result": [
 *              {
 *                  "id": 1,
 *                  "department_id": 37,
 *                  "code": "Quia.332",
 *                  "course_level": 100,
 *                  "name": "Officia consectetur velit laboriosam corrupti quis sed."
 *              },
 *              {
 *                  "id": 2,
 *                  "department_id": 84,
 *                  "code": "Et eum.348",
 *                  "course_level": 200,
 *                  "name": "Dolorem sint ea qui omnis quo illo necessitatibus."
 *              },
 *              {
 *                  "id": 3,
 *                  "department_id": 63,
 *                  "code": "Facere.570",
 *                  "course_level": 300,
 *                  "name": "Pariatur repudiandae delectus dignissimos qui eum quo maiores id."
 *              },
 *              {
 *                  "id": 4,
 *                  "department_id": 29,
 *                  "code": "Quasi.135",
 *                  "course_level": 100,
 *                  "name": "In possimus aspernatur dicta harum."
 *              },
 *              {
 *                  "id": 5,
 *                  "department_id": 36,
 *                  "code": "Est.120",
 *                  "course_level": 300,
 *                  "name": "Qui nisi recusandae eos ea soluta consequatur voluptatem."
 *              }
 *          ]
 *      }
 */

/**
 * @apiDefine GetCourseSuccessResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "id": 1,
 *              "department_id": 37,
 *              "code": "Quia.332",
 *              "course_level": 100,
 *              "name": "Officia consectetur velit laboriosam corrupti quis sed."
 *          }
 *      }
 */

/**
 * @apiDefine AssignPresentCourseResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "message": "Assignment Already Present",
 *              "id": {
 *                  "user": 20,
 *                  "course": 1
 *              }
 *          }
 *      }
 */

/**
 * @apiDefine AssignNewCourseResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "message": "Assigned",
 *              "id": {
 *                  "user": 20,
 *                  "course": 1
 *              }
 *          }
 *      }
 */

/**
 * @apiDefine AssignmentNotPresentCourseResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "message": "Assignment Not Present",
 *              "id": {
 *                  "user": 20,
 *                  "course": 1
 *              }
 *          }
 *      }
 */

/**
 * @apiDefine UnassignCourseResultExample
 * @apiSuccessExample {json} Success Response:
 *      HTTP/1.1 200 OK
 *      {
 *          "success": true,
 *          "status_code": 200,
 *          "pagination": [],
 *          "result": {
 *              "message": "Unassigned",
 *              "id": {
 *                  "user": 20,
 *                  "course": 1
 *              }
 *          }
 *      }
 */