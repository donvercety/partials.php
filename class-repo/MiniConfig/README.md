# php.class.MiniConfig

*original archived repository - [php.class.MiniConfig](https://github.com/donvercety/php.class.MiniConfig)*

Powerful And Easy Configuration with PHP

*"Configuration in a PHP application can be difficult to manage. Build your own configuration class that makes using configuration variables easy."*

Code inspired by [phpacademy](http://phpacademy.org)

Special thanks to Alex for the great tutorials.

There is always a good idea to have a separate configuration file for your php project, but not always maintaining it is so easy, as it is with this simple, but very powerful PHP class.

I took the idea that Alex did in his php tutorial [Powerful And Easy Configuration with PHP](https://youtu.be/qyKt4NF_82g), and extended it a little bit so it can also support JSON files.

## How to Use:

Just create a simple configuration file with PHP
```php
<?php

return [
	'db' => [
		'host' => [
			'local' => '127.0.0.1',
			'outer' => '91.92.160.133',
		],
		'port' => '3306',
		'user' => 'root',
		'pass' => 'qwerty',
	]
];
```

..or JSON.
```json
{
	"db": {
		"host": {
			"local": "127.0.0.1",
			"outer": "91.92.160.133"
		},
		"port": 3306,
		"user": "root",
		"pass": "qwerty"
	}
}
```

..and use Config.php like so:

```php
<?php

require 'Config.php';

$cfg = new Helpers\Config();
$cfg->load('conf.json');

var_dump($cfg->get('db.host.local'));
var_dump($cfg->get('db.port'));
var_dump($cfg->get('token'));
```

..easy stuff!
