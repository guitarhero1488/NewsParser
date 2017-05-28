<?php

require_once('connection.php');

$result = $conn->query("SELECT n.id, n.title, n.link, n.date, w.newsid, w.word FROM news AS n, words AS w")
                    or die("Select error (".$conn->connect_errno.") ".$conn->connect_error);
echo $result;
$conn->close();
