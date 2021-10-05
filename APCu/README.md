### Lib
```php
require_once './SimpleAPCuCache.php';

$cache->set('age', 18);
$cache->get('age');

$cache->get('name', 'default name');

$cache->setMultiple(['age' =>  18, 'name' => 'Max']);
$cache->getMultiple(['age', 'name'], ['name' => 'default name']);
```

### SimpleCache [PSR-16](https://www.php-fig.org/psr/psr-16/) Methods
```txt
get($key, $default)
set($key, $value, $ttl = null)
delete($key)

getMultiple($keys, $default)
setMultiple($values, $ttl = null)
deleteMultiple($keys)

clear()
has($key)
```

### Direct APCu example usage
```php
$cacheKey = 'product_1';
$ttl = 600; // 10 minutes.

// Checking APCu availability
$isEnabled = apcu_enabled();

// Checks if there is data in the cache by key
$isExisted = apcu_exists($cacheKey);

// Saves data to the cache. Returns true if successful
// The $ttl argument determines how long the cache will be stored (seconds)
$isStored = apcu_store($cacheKey, ['name' => 'Demo product'], $ttl);

// Retrieves data from the cache by key. If not, returns false
$data = apcu_fetch($cacheKey);

// Deletes data from the cache by key
$isDeleted = apcu_delete($cacheKey);

var_dump([
    'is_enabled'   => $isEnabled,
    'is_existed'   => $isExisted,
    'is_stored'    => $isStored,
    'is_deleted'   => $isDeleted,
    'fetched_data' => $data,
]);
```

### Some good reads
- [Basics of PHP Caching](https://flaviocopes.com/php-caching/)
- [Boosting up PHP-project with cache](https://dev.to/he110/boosting-up-php-project-with-cache-16hi)
- [APC User Cache](https://www.php.net/manual/en/book.apcu.php)
- [How to monitor and tune APCu](https://anavarre.net/how-to-monitor-and-tune-apcu/)
