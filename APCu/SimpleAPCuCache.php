<?php

/**
 * Simple APCu cache wrapper.
 * Partial PSR-16 integration.
 */
class SimpleAPCuCache {
    const REGEX_VALID_KEY = '/^[a-zA-Z0-9\._]+$/';

    const ERROR_INVALID_STR = "ERROR_INVALID_STR";
    const ERROR_INVALID_LEN = "ERROR_INVALID_LEN";
    const ERROR_INVALID_KEY = "ERROR_INVALID_KEY";
    const ERROR_INVALID_ARR = "ERROR_INVALID_ARR";

    // ------------------------------------------------------------------------
    // Private validator & checks
    // ------------------------------------------------------------------------

    /**
     * Determines if an array is associative.
     * @param  array  $array
     * @return bool
     */
    private function _isAssoc(array $array) {
        $keys = array_keys($array);
        return array_keys($keys) !== $keys;
    }

    private function _validateKeyString($key) {
        if (! is_string($key)) {
            throw new Exception(self::ERROR_INVALID_STR);
        }

        $c = mb_strlen($key);
        if ($c < 1 || $c > 64) {
            throw new Exception(self::ERROR_INVALID_LEN);
        }

        if (! preg_match(self::REGEX_VALID_KEY, $key)) {
            throw new Exception(self::ERROR_INVALID_KEY);
        }

        return true;
    }

    private function _validateKeysArray($keys) {
        if (! is_array($keys)) {
            throw new Exception(self::ERROR_INVALID_ARR);
        }

        if ($this->_isAssoc($keys)) {
            foreach ($keys as $key => $val) {
                $this->_validateKeyString($key);
            }

        } else {
            foreach ($keys as $key) {
                $this->_validateKeyString($key);
            }
        }

        return true;
    }

    // ------------------------------------------------------------------------
    // Public
    // ------------------------------------------------------------------------

    public function set($key, $value, $ttl = null) {
        $this->_validateKeyString($key);
        return apcu_store($key, $value, $ttl);
    }

    public function get($key, $default = null) {
        $this->_validateKeyString($key);

        $result = apcu_fetch($key);
        return ($result == false) ? $default : $result;
    }

    public function delete($key) {
        $this->_validateKeyString($key);
        return apcu_delete($key);
    }

    public function has($key) {
        $this->_validateKeyString($key);
        return apcu_exists($key);
    }

    public function clear() {
        apcu_clear_cache();
    }

    public function getMultiple($keys, $default = null) {
        $this->_validateKeysArray($keys);
        $cache = apcu_fetch($keys);

        if (is_string($default)) {
            foreach ($keys as $key) {
                if (!isset($cache[$key])) $cache[$key] = $default;
            }
        }

        if (is_array($default)) {
            if ($this->_isAssoc($keys)) {
                foreach ($keys as $key => $val) {
                    if (!isset($cache[$key]) && isset($default[$key])) {
                        $cache[$key] = $default[$key];
                    }
                }

            } else {
                foreach ($keys as $key) {
                    if (!isset($cache[$key]) && isset($default[$key])) {
                        $cache[$key] = $default[$key];
                    }
                }
            }
        }

        return $cache;
    }

    public function setMultiple($values, $ttl = null) {
        $this->_validateKeysArray($values);
        $result = apcu_store($values, null, $ttl);

        if (is_array($result)) {
            $result = count($result) == 0; // if empty no errors
        }

        return $result;
    }

    public function deleteMultiple($keys) {
        $this->_validateKeysArray($keys);
        return apcu_delete($keys);
    }

    public function info() {
        return apcu_cache_info(true);
    }
}
