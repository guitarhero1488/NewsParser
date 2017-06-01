<?php

require_once('../parsing/Parser.php');
require_once('connection.php');
define("Number", 12);

$conn->query("DELETE FROM news WHERE date < DATE_SUB(NOW(), INTERVAL 36 HOUR)");
$dbNews = $conn->query("SELECT title, link, date FROM news");
$parser = new Parser('https://lenta.ru');
// to check how many news we parsed
$new = 0;
foreach($parser->news as $news) {
    $new++;
    foreach($dbNews as $row) {
        if($news == $row) {
            $new--;
            break;
        }
    }
}
$dbNewsNumber = $conn->query("SELECT COUNT(*) FROM news")->fetch_assoc();
$x = $dbNewsNumber["COUNT(*)"] - Number + $new; // how much space we need to free
if($x > 0) {
    $conn->query("DELETE FROM news ORDER BY id LIMIT ".$x);
}
foreach(array_reverse($parser->news) as $news) {
    $isExist = false;
    foreach($dbNews as $row) {
        if($news == $row) {
            $isExist = true;
            break;
        }
    }
    if(!$isExist) {
        $conn->query("INSERT INTO news (`id`, `title`, `link`, `date`) VALUES (NULL,
                                                                                '".$news["title"]."',
                                                                                '".$news["link"]."',
                                                                                '".$news["date"]."')")
                or die("Insert error (".$conn->connect_errno.") ".$conn->connect_error);
    }
}
// word counting
$conn->query("DELETE FROM words");
$dbTitles = $conn->query("SELECT id, title FROM news ORDER BY id");
$index = 1;
foreach($dbTitles as $row) {
    $w = explode(" ", $row["title"]);
    for($i = 0; $i < count($w); $i++) {
        $conn->query("INSERT INTO words (`id`, `word`) VALUES ('".$index."', '".$w[$i]."')");
        $conn->query("INSERT INTO newswords (`news_id`, `word_id`) VALUES ('".$row["id"]."', '".$index."')");
        $index++;
    }
}
include('get.php');
$conn->close();
