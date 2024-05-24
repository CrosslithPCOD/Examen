<?php
session_start();
$servername = "localhost";
$dbname     = "delft_test";
$username   = "root";
$password   = "";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Function to extract and display text files from a ZIP archive
// Function to process the content of a text file and insert or update data into SQL table
// Check if a ZIP file is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["zip_file"])) {
    $zipFilename = $_FILES["zip_file"]["tmp_name"];
    $zip = new ZipArchive();
    if ($zip->open($zipFilename) === TRUE) {
        // Create a temporary directory to extract files
        $tempDir = tempnam(sys_get_temp_dir(), 'txtfiles');
        unlink($tempDir); // Delete the temporary file and replace it with a directory
        mkdir($tempDir);
        
        // Extract files to the temporary directory
        $zip->extractTo($tempDir);
        
        // Loop through extracted files and process their contents
        $files = scandir($tempDir);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'txt') {
                $filePath = $tempDir . '/' . $file;
                $fileContent = file_get_contents($filePath);
                
                // Process file content and insert or update data in SQL table
                $data = [];
                preg_match_all('/:(.*?):\s*(.*?)\s*(?=\r?\n:|$)/s', $fileContent, $matches, PREG_SET_ORDER);
                foreach ($matches as $match) {
                    $data[$match[1]] = trim($match[2]);
                }
                
                // Check if 'vraag' key exists
                if (isset($data['vraag']) && !empty($data['vraag'])) {
                    // Insert or update data into SQL table
                    try {
                        // Check if the ID exists in the SQL table
                        $id = $data['id'];
                        $query = $conn->prepare("SELECT * FROM vragen WHERE id = :id");
                        $query->bindParam(':id', $id);
                        $query->execute();
                        $existingRecord = $query->fetch(PDO::FETCH_ASSOC);
                        
                        if ($existingRecord) {
                            // Update existing record
                            $stmt = $conn->prepare("UPDATE vragen SET vraag = :vraag, antwoord1 = :antwoord1, antwoord2 = :antwoord2,
                                        antwoord3 = :antwoord3, antwoord4 = :antwoord4, vak = :vak, hoofdstuk = :hoofdstuk,
                                        niveau = :niveau, graad = :graad WHERE id = :id");
                        } else {
                            // Insert new record
                            $stmt = $conn->prepare("INSERT INTO vragen (id, vraag, antwoord1, antwoord2, antwoord3, antwoord4, vak, hoofdstuk, niveau, graad)
                                        VALUES (:id, :vraag, :antwoord1, :antwoord2, :antwoord3, :antwoord4, :vak, :hoofdstuk, :niveau, :graad)");
                        }
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
                        if ($existingRecord) {
                            echo "Data updated successfully for ID: $id.<br>";
                        } else {
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
        // Close and delete the temporary directory
        $zip->close();
        array_map('unlink', glob("$tempDir/*"));
        rmdir($tempDir);
    } else {
        echo "Failed to open zip archive";
    }
    exit;
}

// Specify the folder path where you want to save the .txt files
$folderPath = "txtfiles/";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_files"])) {
    try {
        // Execute the query using PDO
        $stmt = $conn->query("SELECT * FROM vragen");
        $zip = new ZipArchive();
        $zipFilename = "txtfiles.zip";
        
        if ($zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $entryId = $row['id']; // Assuming 'id' is the column name for entry ID
                $filename = $folderPath . $entryId . '.txt';
                
                // Write data to the file
                $fh = fopen($filename, 'w');
                foreach ($row as $key => $value) {
                    fwrite($fh, ':' . $key . ":\n"); // Write key surrounded by double quotes
                    fwrite($fh, $value . "\n"); // Write value
                }
                fclose($fh);
                
                // Add the file to the zip archive
                $zip->addFile($filename, basename($filename));
            }
            $zip->close();
            
            // Redirect to the zip file
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
    <title>Export Txt File Test</title>
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
