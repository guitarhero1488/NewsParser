<?php

require_once('../parser.php');
require_once('connection.php');

$result = $conn->query("SELECT title, link, date FROM `news`");
$parser = new Parser('https://lenta.ru');
foreach($parser->news as $news) {
    while($row = $result->fetch_assoc()) {
        if($news != $row) {
            $conn->query("INSERT INTO `news` (`id`, `title`, `link`, `date`) VALUES (NULL,
                                                                                    '".$news["title"]."',
                                                                                    '".$news["link"]."',
                                                                                    '".$news["date"]."')")
                   or die("Insert error (".$conn->connect_errno.") ".$conn->connect_error);
        }
    }
}

include('get.php');
$conn->close();
