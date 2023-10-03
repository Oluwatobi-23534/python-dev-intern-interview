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
    $party_abbreviation = $_POST['party_abbreviation'];
    $party_score = $_POST['party_score'];

    $sql = "INSERT INTO announced_pu_results (polling_unit_uniqueid, party_abbreviation, party_score) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $polling_unit_uniqueid, $party_abbreviation, $party_score);
    $stmt->execute();

    echo "New record created successfully";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Enter Party Result for New Polling Unit</h1>
    <form method="post">
        <label for="polling_unit_uniqueid">Polling Unit Unique ID:</label><br>
        <input type="number" id="polling_unit_uniqueid" name="polling_unit_uniqueid"><br>
        <label for="party_abbreviation">Party Abbreviation:</label><br>
        <input type="text" id="party_abbreviation" name="party_abbreviation"><br>
        <label for="party_score">Party Score:</label><br>
        <input type="number" id="party_score" name="party_score"><br>
        <input type="submit">
    </form>
</body>
</html>
