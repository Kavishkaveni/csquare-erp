<?php
include '../db/connection.php';

if (!isset($_GET['id'])) {
    die("Invalid Request");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM item WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    die("Item not found.");
}

$row = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $item_code = $_POST['item_code'];
    $item_name = $_POST['item_name'];
    $item_category = $_POST['item_category'];
    $item_subcategory = $_POST['item_subcategory'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];

    $update_sql = "UPDATE item SET 
        item_code='$item_code',
        item_name='$item_name',
        item_category='$item_category',
        item_subcategory='$item_subcategory',
        quantity='$quantity',
        unit_price='$unit_price'
        WHERE id=$id";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Item updated successfully'); window.location.href='view_item.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <h2>Edit Item</h2>

    <form method="POST">
        <div class="form-group">
            <label>Item Code</label>
            <input type="text" name="item_code" class="form-control" value="<?php echo $row['item_code']; ?>" required>
        </div>

        <div class="form-group">
            <label>Item Name</label>
            <input type="text" name="item_name" class="form-control" value="<?php echo $row['item_name']; ?>" required>
        </div>

        <div class="form-group">
            <label>Category</label>
            <input type="text" name="item_category" class="form-control" value="<?php echo $row['item_category']; ?>" required>
        </div>

        <div class="form-group">
            <label>Subcategory</label>
            <input type="text" name="item_subcategory" class="form-control" value="<?php echo $row['item_subcategory']; ?>" required>
        </div>

        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" value="<?php echo $row['quantity']; ?>" required>
        </div>

        <div class="form-group">
            <label>Unit Price</label>
            <input type="text" name="unit_price" class="form-control" value="<?php echo $row['unit_price']; ?>" required>
        </div>

        <button type="submit" name="update" class="btn btn-success">Update Item</button>
        <a href="view_item.php" class="btn btn-secondary">Cancel</a>
    </form>

</body>
</html>