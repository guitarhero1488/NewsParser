<?php
$conn = new mysqli('localhost', 'root', 'root', 'parsednews');
if($conn->connect_error) {
    die("Connection error (".$conn->connect_errno.") ".$conn->connect_error);
}
