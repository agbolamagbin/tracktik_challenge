## TrackTik Employee Integration API

This API receives employee data from two different identity providers, processes it, and sends it to TrackTik's REST API.

## Setup

1. Clone the repository.
2. Run `composer install`.
3. Copy `.env.example` to `.env` and update with your credentials.

**Ensure to update the following credentials in your `.env` file:**

* `TRACKTIK_CLIENT_ID`
* `TRACKTIK_CLIENT_SECRET`
* `TRACKTIK_USERNAME`
* `TRACKTIK_PASSWORD`

4. Serve the application using `php artisan serve`.

## Endpoints

- **Provider 1**
  - `POST /api/provider1/employees` - Create a new employee from Provider 1.
  - `PUT /api/provider1/employees/{id}` - Update an existing employee from Provider 1.

- **Provider 2**
  - `POST /api/provider2/employees` - Create a new employee from Provider 2.
  - `PUT /api/provider2/employees/{id}` - Update an existing employee from Provider 2.

## Example Payloads

**Provider 1**

**Required Parameters:**

* `first_name` (string): The employee's first name.
* `last_name` (string): The employee's last name.

**Optional Parameters:**

* `email_address` (email): The employee's email address.
* `occupation` (string): The employee's occupation.

**Example Request (Create Employee):**

```json
{
  "first_name": "John",
  "last_name": "Doe",
  "email_address": "john.doe@example.com",
  "occupation": "Software Engineer"
}
```

**Provider 2**

**Required Parameters:**

* `givenName` (string): The employee's given name (first name).
* `surname` (string): The employee's surname (last name).

**Optional Parameters:**

* `contactEmail` (email): The employee's contact email address.
* `position` (string): The employee's position (occupation).

**Example Request (Create Employee):**

```json
{
  "givenName": "Jane",
  "surname": "Smith",
  "contactEmail": "jane.smith@example.com",
  "position": "Marketing Manager"
}
```

## Error Response

If there are any validation errors in the request payload, the API will return a JSON response with the following format:

```json
{
  "message": "Validation failed",
  "errors": {
    "field_name": "error message 1, error message 2"
  }
}
```

## Testing

Run tests with `php artisan test`.#   t r a c k t i k _ c h a l l e n g e  
 