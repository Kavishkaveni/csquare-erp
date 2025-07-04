<?php
include '../db/connection.php';

$sql = "SELECT 
            i.id, i.item_code, i.item_name, i.quantity, i.unit_price, 
            c.category, 
            s.sub_category
        FROM item i
        LEFT JOIN item_category c ON i.item_category = c.id
        LEFT JOIN item_subcategory s ON i.item_subcategory = s.id
        ORDER BY i.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Items</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <h2>Item List</h2>
    <a href="add_item.php" class="btn btn-primary mb-3">Add New Item</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['item_code']}</td>
                            <td>{$row['item_name']}</td>
                            <td>{$row['category']}</td>
                            <td>{$row['sub_category']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['unit_price']}</td>
                            <td>
                              <a href='edit_item.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                              <a href='delete_item.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this item?');\">Delete</a>
                            </td>
                            </tr>";
                }
            } else {
                echo '<tr><td colspan="7" class="text-center">No items found</td></tr>';
            }
            ?>
        </tbody>
    </table>

</body>
</html>