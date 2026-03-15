<?php
include "includes/db.php";

$result=$conn->query("SELECT * FROM missing_persons WHERE status='missing'");
?>

<h2>Missing Persons</h2>

<?php
while($row=$result->fetch_assoc())
{
?>

<div style="border:1px solid black;padding:10px;margin:10px;width:300px;">

<h3><?php echo $row['name']; ?></h3>

<img src="uploads/<?php echo $row['image']; ?>" width="200"><br><br>

Age: <?php echo $row['age']; ?><br>
Last Seen: <?php echo $row['last_seen']; ?><br>
Contact: <?php echo $row['contact']; ?><br>

<a href="mark_found.php?id=<?php echo $row['id']; ?>">Mark as Found</a>

</div>

<?php
}
?>