<?php
require_once('./init.php');

header("Content-Type: text/html; charset=utf-8");
echo $l->showData();

$l->sortDataAlphabetically();

echo "<hr />";

echo $l->showData();

?>

<hr />
<a href="?lang=bg">BG</a> |
<a href="?lang=en">EN</a>
<hr />

<?php

echo $l->getData('space'), "<br />";
echo $l->getData('phone'), "<br />";

?>

<hr />
<a href="json.php">JSON</a>
<a href="add.php">add</a>