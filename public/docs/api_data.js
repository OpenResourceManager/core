define({ "api": [  {    "type": "get",    "url": "/users/",    "title": "GET: Request Users",    "version": "1.1.1",    "group": "Users",    "description": "<p>This method returns pages of User objects.</p>",    "examples": [      {        "title": "Curl",        "content": "curl -H \"X-Authorization: <Your-API-Key>\" --url https://databridge.sage.edu/api/v1/users/",        "type": "curl"      }    ],    "filename": "app/Http/Controllers/doc/users.doc.php",    "groupTitle": "Users",    "name": "GetUsers",    "sampleRequest": [      {        "url": "https://databridge.sage.edu/api/v1/users/"      }    ],    "header": {      "fields": {        "Header": [          {            "group": "Header",            "type": "String",            "optional": false,            "field": "X-Authorization",            "description": "<p>The application's unique access-key.</p>"          }        ]      }    },    "error": {      "examples": [        {          "title": "Error: Missing Header Option",          "content": "HTTP/1.1 400 Bad Request\n{\n    \"success\": false,\n    \"error\": \"X-Authorization: Header Option Not Found.\"\n}",          "type": "json"        },        {          "title": "Error: Not Privileged",          "content": "HTTP/1.1 403 Forbidden\n{\n    \"success\": false,\n    \"error\": \"X-Authorization: Insufficient privileges.\"\n}",          "type": "json"        },        {          "title": "Error: Invalid API Key",          "content": "HTTP/1.1 403 Forbidden\n{\n    \"success\": false,\n    \"error\": \"X-Authorization: API Key is not valid.\"\n}",          "type": "json"        }      ]    },    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "Integer",            "optional": true,            "field": "limit",            "defaultValue": "25",            "description": "<p>The max number of objects returned. The max that will be honored by the api is 100.</p>"          },          {            "group": "Parameter",            "type": "Integer",            "optional": true,            "field": "page",            "defaultValue": "1",            "description": "<p>The page of results to return.</p>"          }        ]      }    },    "success": {      "fields": {        "Success 200": [          {            "group": "Success 200",            "type": "Object",            "optional": false,            "field": "pagination",            "description": "<p>A key to reference for paginated results.</p>"          },          {            "group": "Success 200",            "type": "Boolean",            "optional": false,            "field": "success",            "description": "<p>Tells the application if the request was successful.</p>"          },          {            "group": "Success 200",            "type": "Integer",            "optional": false,            "field": "status_code",            "description": "<p>The HTTP status code of the request, this is also available in the header.</p>"          },          {            "group": "Success 200",            "type": "Object[]",            "optional": false,            "field": "result",            "description": "<p>An array of User objects.</p>"          }        ],        "Pagination": [          {            "group": "Pagination",            "type": "Integer",            "optional": false,            "field": "total_pages",            "description": "<p>The total number of pages available.</p>"          },          {            "group": "Pagination",            "type": "Integer",            "optional": false,            "field": "current_page",            "description": "<p>The currently selected page.</p>"          },          {            "group": "Pagination",            "type": "Integer",            "optional": false,            "field": "result_limit",            "description": "<p>The max amount of results returned per request.</p>"          },          {            "group": "Pagination",            "type": "String",            "optional": false,            "field": "next_page",            "description": "<p>The next page available in url form.</p>"          },          {            "group": "Pagination",            "type": "String",            "optional": false,            "field": "previous_page",            "description": "<p>The previous page in url form.</p>"          }        ],        "User": [          {            "group": "User",            "type": "Integer",            "optional": false,            "field": "id",            "description": "<p>The numeric id assigned to the user by the database.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "user_identifier",            "description": "<p>The user's unique identifier string.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "username",            "description": "<p>The user's username string.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_prefix",            "description": "<p>The user's name prefix, if there is one.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_first",            "description": "<p>The user's fist name.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_middle",            "description": "<p>The user's middle name or initial, if there is one.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_last",            "description": "<p>The user's last name.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_postfix",            "description": "<p>The user's name postfix, if there is one.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_phonetic",            "description": "<p>The user's phonetic name, if there is one.</p>"          }        ]      },      "examples": [        {          "title": "Success Response:",          "content": "HTTP/1.1 200 OK\n{\n    \"success\": true,\n    \"status_code\": 200,\n    \"pagination\": {\n        \"total_pages\": 30,\n        \"current_page\": 1,\n        \"result_limit\": 5,\n        \"next_page\": \"api\\/v1\\/users?limit=5&page=2\",\n        \"previous_page\": null\n    },\n    \"result\": [\n        {\n            \"id\": 1,\n            \"user_identifier\": \"6223406\",\n            \"username\": \"Caitlyn62\",\n            \"name_prefix\": \"Ms.\",\n            \"name_first\": \"Robb\",\n            \"name_middle\": \"Irwin\",\n            \"name_last\": \"Fritsch\",\n            \"name_postfix\": \"Dr.\",\n            \"name_phonetic\": null\n        },\n        {\n            \"id\": 2,\n            \"user_identifier\": \"4027012\",\n            \"username\": \"Manley.Hirthe\",\n            \"name_prefix\": \"Mr.\",\n            \"name_first\": \"Eunice\",\n            \"name_middle\": \"Reva\",\n            \"name_last\": \"Pfeffer\",\n            \"name_postfix\": \"Dr.\",\n            \"name_phonetic\": null\n        },\n        {\n            \"id\": 3,\n            \"user_identifier\": \"2892039\",\n            \"username\": \"Tess39\",\n            \"name_prefix\": \"Ms.\",\n            \"name_first\": \"Franco\",\n            \"name_middle\": null,\n            \"name_last\": \"Kirlin\",\n            \"name_postfix\": \"Mr.\",\n            \"name_phonetic\": \"Jerald\"\n        },\n        {\n            \"id\": 4,\n            \"user_identifier\": \"9901344\",\n            \"username\": \"Sauer.Eulalia\",\n            \"name_prefix\": null,\n            \"name_first\": \"Karianne\",\n            \"name_middle\": \"Mollie\",\n            \"name_last\": \"Aufderhar\",\n            \"name_postfix\": \"Prof.\",\n            \"name_phonetic\": \"Shanna\"\n        },\n        {\n            \"id\": 5,\n            \"user_identifier\": \"4619979\",\n            \"username\": \"Lang.Sydnee\",\n            \"name_prefix\": null,\n            \"name_first\": \"Leopold\",\n            \"name_middle\": \"Nicholaus\",\n            \"name_last\": \"Lesch\",\n            \"name_postfix\": \"Dr.\",\n            \"name_phonetic\": \"Emanuel\"\n        }\n    ]\n}",          "type": "json"        }      ]    }  },  {    "type": "get",    "url": "/users/:id",    "title": "GET: Request User",    "version": "1.1.1",    "group": "Users",    "description": "<p>This method returns a User object, an id is supplied to the API.</p>",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "Integer",            "optional": false,            "field": "id",            "description": "<p>The users unique ID.</p>"          }        ]      }    },    "examples": [      {        "title": "Curl",        "content": "curl -H \"X-Authorization: <Your-API-Key>\" --url https://databridge.sage.edu/api/v1/users/1",        "type": "curl"      }    ],    "success": {      "fields": {        "Success 200": [          {            "group": "Success 200",            "type": "Object",            "optional": false,            "field": "pagination",            "description": "<p>Will be null, there can only be one user returned.</p>"          },          {            "group": "Success 200",            "type": "Object",            "optional": false,            "field": "result",            "description": "<p>The User object.</p>"          }        ],        "User": [          {            "group": "User",            "type": "Integer",            "optional": false,            "field": "id",            "description": "<p>The numeric id assigned to the user by the database.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "user_identifier",            "description": "<p>The user's unique identifier string.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "username",            "description": "<p>The user's username string.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_prefix",            "description": "<p>The user's name prefix, if there is one.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_first",            "description": "<p>The user's fist name.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_middle",            "description": "<p>The user's middle name or initial, if there is one.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_last",            "description": "<p>The user's last name.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_postfix",            "description": "<p>The user's name postfix, if there is one.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_phonetic",            "description": "<p>The user's phonetic name, if there is one.</p>"          }        ]      },      "examples": [        {          "title": "Success Response:",          "content": "HTTP/1.1 200 OK\n{\n    \"success\": true,\n    \"status_code\": 200,\n    \"pagination\": [],\n    \"result\": {\n        \"id\": 1,\n        \"user_identifier\": \"6223406\",\n        \"username\": \"Caitlyn62\",\n        \"name_prefix\": \"Ms.\",\n        \"name_first\": \"Robb\",\n        \"name_middle\": \"Irwin\",\n        \"name_last\": \"Fritsch\",\n        \"name_postfix\": \"Dr.\",\n        \"name_phonetic\": null\n    }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/doc/users.doc.php",    "groupTitle": "Users",    "name": "GetUsersId",    "sampleRequest": [      {        "url": "https://databridge.sage.edu/api/v1/users/:id"      }    ],    "header": {      "fields": {        "Header": [          {            "group": "Header",            "type": "String",            "optional": false,            "field": "X-Authorization",            "description": "<p>The application's unique access-key.</p>"          }        ]      }    },    "error": {      "examples": [        {          "title": "Error: Missing Header Option",          "content": "HTTP/1.1 400 Bad Request\n{\n    \"success\": false,\n    \"error\": \"X-Authorization: Header Option Not Found.\"\n}",          "type": "json"        },        {          "title": "Error: Not Privileged",          "content": "HTTP/1.1 403 Forbidden\n{\n    \"success\": false,\n    \"error\": \"X-Authorization: Insufficient privileges.\"\n}",          "type": "json"        },        {          "title": "Error: Invalid API Key",          "content": "HTTP/1.1 403 Forbidden\n{\n    \"success\": false,\n    \"error\": \"X-Authorization: API Key is not valid.\"\n}",          "type": "json"        },        {          "title": "Error: Not Found",          "content": "HTTP/1.1 404 Not Found\n{\n    \"success\": false,\n    \"status_code\": 404,\n    \"error\": \"No query results for model.\"\n}",          "type": "json"        }      ]    }  },  {    "type": "get",    "url": "/users/user_id/:user_id",    "title": "GET: Request User via Identifier",    "version": "1.1.1",    "group": "Users",    "description": "<p>This method returns a User object, a user_id is supplied to the API.</p>",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "user_id",            "description": "<p>The user's unique identifier string.</p>"          }        ]      }    },    "examples": [      {        "title": "Curl",        "content": "curl -H \"X-Authorization: <Your-API-Key>\" --url https://databridge.sage.edu/api/v1/users/user_id/6223406",        "type": "curl"      }    ],    "success": {      "fields": {        "Success 200": [          {            "group": "Success 200",            "type": "Object",            "optional": false,            "field": "pagination",            "description": "<p>Will be null, there can only be one user returned.</p>"          },          {            "group": "Success 200",            "type": "Object",            "optional": false,            "field": "result",            "description": "<p>The User object.</p>"          }        ],        "User": [          {            "group": "User",            "type": "Integer",            "optional": false,            "field": "id",            "description": "<p>The numeric id assigned to the user by the database.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "user_identifier",            "description": "<p>The user's unique identifier string.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "username",            "description": "<p>The user's username string.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_prefix",            "description": "<p>The user's name prefix, if there is one.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_first",            "description": "<p>The user's fist name.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_middle",            "description": "<p>The user's middle name or initial, if there is one.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_last",            "description": "<p>The user's last name.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_postfix",            "description": "<p>The user's name postfix, if there is one.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_phonetic",            "description": "<p>The user's phonetic name, if there is one.</p>"          }        ]      },      "examples": [        {          "title": "Success Response:",          "content": "HTTP/1.1 200 OK\n{\n    \"success\": true,\n    \"status_code\": 200,\n    \"pagination\": [],\n    \"result\": {\n        \"id\": 1,\n        \"user_identifier\": \"6223406\",\n        \"username\": \"Caitlyn62\",\n        \"name_prefix\": \"Ms.\",\n        \"name_first\": \"Robb\",\n        \"name_middle\": \"Irwin\",\n        \"name_last\": \"Fritsch\",\n        \"name_postfix\": \"Dr.\",\n        \"name_phonetic\": null\n    }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/doc/users.doc.php",    "groupTitle": "Users",    "name": "GetUsersUser_idUser_id",    "sampleRequest": [      {        "url": "https://databridge.sage.edu/api/v1/users/user_id/:user_id"      }    ],    "header": {      "fields": {        "Header": [          {            "group": "Header",            "type": "String",            "optional": false,            "field": "X-Authorization",            "description": "<p>The application's unique access-key.</p>"          }        ]      }    },    "error": {      "examples": [        {          "title": "Error: Missing Header Option",          "content": "HTTP/1.1 400 Bad Request\n{\n    \"success\": false,\n    \"error\": \"X-Authorization: Header Option Not Found.\"\n}",          "type": "json"        },        {          "title": "Error: Not Privileged",          "content": "HTTP/1.1 403 Forbidden\n{\n    \"success\": false,\n    \"error\": \"X-Authorization: Insufficient privileges.\"\n}",          "type": "json"        },        {          "title": "Error: Invalid API Key",          "content": "HTTP/1.1 403 Forbidden\n{\n    \"success\": false,\n    \"error\": \"X-Authorization: API Key is not valid.\"\n}",          "type": "json"        },        {          "title": "Error: Not Found",          "content": "HTTP/1.1 404 Not Found\n{\n    \"success\": false,\n    \"status_code\": 404,\n    \"error\": \"No query results for model.\"\n}",          "type": "json"        }      ]    }  },  {    "type": "get",    "url": "/users/username/:username",    "title": "GET: Request User via Username",    "version": "1.1.1",    "group": "Users",    "description": "<p>This method returns a User object, a username is supplied to the API.</p>",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "username",            "description": "<p>The users unique username.</p>"          }        ]      }    },    "examples": [      {        "title": "Curl",        "content": "curl -H \"X-Authorization: <Your-API-Key>\" --url https://databridge.sage.edu/api/v1/users/username/Caitlyn62",        "type": "curl"      }    ],    "success": {      "fields": {        "Success 200": [          {            "group": "Success 200",            "type": "Object",            "optional": false,            "field": "pagination",            "description": "<p>Will be null, there can only be one user returned.</p>"          },          {            "group": "Success 200",            "type": "Object",            "optional": false,            "field": "result",            "description": "<p>The User object.</p>"          }        ],        "User": [          {            "group": "User",            "type": "Integer",            "optional": false,            "field": "id",            "description": "<p>The numeric id assigned to the user by the database.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "user_identifier",            "description": "<p>The user's unique identifier string.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "username",            "description": "<p>The user's username string.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_prefix",            "description": "<p>The user's name prefix, if there is one.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_first",            "description": "<p>The user's fist name.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_middle",            "description": "<p>The user's middle name or initial, if there is one.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_last",            "description": "<p>The user's last name.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_postfix",            "description": "<p>The user's name postfix, if there is one.</p>"          },          {            "group": "User",            "type": "String",            "optional": false,            "field": "name_phonetic",            "description": "<p>The user's phonetic name, if there is one.</p>"          }        ]      },      "examples": [        {          "title": "Success Response:",          "content": "HTTP/1.1 200 OK\n{\n    \"success\": true,\n    \"status_code\": 200,\n    \"pagination\": [],\n    \"result\": {\n        \"id\": 1,\n        \"user_identifier\": \"6223406\",\n        \"username\": \"Caitlyn62\",\n        \"name_prefix\": \"Ms.\",\n        \"name_first\": \"Robb\",\n        \"name_middle\": \"Irwin\",\n        \"name_last\": \"Fritsch\",\n        \"name_postfix\": \"Dr.\",\n        \"name_phonetic\": null\n    }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/doc/users.doc.php",    "groupTitle": "Users",    "name": "GetUsersUsernameUsername",    "sampleRequest": [      {        "url": "https://databridge.sage.edu/api/v1/users/username/:username"      }    ],    "header": {      "fields": {        "Header": [          {            "group": "Header",            "type": "String",            "optional": false,            "field": "X-Authorization",            "description": "<p>The application's unique access-key.</p>"          }        ]      }    },    "error": {      "examples": [        {          "title": "Error: Missing Header Option",          "content": "HTTP/1.1 400 Bad Request\n{\n    \"success\": false,\n    \"error\": \"X-Authorization: Header Option Not Found.\"\n}",          "type": "json"        },        {          "title": "Error: Not Privileged",          "content": "HTTP/1.1 403 Forbidden\n{\n    \"success\": false,\n    \"error\": \"X-Authorization: Insufficient privileges.\"\n}",          "type": "json"        },        {          "title": "Error: Invalid API Key",          "content": "HTTP/1.1 403 Forbidden\n{\n    \"success\": false,\n    \"error\": \"X-Authorization: API Key is not valid.\"\n}",          "type": "json"        },        {          "title": "Error: Not Found",          "content": "HTTP/1.1 404 Not Found\n{\n    \"success\": false,\n    \"status_code\": 404,\n    \"error\": \"No query results for model.\"\n}",          "type": "json"        }      ]    }  }] });
