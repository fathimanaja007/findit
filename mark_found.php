<?php
include "includes/db.php";

$id=$_GET['id'];

$conn->query("UPDATE missing_persons SET status='found' WHERE id=$id");

echo "Person marked as found";

?>