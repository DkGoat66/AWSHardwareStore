<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

// Simulated inventory data using session (so the data persists while the session is active)
if (!isset($_SESSION['inventory'])) {
    $_SESSION['inventory'] = [];
}

// Function to generate a unique item ID
function generateItemId() {
    return uniqid('item_', true); // Generates a unique ID prefixed with 'item_'
}

// Handle form submission to add new items
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_item'])) {
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $sale_price = $_POST['sale_price'];

    // Add the item to the inventory (in the session)
    $_SESSION['inventory'][] = [
        'item_id' => generateItemId(), // Generate unique item ID
        'item_name' => htmlspecialchars($item_name), // Sanitize user input
        'quantity' => intval($quantity), // Ensure quantity is an integer
        'sale_price' => floatval($sale_price), // Ensure sale price is a float
        'last_updated' => date('Y-m-d H:i:s')
    ];

    echo "<p>New item added successfully!</p>";
}

// Handle item removal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_item'])) {
    $index = $_POST['item_index'];
    if (isset($_SESSION['inventory'][$index])) {
        array_splice($_SESSION['inventory'], $index, 1); // Remove the item at the given index
        echo "<p>Item removed successfully!</p>";
    } else {
        echo "<p>Item not found!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome to the Inventory System</h2>

    <!-- Form to add a new item -->
    <h3>Add New Item</h3>
    <form method="post">
        <input type="hidden" name="add_item" value="1">
        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" id="item_name" required><br>
        
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" required><br>
        
        <label for="sale_price">Sale Price:</label>
        <input type="number" step="0.01" name="sale_price" id="sale_price" required><br>
        
        <button type="submit">Add Item</button>
    </form>

    <!-- Inventory Table -->
    <h3>Current Inventory</h3>
    <table border="1">
        <tr>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Sale Price ($)</th>
            <th>Last Updated</th>
            <th>Action</th>
        </tr>
        <?php if (!empty($_SESSION['inventory'])) { ?>
            <?php foreach ($_SESSION['inventory'] as $index => $item) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['item_id']); ?></td>
                    <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td><?php echo "$" . htmlspecialchars(number_format($item['sale_price'], 2)); ?></td> <!-- Display Sale Price with two decimal places -->
                    <td><?php echo htmlspecialchars($item['last_updated']); ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="remove_item" value="1">
                            <input type="hidden" name="item_index" value="<?php echo $index; ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6">No inventory items yet.</td>
            </tr>
        <?php } ?>
    </table>

    <br><a href="logout.php">Logout</a>
</body>
</html>
