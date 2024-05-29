<?php
session_start();
$servername = "localhost";
$dbname     = "delft_test";
$username   = "root";
$password   = "";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["zip_file"])) {
    $zipFilename = $_FILES["zip_file"]["tmp_name"];
    $zip = new ZipArchive();
    if ($zip->open($zipFilename) === TRUE) {
        $tempDir = tempnam(sys_get_temp_dir(), 'txtfiles');
        unlink($tempDir);
        mkdir($tempDir);
        $zip->extractTo($tempDir);
        
        $files = scandir($tempDir);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'txt') {
                $filePath = $tempDir . '/' . $file;
                $fileContent = file_get_contents($filePath);
                
                $data = [];
                preg_match_all('/:(.*?):\s*(.*?)\s*(?=\r?\n:|$)/s', $fileContent, $matches, PREG_SET_ORDER);
                foreach ($matches as $match) {
                    $data[$match[1]] = trim($match[2]);
                }
                
                if (isset($data['vraag']) && !empty($data['vraag'])) {
                    try {
                        $id = $data['id'];
                        $query = $conn->prepare("SELECT * FROM vragen WHERE id = :id");
                        $query->bindParam(':id', $id);
                        $query->execute();
                        $existingRecord = $query->fetch(PDO::FETCH_ASSOC);
                        
                        if ($existingRecord) {
                            $differences = array_diff_assoc($data, $existingRecord);
                            if (!empty($differences)) {
                                echo "<hr>";
                                echo "Differences found for ID: $id<br>";
                                echo "<table border='1'>";
                                echo "<tr><th>Existing Record</th><th>New Data</th></tr>";
                                foreach ($existingRecord as $key => $value) {
                                    echo "<tr><td>$key: $value</td>";
                                    if (isset($data[$key])) {
                                        echo "<td>$key: " . $data[$key] . "</td></tr>";
                                    } else {
                                        echo "<td></td></tr>";
                                    }
                                }
                                echo "</table>";
                                
                                echo "<form method='post'>";
                                echo "<input type='checkbox' name='update_ids[]' value='$id'> Update ID $id<br>";
                                echo "<input type='hidden' name='data_$id' value='" . htmlspecialchars(json_encode($data)) . "'>";
                                echo "<hr>";
                            } else {
                                echo "No differences found for ID: $id. Skipping update.<br>";
                            }
                        } else {
                            $stmt = $conn->prepare("INSERT INTO vragen (id, vraag, antwoord1, antwoord2, antwoord3, antwoord4, vak, hoofdstuk, niveau, graad)
                                                    VALUES (:id, :vraag, :antwoord1, :antwoord2, :antwoord3, :antwoord4, :vak, :hoofdstuk, :niveau, :graad)");
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
                            echo "Data inserted successfully for ID: $id.<br>";
                        }
                    } catch (PDOException $e) {
                        echo "Error processing data from file: " . $e->getMessage();
                    }
                } else {
                    echo "Skipping file $file because 'vraag' is missing or empty.<br>";
                }
            }
        }
        $zip->close();
        array_map('unlink', glob("$tempDir/*"));
        rmdir($tempDir);
    } else {
        echo "Failed to open zip archive";
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm_update"])) {
    $data = json_decode($_POST["data"], true);
    $id = $_POST["id"];
    
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
        echo "Data updated successfully for ID: $id.<br>";
    } catch (PDOException $e) {
        echo "Error updating data: " . $e->getMessage();
    }
}

$folderPath = "txtfiles/";

if (!is_dir($folderPath)) {
    mkdir($folderPath, 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_files"])) {
    try {
        $stmt = $conn->query("SELECT * FROM vragen");
        $zip = new ZipArchive();
        $zipFilename = "txtfiles.zip";
        
        if ($zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $entryId = $row['id'];
                $filename = $folderPath . $entryId . '.txt';
                
                $fh = fopen($filename, 'w');
                if ($fh === false) {
                    throw new Exception("Failed to open file: $filename");
                }
                foreach ($row as $key => $value) {
                    fwrite($fh, ':' . $key . ":\n");
                    fwrite($fh, $value . "\n");
                }
                fclose($fh);
                
                $zip->addFile($filename, basename($filename));
            }
            $zip->close();
            
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipFilename . '"');
            readfile($zipFilename);
            exit;
        } else {
            echo "Failed to create zip archive";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Export Txt File Test</title>
</head>
<body>
    <h1>Export .txt File</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="submit" name="create_files" value="Create Text Files">
    </form>
    
    <h1>Import .txt Files in ZIP</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="zip_file" accept=".zip">
        <input type="submit" name="upload_zip" value="Upload ZIP">
    </form>
</body>
</html>
    