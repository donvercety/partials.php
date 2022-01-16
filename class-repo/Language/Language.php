<?php

/**
 * PHP Simple Language Class
 * v.1.0
 * @author Tommy Vercety
 */
class Language {

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// :: Private Parameters
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	/**
	 * Holds the language array data, loaded form a file
	 * @var array
	 */
	private $_data;

	/**
	 * Holds the location of the language file
	 * @var string
	 */
	private $_location;

	/**
	 * Holds the supported language types
	 * @var array
	 */
	
	private $_language;

	/**
	 * Holds the current language in use
	 * @var integer
	 */
	private $_lang = 0;

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// :: Public Parameters
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	/**
	 * Open and Close tag for html table element
	 * @var array
	 */
	public $table = [
		"open"  => "<table>",
		"close" => "</table>",
	];

	/**
	 * Open and Close tag for table row
	 * @var array
	 */
	public $tr = [
		"open"  => "<tr>",
		"close" => "</rt>",
	];

	/**
	 * Open and Close tag for table heading
	 * @var array
	 */
	public $th = [
		"open"  => "<th>",
		"close" => "</th>",
	];

	/**
	 * Open and Close tag for table data
	 * @var array
	 */
	public $td = [
		"open"  => "<td>",
		"close" => "</td>",
	];

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// :: Constructor
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	/**
	 * Use the constructor to set the desired languages,
	 * and to preload the data file.
	 * 
	 * @param array  $lang [used languages]
	 * @param string $data [file location]
	 */
	public function __construct($lang = [], $data = NULL) {
		if (isset($lang) && is_array($lang)) {
			$this->setLanguages($lang);

			if ($data !== NULL && is_string($data)) {
				$this->loadData($data);
			}
		}
	}

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// :: Language
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	/**
	 * Set desired languages
	 * @param array $lang [description]
	 */
	public function setLanguages($lang) {
		$this->_language = $lang;
	}

	/**
	 * Choose the language to use
	 * @param  string $lang [used languages]
	 */
	public function chooseLanguage($lang) {
		$this->_lang = $this->_language[$lang];
	}

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// :: Language Data
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	/**
	 * Load file with language content
	 * @param  string $location [file location]
	 */
	public function loadData($location) {
		$this->_location = $location;
		$data = file($this->_location, FILE_IGNORE_NEW_LINES);

		$arr = []; $key; $val;

		foreach ($data as $value) {
			$key = explode(":", $value);
			$val = explode(",", $key[1]);

			$arr[$key[0]] = $val;
		}

		$this->_data = $arr;
	}

	/**
	 * Save content to file, used when changing language settings.
	 * @param  string $location [file location]
	 */
	public function saveData($location) {

		if (!isset($location)) {
			return FALSE;
		}

		file_put_contents($location, "");
		foreach ($this->_data as $key => $val) {
			file_put_contents($location, $key . ":" . implode(",", $val) . PHP_EOL, FILE_APPEND);
		}
	}

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// :: Language Data Interactions
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	/**
	 * Get all language data
	 * @return array
	 */
	public function getAllData() {
		return $this->_data;
	}

	/**
	 * Get specific key from language data
	 * @param  string $key
	 * @return string
	 */
	public function getData($key) {
		return $this->_data[$key][$this->_lang];
	}

	/**
	 * Add entry to language data
	 * @param string $key
	 * @param string $val [coma separated language variables]
	 */
	public function setData($key, $val) {
		$this->_data[$key] = explode(",", $val);
	}

	/**
	 * Remove entry from language data
	 * @param  string $key
	 */
	public function delData($key) {
		unset($this->_data[$key]);
	}

	public function sortDataAlphabetically($sort = true) {
		($sort) ? ksort($this->_data, SORT_STRING) : krsort($this->_data, SORT_STRING);
	}

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// :: Helpers
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	public function showData() {
		echo $this->table['open'];

		echo $this->th['open'] . "Language" . $this->th['close'];
		foreach ($this->_language as $key => $val) {
			echo $this->th['open'] . $key . $this->th['close'];
		}

		foreach ($this->_data as $key => $val) {
			echo $this->tr['open'];
			echo $this->td['open'] . $key . $this->td['close'];
			foreach ($val as $v) {
				echo $this->td['open'] . $v . $this->td['close'];
			}
			echo $this->tr['close'];
		}
		echo $this->table['close'];
	}

	public function showDataJson() {
		return json_encode($this->_data);
	}

	/**
	 * Set table open and close tags
	 * @param string $open  [open tag]
	 * @param string $close [close tag]
	 */
	public function setTagTable($open, $close) {
		$this->table['open']  = $open;
		$this->table['close'] = $close;
	}

	/**
	 * Set table row tags
	 * @param string $open  [open tag]
	 * @param string $close [close tag]
	 */
	public function setTagTableRow($open, $close) {
		$this->tr['open']  = $open;
		$this->tr['close'] = $close;
	}

	/**
	 * Set table header tags
	 * @param string $open  [open tag]
	 * @param string $close [close tag]
	 */
	public function setTagTableHeader($open, $close) {
		$this->th['open']  = $open;
		$this->th['close'] = $close;
	}

	/**
	 * Set table data tags
	 * @param string $open  [open tag]
	 * @param string $close [close tag]
	 */
	public function setTagTableData($open, $close) {
		$this->td['open']  = $open;
		$this->td['close'] = $close;
	}

	/**
	 * Backup data file
	 */
	public function backupData() {
		$this->saveData($this->_location . "_BACKUP");
	}
}