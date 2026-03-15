<?php
session_start();
include "db.php"; // Your database connection

// Fetch Lost Items
$lost_result = $conn->query("SELECT * FROM lost_items ORDER BY created_at DESC");

// Fetch Found Items
$found_result = $conn->query("SELECT * FROM found_items ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Browse Items | FindIt</title>
<style>
body { font-family: Arial; background:#f5f5f5; margin:0; padding:0; }
.container { max-width:900px; margin:30px auto; padding:20px; background:#fff; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
h1 { text-align:center; color:#333; margin-bottom:20px; }
h2 { color:#007bff; margin-top:30px; }
.items { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:20px; }
.item { border:1px solid #ccc; border-radius:8px; padding:10px; background:#fafafa; text-align:center; }
.item img { width:100%; height:150px; object-fit:cover; border-radius:6px; }
.item-title { font-weight:bold; margin:10px 0 5px; }
.item-category { font-size:14px; color:#555; margin-bottom:5px; }
</style>
</head>
<body>
<div class="container">
    <h1>Browse Items</h1>

    <h2>Lost Items</h2>
    <div class="items">
        <?php if($lost_result->num_rows > 0){
            while($row = $lost_result->fetch_assoc()){ ?>
                <div class="item">
                    <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
                    <div class="item-title"><?php echo $row['title']; ?></div>
                    <div class="item-category"><?php echo $row['category']; ?></div>
                    <div class="item-desc"><?php echo $row['description']; ?></div>
                </div>
        <?php } } else { echo "<p>No lost items found.</p>"; } ?>
    </div>

    <h2>Found Items</h2>
    <div class="items">
        <?php if($found_result->num_rows > 0){
            while($row = $found_result->fetch_assoc()){ ?>
                <div class="item">
                    <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
                    <div class="item-title"><?php echo $row['title']; ?></div>
                    <div class="item-category"><?php echo $row['category']; ?></div>
                    <div class="item-desc"><?php echo $row['description']; ?></div>
                </div>
        <?php } } else { echo "<p>No found items found.</p>"; } ?>
    </div>
</div>
</body>
</html>