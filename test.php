<?php
session_start();
$servername = "localhost";
$dbname     = "delft_test";
$username   = "root";
$password   = "";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];
    $data = json_decode($_POST["data"], true);
    
    try {
        $stmt = $conn->prepare("UPDATE vragen SET vraag = :vraag, antwoord1 = :antwoord1, antwoord2 = :antwoord2,
                                antwoord3 = :antwoord3, antwoord4 = :antwoord4, vak = :vak, hoofdstuk = :hoofdstuk,
                                niveau = :niveau, graad = :graad WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':vraag', $data['vraag']);
        $stmt->bindParam(':antwoord1', $data['antwoord1']);
        $stmt->bindParam(':antwoord2', $data['antwoord2']);
        $stmt->bindParam(':antwoord3', $data['antwoord3']);
        $stmt->bindParam(':antwoord4', $data['antwoord4']);
        $stmt->bindParam(':vak', $data['vak']);
        $stmt->bindParam(':hoofdstuk', $data['hoofdstuk']);
        $stmt->bindParam(':niveau', $data['niveau']);
        $stmt->bindParam(':graad', $data['graad']);
        $stmt->execute();
        echo "Data updated successfully for ID: $id.";
    } catch (PDOException $e) {
        echo "Error updating data: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
