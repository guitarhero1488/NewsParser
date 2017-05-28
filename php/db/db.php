<?php

require_once('parser.php');

$parser = new Parser('https://lenta.ru');
$conn = new mysqli('localhost', 'root', 'root', 'parsednews');
if($conn->connect_error) {
    die("Connection error (".$conn->connect_errno.") ".$conn->connect_error);
}
foreach($parser->news as $news) {
    $conn->query("INSERT INTO `news` (`id`, `keywords`, `title`, `article`, `date`) VALUES ")
        or die("Insert error (".$conn->connect_errno.") ".$conn->connect_error);
}
