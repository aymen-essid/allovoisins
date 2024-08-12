Authentication
==============

All endpoints require authentication via an API key. Include the API key in the request headers::

    Authorization: Bearer <API_KEY>

Endpoints
=========

1. Get All Users
----------------

- **Endpoint**: `/users`
- **Method**: `GET`
- **Description**: Retrieve a list of all users.
- **Query Parameters**:
  - `limit` (optional, integer): Number of users to return. Defaults to 10.
  - `offset` (optional, integer): Number of users to skip. Defaults to 0.

- **Response**:
  - **Status**: `200 OK`
  - **Body**::

    [
      {
        "id": 1,
        "firstName": "John",
        "lastName": "Doe",
        "email": "john.doe@example.com",
        "phone": "+1234567890",
        "postalAddress": "123 Main St, Anytown, USA",
        "professionalStatus": "Engineer",
        "lastLogin": "2024-08-10T14:48:00Z"
      },
      ...
    ]

2. Get a User by id
-------------------

- **Endpoint**: `/users/{id}`
- **Method**: `GET`
- **Description**: Retrieve information for a specific user by id.
- **Path Parameters**:
  - `id` (required, integer): The unique id of the user.

- **Response**:
  - **Status**: `200 OK`
  - **Body**::

    {
      "id": 1,
      "firstName": "John",
      "lastName": "Doe",
      "email": "john.doe@example.com",
      "phone": "+1234567890",
      "postalAddress": "123 Main St, Anytown, USA",
      "professionalStatus": "Engineer",
      "lastLogin": "2024-08-10T14:48:00Z"
    }

3. Create a New User
--------------------

- **Endpoint**: `/users`
- **Method**: `POST`
- **Description**: Create a new user.
- **Request Body**:
  - **Content-Type**: `application/json`
  - **Body**::

    {
      "firstName": "Jane",
      "lastName": "Doe",
      "email": "jane.doe@example.com",
      "phone": "+0987654321",
      "postalAddress": "456 Elm St, Anytown, USA",
      "professionalStatus": "Designer"
    }

- **Response**:
  - **Status**: `201 Created`
  - **Body**::

    {
      "id": 2,
      "firstName": "Jane",
      "lastName": "Doe",
      "email": "jane.doe@example.com",
      "phone": "+0987654321",
      "postalAddress": "456 Elm St, Anytown, USA",
      "professionalStatus": "Designer",
      "lastLogin": null
    }

4. Update a User
----------------

- **Endpoint**: `/users/{id}`
- **Method**: `PUT`
- **Description**: Update the information of an existing user.
- **Path Parameters**:
  - `id` (required, integer): The unique id of the user.

- **Request Body**:
  - **Content-Type**: `application/json`
  - **Body**::

    {
      "firstName": "Jane",
      "lastName": "Smith",
      "email": "jane.smith@example.com",
      "phone": "+0987654321",
      "postalAddress": "456 Elm St, Anytown, USA",
      "professionalStatus": "Senior Designer"
    }

- **Response**:
  - **Status**: `200 OK`
  - **Body**::

    {
      "id": 2,
      "firstName": "Jane",
      "lastName": "Smith",
      "email": "jane.smith@example.com",
      "phone": "+0987654321",
      "postalAddress": "456 Elm St, Anytown, USA",
      "professionalStatus": "Senior Designer",
      "lastLogin": "2024-08-11T09:00:00Z"
    }

5. Delete a User
----------------

- **Endpoint**: `/users/{id}`
- **Method**: `DELETE`
- **Description**: Delete a user by id.
- **Path Parameters**:
  - `id` (required, integer): The unique id of the user.

- **Response**:
  - **Status**: `204 No Content`

Error Handling
==============

- **400 Bad Request**: The request was invalid or cannot be otherwise served.
- **401 Unauthorized**: Authentication is required and has failed or has not been provided.
- **404 Not Found**: The requested resource could not be found.
- **500 Internal Server Error**: An unexpected error occurred on the server side.