<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 12/30/15
 * Time: 12:04 PM
 */

/**
 * @apiDefine UserGroup
 *
 * @apiGroup Users
 */

/**
 * @api {get} /users/ Get: Request Users
 * @apiVersion 1.1.1
 * @apiUse AuthorizationHeader
 * @apiUse UserGroup
 * @apiUse Limit
 * @apiUse Page
 *
 */