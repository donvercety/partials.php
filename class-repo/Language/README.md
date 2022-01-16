# php.class.Language v1.0

*original archived repository - [php.class.Language](https://github.com/donvercety/php.class.Language)*

*Lightweight PHP Language library. Easy to use, flexible. Support as many languages as you want.*
*Version 1.0*

**Simple usage:**
```php
<?php
// use the constructor to preset language settings
$l = new Language([
	"BG" => 0,
	"EN" => 1,
], 'data.txt');

// you can set the same language settings using this methods
$l->setLanguages([
	"BG" => 0,
	"EN" => 1,
]);
$l->loadData('data.txt'); // or maybe .csv file

// choose a language, to be displayed in the site
$l->chooseLanguage("BG");

// get specific key, for the chosen language
$l->getData('ask')

// you can backup the data before manipulating it
$l->backupData(); // data.txt_BACKUP

// set specific key
$l->setData('ask', 'защо,what');

// remove specific key
$l->delData('ask');

// save data after manipulation keys
$l->saveData('data.txt');

// sort data array alphabetically, use false flag to sort it in reverse
$l->sortDataAlphabetically();
$l->sortDataAlphabetically(false); // sort in reverse

// use to show all available language data
$l->showData();     // displays the content in html table
$l->showDataJson(); // displays the content in JSON format
```

`$l->showData();` HTLM table style is edditable:

```php
<?php

// $open, $close - specify open and close tags

$l->setTagTable($open, $close);
$l->setTagTableRow($open, $close);
$l->setTagTableHeader($open, $close);
$l->setTagTableData($open, $close):
```

*for example, style methods can be used to make HTML table styled for bootstrap*
