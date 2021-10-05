<?php
// All to work you must have APCu installed and enabled
// and 'zend.assertions = 1' in the php.ini file.
if (!apcu_enabled()) die('Enable APCu!');

require_once './SimpleAPCuCache.php';

header("Content-Type: text/plain");
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_QUIET_EVAL, 1);
assert_options(ASSERT_CALLBACK, 'assertHandler');

// Create a handler function
function assertHandler($file, $line, $code, $desc = null) {
    echo "Assertion failed at line $line ";
    if ($desc) echo "-- $desc";
    echo PHP_EOL;
}

echo '-- If you don\'t see anything below this, all tests have passed OK! --';
echo PHP_EOL . PHP_EOL;

$cache = new SimpleAPCuCache();

$minValidLen = '1';
$maxValidLen = '1234567890123456789012345678901234567890123456789012345678901234';  // 64
$aboveMaxLen = '12345678901234567890123456789012345678901234567890123456789012345'; // 65

// ----------------------------------------------------------------------------
// Assertions
// ----------------------------------------------------------------------------

try {
    // set
    assert($cache->set('sign.', '.', 60) == true, 'allowed sign .');
    assert($cache->set('sign_', '_', 60) == true, 'allowed sign _');

    assert($cache->set('123', 'number') == true, 'set() number string as a key');
    assert($cache->set('x', 'y') == true, 'set() x => y');
    assert($cache->set('age', 18) == true, 'set() int');
    assert($cache->set('name', 'John') == true, 'set() string');
    assert($cache->set($minValidLen, 'max-len') === true, 'set min valid len');
    assert($cache->set($maxValidLen, 'max-len') === true, 'set max valid len');

    // get
    assert($cache->get('age') == 18, 'get() int');
    assert($cache->get('missing', 'default_value') == 'default_value', 'get() default_value');

    // setMultiple
    assert($cache->setMultiple([]) == true, 'set multiple with empty array');
    assert($cache->setMultiple(['a' => 'a_val', 'b' => 'b_val']), 'set multiple');
    assert($cache->setMultiple(['a1' =>  1, 'b2' => 2]), 'set multiple');

    // getMultiple
    $getMany = $cache->getMultiple(['a', 'b', 'missing'], ['missing' => 'default_value']);
    assert(is_array($getMany) && count($getMany) == 3, 'get many in array with exact entries');

    $getMany = $cache->getMultiple([]);
    assert(is_array($getMany) && count($getMany) == 0, 'get many with empty array and exact count');

    $getMany = $cache->getMultiple(['x'], ['x' => 2, 'y' => 3]);
    assert(is_array($getMany) && count($getMany) == 1 && $getMany['x'] == 'y' && !isset($getMany['y']), 'testing default values power');

} catch (Exception $e) {
    die(var_dump($e));
}

try { $cache->set('ag!', 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_KEY', 'invalid key'); }
try { $cache->set('ag@', 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_KEY', 'invalid key'); }
try { $cache->set('ag#', 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_KEY', 'invalid key'); }
try { $cache->set('ag$', 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_KEY', 'invalid key'); }
try { $cache->set('ag%', 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_KEY', 'invalid key'); }
try { $cache->set('ag^', 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_KEY', 'invalid key'); }
try { $cache->set('ag&', 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_KEY', 'invalid key'); }
try { $cache->set('ag*', 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_KEY', 'invalid key'); }
try { $cache->set('ag(', 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_KEY', 'invalid key'); }
try { $cache->set('ag)', 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_KEY', 'invalid key'); }
try { $cache->set('ag-', 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_KEY', 'invalid key'); }
try { $cache->set('ag=', 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_KEY', 'invalid key'); }
try { $cache->set(' ', 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_KEY', 'invalid key'); }

try { $cache->set('', 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_LEN', 'invalid key'); }
try { $cache->get('', 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_LEN', 'invalid key'); }

try { $cache->set($aboveMaxLen, 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_LEN', 'set invalid key'); }
try { $cache->get($aboveMaxLen, 18); } catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_LEN', 'get invalid key'); }

try {
    $cache->set(123, 'number');
} catch (Exception $e) { assert($e->getMessage() === 'ERROR_INVALID_STR', 'set() number int as a key'); }


$cache->clear();

try {
    assert($cache->get('x') == false, 'after clear no value');
    assert($cache->get('age') == false, 'after clear no value');
    assert($cache->get('name', 'Max') === 'Max', 'after clear() default value');
} catch (Exception $e) {
    die(var_dump($e));
}

