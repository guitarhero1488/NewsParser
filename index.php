<?php
$conn = new mysqli('localhost', 'root', 'root', 'parsednews');
if($conn->connect_error) {
    die("Connection error (".$conn->connect_errno.") ".$conn->connect_error);
}
$conn->query("DELETE FROM words");
$dbTitles = $conn->query("SELECT id, title FROM news ORDER BY id");
$index = 1;
foreach($dbTitles as $row) {
    $w = explode(" ", $row["title"]);
    for($i = 0; $i < count($w); $i++) {
        // echo "<p>".$w[$i]."</p>";
        $conn->query("INSERT INTO words (`id`, `word`) VALUES ('".$index."', '".$w[$i]."')");
        $conn->query("INSERT INTO newswords (`news_id`, `word_id`) VALUES ('".$row["id"]."', '".$index."')");
        $index++;
    }
}


// $dbWords = $conn->query("SELECT id, word FROM words")->fetch_all();
// // print_r(next($dbWords)[1]);
// $words_here = $dbWords;
// $lastIndex = end($dbWords);
// // print_r($lastIndex[0]);
// foreach($dbTitles as $row) {
//     // echo "1 \n";
//     $w = explode(" ", $row["title"]);
//     for($i = 0; $i < count($w); $i++) {
//         // echo "2 \n";
//         foreach($words_here as $words) {
//             // echo end($words_here)[0];
//             // break;
//             if($w[$i] != $words[1]) {
//                 // $conn->query("INSERT INTO words (`id`, `word`) VALUES ('".($lastIndex[0] + 1)."', '".$w[$i]."')");
//                 $lastIndex[0]++;
//                 $words_here[] = $w[$i];
//             }
//         }
//     }
// }

$conn->close();
