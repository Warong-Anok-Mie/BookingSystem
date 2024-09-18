<?php
session_start(); // Start or resume session

// Database connection parameters
$hostname = "localhost:3307"; // Update with your MySQL server address and port
$usernameDB = "root";
$password = ""; // Replace with your actual database password
$dbName = "anokmie1";

// Establishing the connection
$conn = new mysqli($hostname, $usernameDB, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if username session variable is set
if (!isset($_SESSION['username'])) {
    // Redirect to login if username is not set
    header("Location: anokmielogin.php");
    exit;
}

// Fetch table details from the database
$sql = "SELECT * FROM tables";
$result = $conn->query($sql);

$tables = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tables[$row['table_id']] = [
            'table_name' => $row['table_name'],
            'num_chairs' => $row['num_chairs'],
            'price' => $row['price'],
            'status' => $row['status'] // Fetch status from database
        ];
    }
}

// Handle form submission when table is selected
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tableNo'])) {
    $tableNo = $_POST['tableNo'];

    // Store selected table details in session
    $_SESSION['table_id'] = $tableNo;
    $_SESSION['table_name'] = $tables[$tableNo]['table_name'];
    $_SESSION['num_chairs'] = $tables[$tableNo]['num_chairs'];
    $_SESSION['price'] = $tables[$tableNo]['price'];

    // Redirect to booking confirmation page
    header("Location: bookConfirm.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <title>Warong Anok Mie Bookings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/brands.min.css" integrity="sha512-DJLNx+VLY4aEiEQFjiawXaiceujj5GA7lIY8CHCIGQCBPfsEG0nGz1edb4Jvw1LR7q031zS5PpPqFuPA8ihlRA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
<style>
    .table-selection {
        margin-top: 50px;
        padding: 30px;
        background-color: #f2f2f2;
        border-radius: 5px;
        text-align: center;
        animation: fade-in 1s ease-in;
    }

    .table.selected {
        animation: selected-animation 1s ease-in-out;
    }

    .bottom-button {
        display: none;
        margin-top: 20px;
        padding: 15px 30px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 18px;
    }

    @keyframes selected-animation {
        0% { background-color: #f4f6dc; }
        50% { background-color: #e0ebeb; }
        100% { background-color: #f4f6dc; }
    }

    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .table-options {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        grid-gap: 50px;
        justify-content: center;
    }
    

    .table {
        padding: 30px;
        background-color: #f4f6dc;
        border-radius: 10px;
        text-align: center;
        transition: transform 0.3s ease-in-out;
        box-shadow: 0 5px 10px rgba(0,0,0,0.2);
    }

    .table:hover {
        transform: scale(1.1);
    }
    .select-btn {
        margin-top: 10px;
        padding: 15px 30px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 18px;
    }

    /* Additional style for disabled button */
    .select-btn.disabled {
        background-color: #e74c3c; /* Red */
        cursor: not-allowed;
    }
</style>

</head>
<body>
    <section class="header">
        <nav class="navbar">
            <div class="brand-title">
                <img src="img/WARONG.jpg" alt="Logo" class="logo">
                Warong Anok Mie
            </div>
            <a href="#" class="toggle-button">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </a>
            <div class="navbar-links">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="anokmielogin.php" class="hero-btn book">Book a Table</a></li>
                </ul>
            </div>
        </nav>

        <h1 style="color: #FEA116; text-align: center; margin-top: 50px">Select Your Table Position</h1>
        
        <section class="table-selection">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="table-options">
                    <?php
                    // Display table options dynamically
                    foreach ($tables as $table_id => $table) {
                        $buttonClass = ($table['status'] == 'approved') ? 'select-btn disabled' : 'select-btn';
                        $buttonText = ($table['status'] == 'approved') ? 'Unavailable' : 'Select';
                        echo '<div class="table table-' . $table_id . '">';
                        echo '<h3>Table ' . $table_id . '</h3>';
                        echo '<p>' . $table['num_chairs'] . ' Chairs</p>';
                        echo '<p>Price: RM ' . number_format($table['price'], 2) . '</p>';
                        echo '<button class="' . $buttonClass . '" name="tableNo" value="' . $table_id . '" ';
                        echo ($table['status'] == 'approved') ? 'disabled' : '';
                        echo '>' . $buttonText . '</button>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </form>
        </section>

    </section>

</body>
</html>
