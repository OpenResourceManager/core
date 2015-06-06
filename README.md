# Universal User Data Api

## Built with security in mind:

The UUD API is built around a model that requires applications to have a API access key, before they can access any data.

The API key also has a boolean value that determines if the application can write data to the API, otherwise it will have read only access.

## API Docs

Check out the [API documentation](https://databridge.sage.edu/docs/).

## ToDo:

- [ ] Security
  - [X] Implement API key authorization.
  - [X] Create boolean for write access.
  - [ ] Lock down web directories/permissions.
- [X] API R/O calls
  - [X] Get user by ID
  - [X] Get user by ID_Number
  - [X] Get user by username
  - [X] Get all users
  - [X] Get buiding by ID
  - [X] Get building by datatel code
  - [X] Get all buildings
  - [X] Get role by id
  - [X] Get role by datatel code
  - [X] Get all roles
  - [X] Get campus by ID
  - [X] Get campus by datatel code
  - [X] Get all campuses
- [ ] API Write calls
  - [ ] Update user by ID
  - [ ] Update user by ID_Number
  - [ ] Update user by username
- [X] Documentation
  - [X] Write inline documentation.
  - [X] Use [APIDOC](http://apidocjs.com/) to generate the docs.