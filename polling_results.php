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
    $polling_unit_uniqueid = $_POST['polling_unit_uniqueid'];

    $sql = "SELECT polling_unit_uniqueid, party_abbreviation, party_score FROM announced_pu_results WHERE polling_unit_uniqueid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $polling_unit_uniqueid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "Polling Unit ID: " . $row["polling_unit_uniqueid"]. " - Party: " . $row["party_abbreviation"]. " - Score: " . $row["party_score"]. "<br>";
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
    <h1>Enter Polling Unit Unique ID</h1>
    <form method="post">
        <label for="polling_unit_uniqueid">Polling Unit Unique ID:</label><br>
        <input type="number" id="polling_unit_uniqueid" name="polling_unit_uniqueid"><br>
        <input type="submit">
    </form>
</body>
</html>
