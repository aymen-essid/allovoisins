Install Project
===============

1. Use the file user_table.sql
---------------------------------
2. use the file MOCK_DATA_USERS.sql ti insert dummy data.
---------------------------------
3. check apache rewrite_mod is enabled
---------------------------------





Endpoints
=========


1. Front routes
---------------------
$route['api/user/register']        

$route['api/user/profile/$id_user']


2. Private API routes
---------------------
$route['api/users/page/$id_page']['get']   

$route['api/user/detail/$id_user']['get']

$route['api/user/create']['post'] 

$route['api/user/update/$id_user']['put']

$route['api/user/delete/$id_user']['delete']

3. Cron Routes
---------------------
$route['cron/users/delete-inactive']



- **Endpoint**: `/api/users/page/($id_page)`
- **Method**: `GET`
- **Description**: Retrieve a list of all users.
- **Query Parameters**:
  - `id_page` (required, integer): Number of the page, and each page returns 10 results by default.

- **Response**:
  - **Status**: `200 OK`
  - **Body**::

    [
      {
        "id": 1,
        "firstName": "John",
        "lastName": "Doe",
        "email": "john.doe@example.com",
        "phone": "01234567890",
        "postalAddress": "123 Main St, Anytown, USA",
        "professionalStatus": "Engineer",
        "lastLogin": "2024-08-10T14:48:00Z"
      },
      ...
    ]

