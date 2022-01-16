<?php

/**
 * File Storage using JSON format.
 * Implement a file based, key - value storage.
 */
class FileStorage
{
	/**
	 * DB Container
	 * @var array
	 */
	private $_container = [];

	/**
	 * Database file location.
	 * @var null
	 */
	private $_file = null;

	/**
	 * Class constructor, triggered on class instantiation.
	 * @param string $file
	 */
	public function __construct($file)
	{
		if (file_exists($file)) {
			$this->_file = $file;
			$this->load();
		} else {
			throw new Exception('File doesn\'t exist');
		}
	}

	/**
	 * Class destructor, triggered when class no longer in use.
	 */
	public function __destruct()
	{
		$this->save();
	}

	/**
	 * Load container data from file.
	 * @param  string $file
	 * @return null
	 */
	private function load()
	{
		$this->_container = json_decode(file_get_contents($this->_file), true);
	}

	/**
	 * Save container data to file.
	 * @return null
	 */
	private function save()
	{
		file_put_contents($this->_file, json_encode($this->_container));
	}

	// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
	// :: Public Methods
	// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

	/**
	 * Set key - value entry to TinyJ
	 * @param  mixed $id
	 * @param  array  $element
	 * @return mixed
	 */
	public function set($id, $element)
	{
		$this->_container[$id] = $element;
		return $id;
	}

	/**
	 * Get data from TinyJ
	 * @param  string $query
	 * @return mixed
	 */
	public function get($query)
	{
		$segments = explode('.', $query);
		$data     = $this->_container;

		foreach($segments as $segment) {
			if(isset($data[$segment])) {
				$data = $data[$segment];
			} else {
				$data = false;
			}
		}
		return $data;
	}

	/**
	 * Remove key - value entry to TinyJ
	 * @param  mixed $id
	 * @return null
	 */
	public function del($id)
	{
		unset($this->_container[$id]);
	}

	/**
	 * Dump full database
	 * @return array
	 */
	public function dump()
	{
		return $this->_container;
	}
}