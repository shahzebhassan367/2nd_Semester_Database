<?php
// Database connection
$mysqli = new mysqli("localhost", "root", "", "cafe3");
if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table = $_POST['table_name'];
    switch ($table) {
        case 'Customers':
            $stmt = $mysqli->prepare("INSERT INTO Customers (name, email, phone) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $_POST['name'], $_POST['email'], $_POST['phone']);
            $stmt->execute();
            break;
        case 'Employees':
            $stmt = $mysqli->prepare("INSERT INTO Employees (name, role, salary) VALUES (?, ?, ?)");
            $stmt->bind_param("ssd", $_POST['name'], $_POST['role'], $_POST['salary']);
            $stmt->execute();
            break;
        case 'Suppliers':
            $stmt = $mysqli->prepare("INSERT INTO Suppliers (name, contact) VALUES (?, ?)");
            $stmt->bind_param("ss", $_POST['name'], $_POST['contact']);
            $stmt->execute();
            break;
        case 'Categories':
            $stmt = $mysqli->prepare("INSERT INTO Categories (category_name) VALUES (?)");
            $stmt->bind_param("s", $_POST['category_name']);
            $stmt->execute();
            break;
        case 'CafeTables':
            $stmt = $mysqli->prepare("INSERT INTO CafeTables (table_number, capacity) VALUES (?, ?)");
            $stmt->bind_param("ii", $_POST['table_number'], $_POST['capacity']);
            $stmt->execute();
            break;
        case 'Products':
            $stmt = $mysqli->prepare("INSERT INTO Products (name, price, category_id) VALUES (?, ?, ?)");
            $stmt->bind_param("sdi", $_POST['name'], $_POST['price'], $_POST['category_id']);
            $stmt->execute();
            break;
        case 'Orders':
            $stmt = $mysqli->prepare("INSERT INTO Orders (customer_id, table_id, employee_id, order_date) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiis", $_POST['customer_id'], $_POST['table_id'], $_POST['employee_id'], $_POST['order_date']);
            $stmt->execute();
            break;
        case 'OrderDetails':
            $stmt = $mysqli->prepare("INSERT INTO OrderDetails (order_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $_POST['order_id'], $_POST['product_id'], $_POST['quantity']);
            $stmt->execute();
            break;
        case 'Inventory':
            $stmt = $mysqli->prepare("INSERT INTO Inventory (product_id, quantity_in_stock) VALUES (?, ?)");
            $stmt->bind_param("ii", $_POST['product_id'], $_POST['quantity_in_stock']);
            $stmt->execute();
            break;
        case 'Payments':
            $stmt = $mysqli->prepare("INSERT INTO Payments (order_id, amount, payment_date, payment_method) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("idss", $_POST['order_id'], $_POST['amount'], $_POST['payment_date'], $_POST['payment_method']);
            $stmt->execute();
            break;
        case 'Shipments':
            $stmt = $mysqli->prepare("INSERT INTO Shipments (supplier_id, product_id, quantity, shipment_date) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiis", $_POST['supplier_id'], $_POST['product_id'], $_POST['quantity'], $_POST['shipment_date']);
            $stmt->execute();
            break;
        case 'Reviews':
            $stmt = $mysqli->prepare("INSERT INTO Reviews (customer_id, product_id, rating, comment, review_date) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiiss", $_POST['customer_id'], $_POST['product_id'], $_POST['rating'], $_POST['comment'], $_POST['review_date']);
            $stmt->execute();
            break;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cafe3 Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1 class="text-center mb-4">Cafe3 Management Dashboard</h1>

    <?php
    $tables = [
        'Customers' => ['name', 'email', 'phone'],
        'Employees' => ['name', 'role', 'salary'],
        'Suppliers' => ['name', 'contact'],
        'Categories' => ['category_name'],
        'CafeTables' => ['table_number', 'capacity'],
        'Products' => ['name', 'price', 'category_id'],
        'Orders' => ['customer_id', 'table_id', 'employee_id', 'order_date'],
        'OrderDetails' => ['order_id', 'product_id', 'quantity'],
        'Inventory' => ['product_id', 'quantity_in_stock'],
        'Payments' => ['order_id', 'amount', 'payment_date', 'payment_method'],
        'Shipments' => ['supplier_id', 'product_id', 'quantity', 'shipment_date'],
        'Reviews' => ['customer_id', 'product_id', 'rating', 'comment', 'review_date']
    ];

    foreach ($tables as $table => $fields) {
        echo "<div class='card mb-4 shadow-sm'>";
        echo "<div class='card-header bg-dark text-white fw-bold'>{$table}</div>";
        echo "<div class='card-body'>";
        echo "<form method='POST'>";
        echo "<input type='hidden' name='table_name' value='{$table}'>";
        foreach ($fields as $field) {
            echo "<div class='mb-2'><label class='form-label text-capitalize'>{$field}</label>";
            echo "<input type='text' name='{$field}' class='form-control' required></div>";
        }
        echo "<button type='submit' class='btn btn-primary'>Insert into {$table}</button>";
        echo "</form><hr>";

        // Display existing records
        $result = $mysqli->query("SELECT * FROM $table LIMIT 5");
        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered table-sm mt-3'><thead><tr>";
            while ($field = $result->fetch_field()) {
                echo "<th>{$field->name}</th>";
            }
            echo "</tr></thead><tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $col) echo "<td>{$col}</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='text-muted'>No records found.</p>";
        }

        echo "</div></div>";
    }

    $mysqli->close();
    ?>
</div>
</body>
</html>
