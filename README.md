# ORM Core API

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/OpenResourceManager/core/master/LICENSE)
[![Build Status](https://travis-ci.org/OpenResourceManager/core.svg?branch=master)](https://travis-ci.org/OpenResourceManager/core)
[![GitHub issues](https://img.shields.io/github/issues/OpenResourceManager/core.svg)](https://github.com/OpenResourceManager/core/issues)
[![Documentation Status](https://readthedocs.org/projects/openresourcemanagercore/badge/?version=latest)](http://openresourcemanagercore.readthedocs.io/en/latest/?badge=latest)

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
* Interactive documentation using OpenAPI fka(Swagger)

# Documentation

For installation, update, and API spec documentation:

* [Read the docs here](https://openresourcemanagercore.readthedocs.io/en/latest/)

# Related Software

Some cool projects that this software relies on.

* [Laravel](https://laravel.com)
* [rappasoft/laravel-5-boilerplate](https://github.com/rappasoft/laravel-5-boilerplate)
* [dingo/api](https://github.com/dingo/api)
* [tymon/jwt-auth](https://github.com/tymon/jwt-auth)
* [simplesoftwareio/simple-sms](https://github.com/simplesoftwareio/simple-sms)
* [snowfire/beautymail](https://github.com/snowfire/beautymail)
* [edvinaskrucas/settings](https://github.com/edvinaskrucas/settings)
