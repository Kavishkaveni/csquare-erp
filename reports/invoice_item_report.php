<?php
include '../db/connection.php';

$start_date = '';
$end_date = '';
$result = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql = "SELECT 
                im.invoice_no, 
                i.date, 
                c.first_name AS customer_name, 
                it.item_name, 
                it.item_code, 
                cat.category, 
                it.unit_price 
            FROM invoice_master im 
            LEFT JOIN invoice i ON im.invoice_no = i.invoice_no 
            LEFT JOIN customer c ON i.customer = c.id 
            LEFT JOIN item it ON im.item_id = it.id 
            LEFT JOIN item_category cat ON it.item_category = cat.id 
            WHERE DATE(i.date) BETWEEN '$start_date' AND '$end_date'";

    $query = $conn->query($sql);
    if ($query && $query->num_rows > 0) {
        $result = $query;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice Item Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <h2>Invoice Item Report</h2>

    <form method="POST" class="form-inline mb-3">
        <label for="start_date" class="mr-2">Start Date:</label>
        <input type="date" name="start_date" class="form-control mr-3" required value="<?php echo $start_date; ?>">

        <label for="end_date" class="mr-2">End Date:</label>
        <input type="date" name="end_date" class="form-control mr-3" required value="<?php echo $end_date; ?>">

        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Item Name</th>
                    <th>Item Code</th>
                    <th>Category</th>
                    <th>Unit Price</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['invoice_no']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['item_code']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['unit_price']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No records found for the selected date range.</p>
    <?php endif; ?>

</body>
</html>