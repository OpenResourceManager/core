# Re-Write ChangeLog

### Security
* Using JWT authentication.
* Using Entrust for `User` permissions.
* The `User` model is now used for authenticating with the API with JWT.
* Independent models like (`ssn`, `birth_date`, & `password`) have been removed. They are now classified properties of the `Account` model. Only `User` accounts authenticated with JWT with proper entrust permissions can see them.
* API rate limiting through laravel's built in middleware. This will prevent one client from hogging resources on the API.

### Logistical
* `User` model is now `Account` model.
* `Role` model is now `Duty` model.
* Model properties called `name` are now refereed to as `label`.
* Abstracting LDAP portion to a separate server.

### Features
* JWT Auth with Username/Password login (no more api keys!)
* API Manager front end
    * API user's can reset password and view request metrics.
* Broadcasting model events through Redis to event server. The event server will take care of 3rd party integrations like LDAP, Google, & WebHooks.
* Combined various routes. Example there is now only one route to delete a model. You can supply a code/identifier/username/id and it will be deleted. The same idea applies to model assignments. 

### Development
* Using Dingo API framework. Makes development easier and faster.
* Using  OpenAPI (FKA: Swagger) for API documentation. [The standard for API documentation.](http://swagger.io/introducing-the-open-api-initiative/)
* PHPUnit tests. Finally got this going!
    * All API routes are tested in CI.
* Moved to Laravel 5.3
* Travis CI integration. [Builds are here](https://travis-ci.org/SLERP-ERP/SLERP_Core).
* Hosting Project on GitHub & Private GitLab.

### Misc
* API conforms to [rfc6838 standards](https://tools.ietf.org/html/rfc6838)
* Changing the name of this project to SLERP... "Sage's Lean ERP" or "Super Lean ERP" or "Super Light ERP"... not sure what it sands for yet :-)
* Cleaned up a lot of code.
