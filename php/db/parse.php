<?php

require_once('../parser.php');
require_once('connection.php');

$parser = new Parser('https://lenta.ru');
foreach($parser->news as $news) {
    $conn->query("INSERT INTO `news` (`id`, `title`, `link`, `date`) VALUES (NULL,
                                                                             '".$news["title"]."',
                                                                             '".$news["link"]."',
                                                                             '".$news["date"]."')")
           or die("Insert error (".$conn->connect_errno.") ".$conn->connect_error);
}
$conn->close();
