<?php

namespace Helpers;

/**
 * @author Tommy Vercety
 */
class Config {

	protected $_data;

	protected $_default = NULL;

	public function load($file)
	{
		if(is_string($file))
		{
			$info = pathinfo($file);
		}
		else
		{
			throw new \Exception('Parameter must be a sting.');
		}

		switch ($info['extension'])
		{
			case 'php':
				$this->_data = require($file);
				break;
			
			case 'json':
				$this->_data = json_decode(file_get_contents($file), TRUE);
				break;

			default:
				throw new \Exception('Unsupported file format.');
				break;
		}		
	}

	public function get($key, $default = NULL)
	{
		$this->_default = $default;

		$segments = explode('.', $key);
		$data = $this->_data;

		foreach($segments as $segment)
		{
			if(isset($data[$segment]))
			{
				$data = $data[$segment];
			}
			else
			{
				$data = $this->_default;
				break;
			}
		}

		return $data;
	}

	public function exists($key)
	{
		return $this->get($key) !== $this->_default;
	}
}
