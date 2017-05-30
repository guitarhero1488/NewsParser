<?php

require_once('connection.php');

$result = $conn->query("SELECT * FROM news ORDER BY date DESC limit 10")
                    or die("Select error (".$conn->connect_errno.") ".$conn->connect_error);
$str = '';
while($row = $result->fetch_assoc()) {
    $str .= "<tr class='panel-heading' role='tab' id='heading".$row["id"]."'>
                 <td>".$row["id"]."</td>
                 <td>".$row["title"]."</td>
                 <td>
                    <a class='collapsed link' role='button' data-url='".$row["link"]."' data-toggle='collapse' data-parent='#accordion' href='#collapse".$row["id"]."' aria-expanded='false' aria-controls='collapse".$row["id"]."'>link</a>
                 </td>
                 <td>".$row["date"]."</td>
            </tr>
            <tr id='collapse".$row["id"]."' class='panel-collapse collapse' role='tabpanel' aria-labelledby='heading".$row["id"]."'>
                <td colspan='4'>
                    <div class='embed-responsive embed-responsive-4by3'></div>
                </td>
            </tr>";
}
echo $str;
$conn->close();
