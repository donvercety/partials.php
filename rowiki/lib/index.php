<?php
/**
 * roWiki
 *
 * @author: Tommy Vercety
 * @version 1.10 (2022-01-31)
 * @url https://github.com/donvercety/partials.php/tree/master/rowiki
 * - PHP 7.x support
 * - read-only mode
 * - fixed issues
 * - complete template redesign
 * - mobile friendly
 *
 * @author Marc Rohlfing <rowiki@rowlff.de>
 * @version 1.05 (2005-06-04)
 * @url www.rowlff.de/rowiki (Home/Docs/Licensing)
 */

$WIKI_TITLE         = "roWiki";
$START_PAGE         = "Home";
$HOME_BUTTON        = "Home";
$HELP_BUTTON        = "Help";
$EDIT_BUTTON        = "Edit";
$DEFAULT_CONTENT    = "This is an empty page";
$DONE_BUTTON        = "Save";
$PROTECTED_BUTTON   = "Locked Page";
$SEARCH_BUTTON      = "Search";
$SEARCH_RESULTS     = "Search results for";
$NEW_PAGE           = "New Page";
$RECENT_CHANGES     = "Recent Changes";
$TIME_FORMAT        = "%Y-%m-%d %H:%S";
$PAGES_DIR          = "pages/";
$BACKUP_DIR         = "history/";
$READ_ONLY          = false;
	
// Determine page to display
if (! $PAGE_TITLE = stripslashes($_GET["page"])) {
	if ($_GET["action"] == "search")
		$PAGE_TITLE = "$SEARCH_RESULTS \"$_GET[query]\"";
	elseif ($_GET["action"] == "recent")
		$PAGE_TITLE = "$RECENT_CHANGES";
	else
		$PAGE_TITLE = "$START_PAGE";
}

// Catch malicious paths
if (preg_match("/\//", $PAGE_TITLE))
	$PAGE_TITLE = $START_PAGE;	

// Write changes to page, if there are any
$action = $_GET["action"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($READ_ONLY) die('Wiki is read-ony!');
	if (! $file = @fopen($PAGES_DIR . stripslashes($_POST["page"]) . ".txt", "w"))
		die ("Could not write page!");
	fputs($file, trim(stripslashes($_POST["content"])));
	fclose($file);
	if ($BACKUP_DIR <> '') {
		if (! $file = @fopen($BACKUP_DIR . $_POST["page"] . ".bak", "a"))
			die ("Could not write backup of page!");
		fputs($file, "\n\n\n--------------------\n" . strftime("$TIME_FORMAT", time()) . " / " . $_SERVER['REMOTE_ADDR'] . "\n--------------------\n");
		fputs($file, trim(stripslashes($_POST["content"])));
		fclose($file);
	}
	header("location: ?page=" . urlencode(stripslashes($_POST["page"])));
}
	
// Read and parse template
if (! $file = @fopen("template.html", "r"))
	die ("'template.html' is missing!");
$template = fread($file, filesize("template.html"));
fclose($file);

// Read page contents and time of last change
if (($file = @fopen($PAGES_DIR . $PAGE_TITLE . ".txt", "r")) || $action <> "") {
	$TIME = strftime("$TIME_FORMAT", @filemtime($PAGES_DIR . $PAGE_TITLE . ".txt"));
	$CONTENT = "\n" . @fread($file, @filesize($PAGES_DIR . $PAGE_TITLE . ".txt")) . "\n";
	@fclose($file);
	$CONTENT = preg_replace("/\\$/Umsi", "&#036;", $CONTENT);
} else {
	$action = "edit";
	$TIME = "$NEW_PAGE";
}

// Determine access mode
if ($action == "edit" || $action <> "")
	$html = preg_replace('/{EDIT}/', "$EDIT_BUTTON", $template);
elseif (is_writable($PAGES_DIR . $PAGE_TITLE . ".txt"))
	$html = preg_replace('/{EDIT}/', "<a href=\"?page=$PAGE_TITLE&action=edit\">$EDIT_BUTTON</a>", $template);
else
	$html = preg_replace('/{EDIT}/', "$PROTECTED_BUTTON", $template);
if ($action == "recent")
	$html = preg_replace('/{RECENT_CHANGES}/', "$RECENT_CHANGES", $html);
else
	$html = preg_replace('/{RECENT_CHANGES}/', "<a href=\"?action=recent\">$RECENT_CHANGES</a>", $html);

// Put values into template
$html = preg_replace('/{PAGE_TITLE}/', "$PAGE_TITLE", $html);
if ($PAGE_TITLE == $START_PAGE && $action <> "search")
	$html = preg_replace('/{HOME}/', "$HOME_BUTTON", $html);
else
	$html = preg_replace('/{HOME}/', "<a href=\".\">$HOME_BUTTON</a>", $html);
$html = preg_replace('/{WIKI_TITLE}/', $WIKI_TITLE, $html);
if ($PAGE_TITLE == $HELP_BUTTON)
	$html = preg_replace('/{HELP}/', "$HELP_BUTTON", $html);    
else
	$html = preg_replace('/{HELP}/', "<a href=\"?page=$HELP_BUTTON\">$HELP_BUTTON</a>", $html);
$html = preg_replace('/{SEARCH}/', "<form method=\"get\" action=\".\"><input type=\"hidden\" name=\"action\" value=\"search\" /><input type=\"text\" name=\"query\" size=\"16\" value=\"$_GET[query]\" /> <input type=\"submit\" value=\"$SEARCH_BUTTON\" /></form>", $html);
if ($action == "edit") {
	if ($CONTENT == '')
		$CONTENT = $DEFAULT_CONTENT;
	$CONTENT = "<form method=\"post\" action=\"index.php\"><br /><textarea name=\"content\" cols=\"80\" rows=\"15\">$CONTENT</textarea><input type=\"hidden\" name=\"page\" value=\"$PAGE_TITLE\" /><br /><br /><input type=\"submit\" value=\"$DONE_BUTTON\" /></form>";
}
// Search pages
if ($action == "search") {
	$dir = opendir(getcwd() . "/$PAGES_DIR");
	$CONTENT .= "<br />";
	while ($file = readdir($dir)) {
		if (preg_match("/.txt/", $file)) {
			$handle = fopen($PAGES_DIR . $file, "r");
			$content = fread($handle, filesize($PAGES_DIR . $file));
			fclose($handle);
			if (preg_match("/$_GET[query]/i", $content) || preg_match("/$_GET[query]/i", "pages/$file")) {
				$file = substr($file, 0, strlen($file) - 4);
				$CONTENT .= "<a href=\"?page=$file\">$file</a><br />";
			}
		}
	}
	$TIME = "-";
	
// Recent changes
} else if ($action == "recent") {
	$dir = opendir(getcwd() . "/$PAGES_DIR");
	while ($file = readdir($dir))
		if (preg_match("/.txt/", $file))
			$filetime[$file] = filemtime($PAGES_DIR . $file);
	arsort($filetime);
	$filetime = array_slice($filetime, 0, 10);
	$CONTENT .= "<br />";
	foreach ($filetime as $filename => $timestamp) {
		$filename = substr($filename, 0, strlen($filename) - 4);
		$CONTENT .= "<a href=\"?page=$filename\">$filename</a> (" . strftime("$TIME_FORMAT", $timestamp) . ")<br />";
	}
	$TIME = "-";

// Prepare page formatting
} else if ($action <> "edit") {
	$CONTENT = htmlentities($CONTENT);
	$CONTENT = preg_replace("/&amp;#036;/Umsi", "&#036;", $CONTENT);
	$CONTENT = preg_replace('#\[(.+)\|h(ttps?://[0-9a-zA-Z\.\#\:/~\-_%=\?\&amp;,\+]*)\]#U', '<a href="xx$2">$1</a>', $CONTENT);
	$CONTENT = preg_replace('#h(ttps?://[0-9a-zA-Z\.\&amp;\#\:/~\-_%=?]*\.(jpg|gif|png))#i', '<img src="xx$1" />', $CONTENT);
	$CONTENT = preg_replace('#(https?://[0-9a-zA-Z\.\&amp;\#\:/~\-_%=?]*)#i', '<a href="$0">$1</a>', $CONTENT);
	$CONTENT = preg_replace('#xxttp#', 'http', $CONTENT);
// 	$CONTENT = preg_replace("/\[([0-9a-zA-Z\- :\.,\(\)\']+)\]/U", '<a href="?page=$1">$1</a>', $CONTENT);
	preg_match_all("/\[([^\/]+)\]/U", $CONTENT, $matches, PREG_PATTERN_ORDER); // new feature from v1.05, red color for non existing links
	foreach ($matches[1] as $match)
		if (file_exists("$PAGES_DIR/$match.txt"))
			$CONTENT = str_replace("[$match]", "<a href=\"index.php?page=$match\">$match</a>", $CONTENT);
		else
			$CONTENT = str_replace("[$match]", "<a href=\"index.php?page=$match\" class=\"new-page\">$match</a>", $CONTENT);
	$CONTENT = preg_replace('#([0-9a-zA-Z\./~\-_]+@[0-9a-z\./~\-_]+)#i', '<a href="mailto:$0">$0</a>', $CONTENT);
	$CONTENT = preg_replace('/^\*(.*)(\n)/Um', "<ul><li>$1</li></ul>$2", $CONTENT);
	$CONTENT = preg_replace('/^\#(.*)(\n)/Um', "<ol><li>$1</li></ol>$2", $CONTENT);
	$CONTENT = preg_replace('/(<\/ol>\n*<ol>|<\/ul>\n*<ul>)/', "", $CONTENT);
	$CONTENT = preg_replace('/^!!!(.*)(\n)/Um', '<h2>$1</h2>$2', $CONTENT);
	$CONTENT = preg_replace('/^!!(.*)(\n)/Um', '<h3>$1</h3>$2', $CONTENT);
	$CONTENT = preg_replace('/^!(.*)(\n)/Um', '<h4>$1</h4>$2', $CONTENT);
	$CONTENT = preg_replace('/----(\r\n|\r|\n)/m', '<hr>', $CONTENT);
	$CONTENT = preg_replace('/\n/', '<br />', $CONTENT);
	$CONTENT = preg_replace('#</ul>(<br />)*#', "</ul>", $CONTENT);
	$CONTENT = preg_replace('#</ol>(<br />)*#', "</ol>", $CONTENT);
	$CONTENT = preg_replace('#(</h[234]>)<br />#', "$1", $CONTENT);
	$CONTENT = preg_replace_callback("/{{(.+)}}/U", function($matches) { // FIX: deprecated "/e" modifier fix
		return '<pre>' . preg_replace('#<br />#', '', $matches[1]) . '</pre>';
	}, $CONTENT);
	$CONTENT = preg_replace("/'''(.*)'''/Um", '<b>$1</b>', $CONTENT);
	$CONTENT = preg_replace("/''(.*)''/Um", '<i>$1</i>', $CONTENT);
	$CONTENT = preg_replace('/`(.*)`/Um', "<code>$1</code>", $CONTENT);
	$CONTENT = substr($CONTENT, 6, strlen($CONTENT) - 6);
}

// Print page            
$html = preg_replace("/{CONTENT}/", "$CONTENT", $html);
$html = preg_replace('/{TIME}/', $TIME, $html);
echo $html;
