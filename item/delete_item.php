<?php
include '../db/connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM item WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Item deleted successfully'); window.location.href='view_item.php';</script>";
    } else {
        echo "Error deleting item: " . $conn->error;
    }
} else {
    echo "Invalid request";
}
?>