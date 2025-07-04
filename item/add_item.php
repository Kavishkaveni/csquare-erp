<?php
include '../db/connection.php';

$success = '';
$error = '';

// Handle form submit
if (isset($_POST['submit'])) {
    $item_code = $_POST['item_code'];
    $item_name = $_POST['item_name'];
    $item_category = $_POST['item_category'];
    $item_subcategory = $_POST['item_subcategory'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];

    $sql = "INSERT INTO item (item_code, item_name, item_category, item_subcategory, quantity, unit_price)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiid", $item_code, $item_name, $item_category, $item_subcategory, $quantity, $unit_price);

    if ($stmt->execute()) {
        $success = "Item added successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <h2>Add Item</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Item Code</label>
            <input type="text" name="item_code" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Item Name</label>
            <input type="text" name="item_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Item Category</label>
            <select name="item_category" class="form-control" required>
                <option value="">-- Select Category --</option>
                <?php
                $catResult = $conn->query("SELECT id, category FROM item_category");
                if ($catResult->num_rows > 0) {
                    while ($cat = $catResult->fetch_assoc()) {
                        echo '<option value="'.$cat['id'].'">'.$cat['category'].'</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Item Subcategory</label>
            <select name="item_subcategory" class="form-control" required>
                <option value="">-- Select Subcategory --</option>
                <?php
                $subcatResult = $conn->query("SELECT id, sub_category FROM item_subcategory");
                if ($subcatResult->num_rows > 0) {
                    while ($sub = $subcatResult->fetch_assoc()) {
                        echo '<option value="'.$sub['id'].'">'.$sub['sub_category'].'</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" min="0" required>
        </div>

        <div class="form-group">
            <label>Unit Price</label>
            <input type="number" name="unit_price" class="form-control" min="0" step="0.01" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add Item</button>
    </form>

</body>
</html>