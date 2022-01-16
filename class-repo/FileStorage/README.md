# php.class.FileStorage v1.0

*original archived repository - [php.class.FileStorage](https://github.com/donvercety/php.class.FileStorage)*

File based, key - value storage.

Instantiate the class with an __already existing__ json file.

```php
<?php

require __DIR__ . '/lib/FileStorage.php';

try {
	$db = new FileStorage(__DIR__ . '/db.json');

} catch (Exception $ex) {
	die(var_dump($ex->getMessage()));
}
```

Afterwards use the 3 simple methods: `set`, `get` and `del`

```php
<?php

$db->set("something", [
	"foo" => "bar"
]);

$db->set("admin", [
	"name"  => "Tommy Vercety",
	"pass"  => "098f6bcd4621d373cade4e832627b4f6",
	"email" => "test@test.com"
]);

$name = $db->get("admin");      // this will work
$name = $db->get("admin.name"); // this will work

$db->del("something");   // this will work
$db->del("admin.pass");  // this won't work

```

This will save the data in a json encoded string in the given file. Like so:

```json
{"something":{"key":"value"},"admin":{"name":"Tommy Vercety","pass":"098f6bcd4621d373cade4e832627b4f6","email":"test@test.com"}}
```

__Note__: `set` and `del` only works with the first level of the array/object. If you want to update or remove some inner level stuff, just use `get` and update/delete it as a normal php array. The class uses the `__construct` method to load the data into a php array and the `__destruct` method to save it back to the file. This means that the data is saved on the file when the php script is finished running.
