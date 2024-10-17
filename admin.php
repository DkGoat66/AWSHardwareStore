<?php
session_start();

// Check if the user is logged in and is admin
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

// Simulate sales report and inventory data
if (!isset($_SESSION['sales'])) {
    $_SESSION['sales'] = [
        ['transaction_id' => 'TXN001', 'date' => '2024-10-01', 'item_id' => '1', 'sales_quantity' => 5, 'total_sales' => 100.00],
        ['transaction_id' => 'TXN002', 'date' => '2024-10-05', 'item_id' => '2', 'sales_quantity' => 3, 'total_sales' => 45.00],
        // Add more sales transactions if needed
    ];
}

if (!isset($_SESSION['inventory'])) {
    $_SESSION['inventory'] = [
        ['item_id' => '1', 'item_name' => 'Hammer', 'sales_price' => 20.00, 'description' => 'A strong hammer.', 'opening_quantity' => 10, 'closing_quantity' => 5, 'gain_lost' => -5],
        ['item_id' => '2', 'item_name' => 'Screwdriver', 'sales_price' => 15.00, 'description' => 'A durable screwdriver.', 'opening_quantity' => 8, 'closing_quantity' => 5, 'gain_lost' => -3],
    
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Admin Dashboard</h2>

    <!-- Sales Report Section -->
    <h3>Sales Report</h3>
    <table border="1">
        <tr>
            <th>Transaction ID</th>
            <th>Date</th>
            <th>Item ID</th>
            <th>Sales Quantity</th>
            <th>Total Sales ($)</th>
        </tr>
        <?php foreach ($_SESSION['sales'] as $sale) { ?>
        <tr>
            <td><?php echo htmlspecialchars($sale['transaction_id']); ?></td>
            <td><?php echo htmlspecialchars($sale['date']); ?></td>
            <td><?php echo htmlspecialchars($sale['item_id']); ?></td>
            <td><?php echo htmlspecialchars($sale['sales_quantity']); ?></td>
            <td><?php echo "$" . htmlspecialchars($sale['total_sales']); ?></td>
        </tr>
        <?php } ?>
    </table>

    <!-- Inventory Tracking Section -->
    <h3>Inventory Tracking</h3>
    <table border="1">
        <tr>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Sales Price ($)</th>
            <th>Description</th>
            <th>Opening Quantity</th>
            <th>Closing Quantity</th>
            <th>Gain/Loss Quantity</th>
        </tr>
        <?php foreach ($_SESSION['inventory'] as $item) { ?>
        <tr>
            <td><?php echo htmlspecialchars($item['item_id']); ?></td>
            <td><?php echo htmlspecialchars($item['item_name']); ?></td>
            <td><?php echo "$" . htmlspecialchars($item['sales_price']); ?></td>
            <td><?php echo htmlspecialchars($item['description']); ?></td>
            <td><?php echo htmlspecialchars($item['opening_quantity']); ?></td>
            <td><?php echo htmlspecialchars($item['closing_quantity']); ?></td>
            <td><?php echo htmlspecialchars($item['gain_lost']); ?></td>
        </tr>
        <?php } ?>
    </table>

    <br><a href="dashboard.php">Back to Dashboard</a>
</body>
</html>