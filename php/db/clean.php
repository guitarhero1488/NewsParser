<?php

require_once('connection.php');

$result = $conn->query("SELECT * FROM news ORDER BY date DESC")
                    or die("Select error (".$conn->connect_errno.") ".$conn->connect_error);
