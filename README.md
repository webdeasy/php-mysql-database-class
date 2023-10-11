## PHP Database Class
This is a simple PHP class to connect to a MySQL database and execute queries. It is a very simple class, but it is very useful for smaller projects.

## Requirements
- PHP > 7.0 needs to be installed on your server

## Basic Usage
To use the class, you first have to include the class file in your PHP file. You can do this by using the following code:
```php
require_once("Database.php");
```

After you have included the class file, you can create a new instance of the class. You can do this by using the following code:
```php
$db = new Database("localhost", "your-username", "your-password", "your-database");
```

Now you can execute queries. You can do this by using the following code:
```php
$result = $db->query("SELECT * FROM users WHERE id = ?", array(1));

while($row = mysqli_fetch_assoc($result)) {
  print_r($row);
}
```

The `query()` function returns a `mysqli_result` object. You can use all functions like `mysqli_fetch_assoc()` on this object.

## Functions
| Function                 | Description                                                                   | Parameters                         | Return Value           |
| ------------------------ | ----------------------------------------------------------------------------- | ---------------------------------- | ---------------------- |
| `open()`                 | Opens a connection to the database                                            |                                    |                        |
| `close()`                | Closes the connection to the database                                         |                                    |                        |
| `query()`                | Executes a query                                                              | `query` (string), `params` (array) | `mysqli_result` object |
| `get_affected_rows()`    | Returns the number of affected rows <br> (same as affected_rows and num_rows) |                                    | `int`                  |
| `get_last_inserted_id()` | Returns the last inserted ID                                                  |                                    | `int`                  |

## Examples and Details
Find a detailed documentation and some examples on my blog: https://webdeasy.de/en/php-mysql-database-class