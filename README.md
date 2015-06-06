# Universal User Data Api

## Built with security in mind:

The UUD API is built around a model that requires applications to have a API access key, before they can access any data.

The API key also has a boolean value that determines if the application can write data to the API, otherwise it will have read only access.

## ToDo:

- [ ] Security
  - [X] Implement API key authorization.
  - [X] Create boolean for write access.
  - [ ] Lock down web directories/permissions.
- [ ] API R/O calls
  - [ ] Get user by ID
  - [ ] Get user by ID_Number
  - [ ] Get user by username
  - [ ] Get buiding by ID
  - [ ] Get building by datatel code
  - [ ] Get role by id
  - [ ] Get role by datatel code
  - [ ] Get campus by ID
  - [ ] Get campus by datatel code
- [ ] API Write calls
  - [ ] Update user by ID
  - [ ] Update user by ID_Number
  - [ ] Update user by username
- [ ] Documentation
  - [ ] Write inline documentation.
  - [ ] Use [APIDOC](http://apidocjs.com/) to generate the docs.