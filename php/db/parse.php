<?php

require_once('../parsing/Parser.php');
require_once('connection.php');

// $conn->query("DELETE FROM news WHERE id IN (SELECT id FROM news ORDER BY id DESC LIMIT 2)");// AND date < DATE_SUB(NOW(), INTERVAL 36 HOUR)");
$result = $conn->query("SELECT title, link, date FROM news");
$parser = new Parser('https://lenta.ru');
foreach(array_reverse($parser->news) as $news) {
    $isExist = false;
    while($row = $result->fetch_assoc()) {
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
// while($row = $result->fetch_assoc()) {
//     echo "<p>".$row["id"]."</p>";
// }
include('get.php');
$conn->close();
