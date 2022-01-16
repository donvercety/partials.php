# php.class.MiniDate v0.6

*original archived repository - [php.class.MiniDate](https://github.com/donvercety/php.class.MiniDate)*

Simple Date class. For doing math operations with DateTime.  
Version 0.6

 > adding implemented  
 > subtraction ( *in progress* ) 

**Simple usage:**
```php
include_once 'Date.php';
$date = new MiniDate();

// setting the default timezone
$date->setTimeZone( 'Europe/Sofia' ); 
```
 
```php
$date->now();            // returns the current datetime in 'Y-m-d H:i:s' format
$date->now('H:m d-m-Y'); // using custom format

$date->nowDate();        // returns the current date
$date->nowTime();        // returns the current time
```

```php
$date->addHour(3);       // add 3 Hours to current time
$date->addDay(5);        // add 5 Days to current time
$date->addMonth(1);      // add 1 Month to current time
$date->addYear(10);      // add 10 Years to current time

$date->addDay(5, 'H:i d-m-Y ');  //  using custom format
```

**The all in one method:**
```php
$date->addTo( $date->now(), '6:Days' );           // adding 6 days to now()
$date->addTo( '2014-10-22 15:00:21', '1:Month' ); // adding 1 month to a specific date

// using custom format
$date->addTo( '2014-10-22 15:00:21', '1:Month', 'H:i d-m-Y ' );
```
Time formats at [php.net](http://php.net/manual/en/function.date.php)
