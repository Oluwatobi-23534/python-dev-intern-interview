<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bincomphptest";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lga_id = $_POST['lga_id'];

    $sql = "SELECT SUM(party_score) as total_score FROM announced_pu_results WHERE lga_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lga_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "Total Score for LGA ID " . $lga_id . ": " . $row["total_score"]. "<br>";
        }
    } else {
        echo "0 results";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Select Local Government</h1>
    <form method="post">
        <label for="lga_id">Local Government:</label><br>
        <select id="lga_id" name="lga_id">
            <?php
            // Fetch all LGA from the 'lga' table
            $sql = "SELECT lga_id, lga_name FROM lga";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row["lga_id"] . '">' . $row["lga_name"] . '</option>';
                }
            }
            ?>
        </select><br>
        <input type="submit">
    </form>
</body>
</html>
