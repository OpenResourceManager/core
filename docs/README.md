# ORM Core API

[![Build Status](https://travis-ci.org/OpenResourceManager/Core.svg?branch=master)](https://travis-ci.org/OpenResourceManager/Core)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Documentation Status](https://readthedocs.org/projects/openresourcemanagercore/badge/?version=latest)](http://openresourcemanagercore.readthedocs.io/en/latest/?badge=latest)

---

## About

ORM Core is a REST API designed to house institutional data and act as an intermediate between an existing ERP and an array of applications and systems.

##### Advantages
 
* Near real time data propagation:
    * Depending on the existing ERP, data can be sent to the core API on the fly as it receives new and updated data. From there any client applications that reefer to ORM are up to date and any aggregates that need to be sent information are sent data through Redis Channels. 
* Control:
    * The API manager allows you to view API clients. In a large environment this has huge benefits, since it can be very hard to keep track of various flat file feeds.
* Development:
    * The API interface eases the development of home grown programs and applications.
* Security:
    * Fine grained access and permissions can be configured.
    * JWT authentication allows for easy and secure development.
* Feedback:
    * API clients will be provided with detailed feedback which allows for error handling and error reporting on the client side as well as errors being log within ORM itself.

##### Features

* REST API interface
* API manager front end
* API manager admin back end
* API Accounts for different applications
* Account permissions and access control
* JWT authentication
* API rate limit/throttle
* API event history
* Log viewer
* Mobile Phone and Email verification
* API metrics and statistics
* API Event broadcast to event manager for 3rd party applications
* [Interactive documentation](https://demo-orm.sage.edu/api/documentation) using OpenAPI fka(Swagger)

## Requirements:

* php >= 7.0.0
* Redis
* MariaDB/MySQL (tested on MariaDB 10.1)
* [Yarn](https://yarnpkg.com/) -- For development*
* [composer](https://getcomposer.org/)
* NGINX or Apache (tested on NGINX)

PHP Packages:

* php-pecl-redis
* php-pdo
* php-mysqlnd
* php-mcrypt
* php-mbstring
* php-gd
* php-xml
* php-fpm (NGINX only)

### Installation

See the [installation docs](INSTALL.md)

### Update

See the [update docs](UPDATE.md)

### API Specification

See the [API spec](API_Specification.md)
