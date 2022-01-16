<?php

/**
 * DateTime operations.
 *
 * You can correct the date by using TimeOffset or TimeZone,
 * the correct way to do this is to use TimeZone but if you 
 * prefer to use TimeOffset you must ensure that the 
 * TimeZone parameter is set to 'GMT'.
 *
 * @author Tommy Vercety
 */
class MiniDate {

	/**
	 * Default timeoffset.
	 * 
	 * If you want to use time offset you 
	 * must use 'GMT' as the default timezone,
	 * 
	 * @var string
	 */
	protected $_timeOffset = '0';

	/**
	 * Default timezone.
	 * @var string
	 */
	protected $_timeZone = 'Europe/Sofia';

	/**
	 * Delimiter for $toAdd parametur in addTo() method.
	 * @var string
	 */
	protected $_delimiter = ':';

	/**
	 * Class Constructor
	 * Sets the default timezone.
	 */
	public function __construct()
	{
		$this->setTimeZone( $this->_timeZone );
	}

	// ============ //
	// MAIN METHODS //
	// ============ //

	/**
	 * Make a simple DateTime math operation.
	 * The first parameter is a datetime string on 
	 * which to be added the second parameter.
	 *
	 * The second parameter consists of two parts,
	 * example: '<time_to_add>:<type_of_time>'
	 *
	 *     adding 8 hours:  '8:hours'
	 *     adding 2 months: '2:months'
	 *     adding 5 years:  '5:years'
	 *
	 * The first part before the ':' is the value to be
	 * added, the second part is the type of that value.
	 * 
	 * @param string $date   add to this time 
	 * @param string $toAdd  the time to be added
	 * @param string $format datetime format string
	 */
	public function addTo( $date, $toAdd, $format = 'Y-m-d H:i:s' )
	{
		$params = explode($this->_delimiter, $toAdd);
		return date($format, strtotime(date($format, strtotime($date)) . "+ {$params[0]} {$params[1]}"));
	}

	/**
	 * Get the current DateTime.
	 * @param  string  $format datetime format string
	 * @return string
	 */
	public function now( $format = 'Y-m-d H:i:s' )
	{
		return date( $format );
	}

	/**
	 * Get the current Date.
	 * @return string current date
	 */
	public function nowDate()
	{
		return date( 'Y-m-d' );
	}

	/**
	 * Get the current Time.
	 * @return string current time
	 */
	public function nowTime()
	{
		return date( 'H:i:s' );
	}

	// ========== //
	// ADD TO NOW //
	// ========== //

	/**
	 * Returns a date in the future based on the added hours.
	 * The default value is one hour ahead, if no data is provided.
	 *
	 * @link( http://php.net/manual/en/function.date.php, date formats example)
	 * @param  integer $hour number of hours to add to current date.
	 * @param  string  $format datetime format string
	 * @return string
	 */
	public function addHour( $hour = 1, $format = 'Y-m-d H:i:s' )
	{
		return date($format, strtotime(date($format) . "+ {$hour} hour {$this->_timeOffset} hour"));
	}

	/**
	 * Returns a date in the future based on the added days.
	 * The default value is one day ahead, if no data is provided.
	 *
	 * @link( http://php.net/manual/en/function.date.php, date formats example)
	 * @param  integer $day number of days to add to current date.
	 * @param  string  $format datetime format string
	 * @return string
	 */
	public function addDay( $day = 1, $format = 'Y-m-d H:i:s' )
	{
		return date($format, strtotime(date($format) . "+ {$day} day {$this->_timeOffset} hour"));
	}

	/**
	 * Returns a date in the future based on the added months.
	 * The default value is one month ahead, if no data is provided.
	 *
	 * @link( http://php.net/manual/en/function.date.php, date formats example)
	 * @param  integer $month number of months to add to current date.
	 * @param  string  $format datetime format string
	 * @return string
	 */
	public function addMonth( $month = 1, $format = 'Y-m-d H:i:s' )
	{
		return date($format, strtotime(date($format) . "+ {$month} month {$this->_timeOffset} hour"));
	}

	/**
	 * Returns a date in the future based on the added years.
	 * The default value is one year ahead, if no data is provided.
	 *
	 * @link( http://php.net/manual/en/function.date.php, date formats example)
	 * @param  integer $year number of years to add to current date.
	 * @param  string  $format datetime format string
	 * @return string
	 */
	public function addYear( $year = 1, $format = 'Y-m-d H:i:s' )
	{
		return date($format, strtotime(date($format) . "+ {$year} year {$this->_timeOffset} hour"));
	}

	// ======= //
	// SETTERS //
	// ======= //

	/**
	 * Set the default timeoffset.
	 * @param string $_timeOffset examples: '0', '+2', '-8'
	 */
	public function setTimeOffset( $_timeOffset )
	{
		$this->_timeOffset = $_timeOffset;
	}

	/**
	 * Set the default timezone.
	 * @param string $_timeZone example: 'Europe/Sofia'
	 */
	public function setTimeZone( $_timeZone )
	{
		date_default_timezone_set( $_timeZone );
	}

	/**
	 * Set the delimiter for the main method addTo().
	 * @param string $delimiter
	 */
	public function setDelimiter( $delimiter )
	{
		$this->_delimiter = $delimiter;
	}

	// ======= //
	// GETTERS //
	// ======= //

	/**
	 * Get _timeOffset parameter.
	 * @return string
	 */
	public function getTimeOffset()
	{
		return $this->_timeOffset;
	}

	/**
	 * Get _timeZone parameter.
	 * @return string
	 */
	public function getTimeZone()
	{
		return $this->_timeZone;
	}

	/**
	 * Get the delimiter for the main method addTo().
	 * @return string
	 */
	public function getDelimiter()
	{
		return $this->_delimiter;
	}

}
