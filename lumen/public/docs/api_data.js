define({ "api": [  {    "type": "post",    "url": "/building",    "title": "Post to Building",    "version": "1.1.1",    "header": {      "fields": {        "Header": [          {            "group": "Header",            "type": "String",            "optional": false,            "field": "X-Authorization",            "description": "<p>The application's unique access-key.</p> "          }        ]      }    },    "group": "Buildings",    "description": "<p>An application can create new building record or update existing records. If the Informer code does not exist in the database, the rest of the data sent in the POST request will be treated as a new entry. If the Informer code does exist in the database, the data sent in the POST request will replace the data in that record.</p> ",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "<p>Integer</p> ",            "optional": false,            "field": "campus",            "description": "<p>The numeric id of a campus.</p> "          },          {            "group": "Parameter",            "type": "<p>String</p> ",            "optional": false,            "field": "name",            "description": "<p>The name of the building.</p> "          },          {            "group": "Parameter",            "type": "<p>String</p> ",            "optional": false,            "field": "code",            "description": "<p>The code assigned by Informer.</p> "          }        ]      }    },    "success": {      "fields": {        "Success 200": [          {            "group": "Success 200",            "type": "<p>Boolean</p> ",            "optional": false,            "field": "success",            "description": "<p>Tells the application if the request was successful.</p> "          },          {            "group": "Success 200",            "type": "<p>String</p> ",            "optional": false,            "field": "result",            "description": "<p>The action that was performed. This may be <code>update</code> or <code>create</code>.</p> "          }        ]      },      "examples": [        {          "title": "Success Create Response:",          "content": "HTTP/1.1 200 OK\n{\n     \"success\": true,\n     \"result\": \"create\"\n}",          "type": "json"        },        {          "title": "Success Update Response:",          "content": "HTTP/1.1 200 OK\n{\n     \"success\": true,\n     \"result\": \"update\"\n}",          "type": "json"        }      ]    },    "examples": [      {        "title": "Curl",        "content": "curl -H \"X-Authorization: <Your-API-Key>\" \\\n--data \"campus=1\" \\\n--data \"name=Ackerman\" \\\n--data \"code=ACK\" \\\n--url https://databridge.sage.edu/v1/building",        "type": "curl"      },      {        "title": "Ruby",        "content": "# This code snippet uses an open-source library. http://unirest.io/ruby\nresponse = Unirest.get \"https://databridge.sage.edu/v1/building\",\nheaders:{ \"X-Authorization\" => \"<Your-API-Key>\", \"Accept\" => \"application/json\" },\nparameters:{ :campus => 1, :name => \"Ackerman\", :code => \"ACK\"}.to_json",        "type": "ruby"      },      {        "title": "PHP",        "content": "$ch = curl_init(\"https://databridge.sage.edu/v1/building\");\ncurl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Authorization: <Your-API-Key>', 'Accept: application/json'));\ncurl_setopt($ch, CURLOPT_RETURNTRANSFER, true);\ncurl_setopt($ch, CURLOPT_POST, true);\ncurl_setopt($ch, CURLOPT_POSTFIELDS, array(\"campus\" => 1, \"name\" => \"Ackerman\", \"code\" => \"ACK\"));\n$result = curl_exec($ch);\ncurl_close($ch);",        "type": "php"      },      {        "title": "PowerShell",        "content": "# PowerShell v3 and above\n$headers = New-Object \"System.Collections.Generic.Dictionary[[String],[String]]\"\n$headers.Add(\"X-Authorization\", '<Your-API-Key>')\n$uri = https://databridge.sage.edu/v1/building\n$body = @{ campus = 1, name = \"Ackerman\", code = \"ACK\" }\n$result = Invoke-RestMethod -Uri $uri -Headers $headers -Method Post -Body $body",        "type": "powershell"      },      {        "title": "Java",        "content": "# This code snippet uses an open-source library. http://unirest.io/java\nHttpResponse <String> response = Unirest.get(\"https://databridge.sage.edu/v1/building\")\n.header(\"X-Authorization\", \"<Your-API-Key>\")\n.header(\"Accept\", \"application/json\")\n.body(\"{\\\"campus\\\":1, \\\"name\\\":\\\"Ackerman\\\", \\\"code\\\":\\\"ACK\\\"}\")\n.asString();",        "type": "java"      },      {        "title": "Python",        "content": "# This code snippet uses an open-source library http://unirest.io/python\nresponse = unirest.post(\"https://databridge.sage.edu/v1/building\",\n    headers={\n        \"X-Authorization\": \"<Your-API-Key>\",\n        \"Accept\": \"application/json\"\n    },\n    params={\n        \"campus\" : 1,\n        \"name\": \"Ackerman\",\n        \"code\": \"ACK\"\n    }\n)",        "type": "python"      },      {        "title": ".NET",        "content": "// This code snippet uses an open-source library http://unirest.io/net\n Task<HttpResponse<MyClass>> response = Unirest.post(\"https://databridge.sage.edu/v1/building\")\n .header(\"X-Authorization\", \"<Your-API-Key>\")\n .header(\"Accept\", \"application/json\")\n .field(\"campus\", 1)\n .field(\"name\", \"Ackerman\")\n .field(\"code\", \"ACK\")\n .asString();",        "type": ".net"      }    ],    "error": {      "fields": {        "Error 4xx": [          {            "group": "Error 4xx",            "type": "<p>Boolean</p> ",            "optional": false,            "field": "success",            "description": "<p>Tells the application if the request was successful.</p> "          },          {            "group": "Error 4xx",            "type": "<p>String</p> ",            "optional": false,            "field": "error",            "description": "<p>An error message from the server.</p> "          }        ],        "Error 5xx": [          {            "group": "Error 5xx",            "type": "<p>Boolean</p> ",            "optional": false,            "field": "success",            "description": "<p>Tells the application if the request was successful.</p> "          },          {            "group": "Error 5xx",            "type": "<p>String</p> ",            "optional": false,            "field": "error",            "description": "<p>An error message from the server.</p> "          }        ]      },      "examples": [        {          "title": "Error: Not Privileged",          "content": "HTTP/1.1 403 Forbidden\n{\n    \"success\": false,\n    \"error\": \"X-Authorization: Insufficient privileges.\"\n}",          "type": "json"        },        {          "title": "Error: Invalid API Key",          "content": "HTTP/1.1 403 Forbidden\n{\n    \"success\": false,\n    \"error\": \"X-Authorization: API Key is not valid.\"\n}",          "type": "json"        },        {          "title": "Error: Method not found",          "content": "HTTP/1.1 400 Bad Request\n{\n    \"success\": false,\n    \"error\": \"Method not found.\"\n}",          "type": "json"        },        {          "title": "Error: Missing Header Option",          "content": "HTTP/1.1 400 Bad Request\n{\n    \"success\": false,\n    \"error\": \"X-Authorization: Header Option Not Found.\"\n}",          "type": "json"        },        {          "title": "Error: Server Error",          "content": "HTTP/1.1 500 Server Error\n{\n    \"success\": false,\n    \"error\": \"Could not update.\"\n}",          "type": "json"        }      ]    },    "filename": "lumen/app/Http/Controllers/BuildingController.php",    "groupTitle": "Buildings",    "name": "PostBuilding"  }] });