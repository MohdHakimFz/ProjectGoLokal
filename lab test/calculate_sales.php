<?php
// Ini adalah coding untuk connectkan coding with database
$conn = new mysqli('localhost', 'root', '', 'sales_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// dapatkan form data setelah user key in data
$id = $_POST['id'];
$name = $_POST['name'];
$month = $_POST['month'];
$sales_amount = $_POST['sales_amount'];

// tambah css dalam php agar lebih nampak php itu lebih menarik seperti html
$css = "
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        p {
            font-size: 18px;
            line-height: 1.6;
        }
        .success-message {
            color: #28a745;
            font-weight: bold;
        }
        .error-message {
            color: #dc3545;
            font-weight: bold;
        }
        .back-button {
            display: block;
            width: 95%;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            text-align: center;
            cursor: pointer;
            margin-top: 20px;
            text-decoration: none;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
";

// Ini memanggil style css yang telah saya createkan
echo $css;

// Check Sekiranya id ada atau tidak.
$check_sql = "SELECT * FROM sales WHERE id = '$id'";
$result = $conn->query($check_sql);

echo '<div class="container">';
if ($result->num_rows > 0) {
    // Jika Id Itu Sudah Ada Maka Ia Akan Muncul Error Message
    echo "<p class='error-message'>Error: ID already exists. Please use a different ID.</p>";
} else {
    // Ini Calculate Based On Commission yang telah diberikan
    if ($sales_amount >= 1 && $sales_amount <= 2000) {
        $commission_rate = 0.05;
    } elseif ($sales_amount >= 2001 && $sales_amount <= 5000) {
        $commission_rate = 0.06;
    } elseif ($sales_amount >= 5001 && $sales_amount <= 7000) {
        $commission_rate = 0.08;
    } else {
        $commission_rate = 0.15;
    }

    // Formula Calculate The Commission 
    $commission = $sales_amount * $commission_rate;

    // Data Akan Masukkan Ke Dalam Database
    $sql = "INSERT INTO sales (id, name, month, sales_amount, commission) VALUES ('$id', '$name', '$month', '$sales_amount', '$commission')";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success-message'>Record added successfully!</p>";

        // Muncul Segala Result User Yang Telah Key In Tadi
        echo "<h2>Sales Commission</h2>";
        echo "<p><strong>ID:</strong> $id</p>";
        echo "<p><strong>Name:</strong> $name</p>";
        echo "<p><strong>Month:</strong> $month</p>";
        echo "<p><strong>Sales Amount:</strong> RM " . number_format($sales_amount, 2) . "</p>";
        echo "<p><strong>Sales Commission:</strong> RM " . number_format($commission, 2) . "</p>";
    } else {
        echo "<p class='error-message'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Tutup Connection
$conn->close();

// Saya Menambahkan Button Balik Ke Sales.HTML Agar memudahkan user balik utk key in data baru
echo '<a href="sales.html" class="back-button">Back to Form</a>';
echo '</div>';
