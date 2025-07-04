<?php
include '../db/connection.php';

$items = [];

if (isset($_POST['filter'])) {
    $sql = "SELECT 
                i.item_name, 
                cat.category AS category, 
                sub.sub_category AS sub_category, 
                i.quantity
            FROM item i
            LEFT JOIN item_category cat ON i.item_category = cat.id
            LEFT JOIN item_subcategory sub ON i.item_subcategory = sub.id";

    $result = $conn->query($sql);

    if (!$result) {
        die("Query error: " . $conn->error);
    }

    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Item Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <h2>Item Report</h2>

    <form method="POST" class="form-inline mb-3">
        <button type="submit" name="filter" class="btn btn-primary">Show Items</button>
    </form>

    <?php if (count($items) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['item_name']) ?></td>
                    <td><?= htmlspecialchars($item['category']) ?></td>
                    <td><?= htmlspecialchars($item['sub_category']) ?></td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (isset($_POST['filter'])): ?>
        <p>No items found.</p>
    <?php endif; ?>

</body>
</html>