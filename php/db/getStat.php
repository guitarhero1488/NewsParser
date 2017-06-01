<?php

require_once('connection.php');

$wordList = $conn->query("SELECT word FROM words")
                   or die("Select error (".$conn->connect_errno.") ".$conn->connect_error);
$words = [];
foreach($wordList as $word) {
    $words[] = $word["word"];
}
$stat = array_count_values($words);
foreach($stat as $key => $value) {
     $str .= "<tr>
                 <td>".$key."</td>
                 <td>".$value."</td>
             </tr>";
}
echo $str;
$conn->close();
