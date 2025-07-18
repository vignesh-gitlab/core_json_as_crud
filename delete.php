<?php
// File containing the patient data
$file = "sample.txt";

// Check if an ID is provided in the query string
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid or missing ID.";
    exit;
}

$deleteId = (int)$_GET['id'];

// Read the existing data
if (file_exists($file)) {
    $jsonData = file_get_contents($file);
    $patients = json_decode($jsonData, true);
    
    if (!is_array($patients)) {
        echo "Invalid data format.";
        exit;
    }

    // Filter out the patient with the given ID
    $newData = array_filter($patients, function ($patient) use ($deleteId) {
        return $patient['id'] != $deleteId;
    });

    // Reindex array to keep it clean (optional)
    $newData = array_values($newData);

    // Save the updated list back to the file
    file_put_contents($file, json_encode($newData, JSON_PRETTY_PRINT));

    echo "<script>
    alert('Patient with ID $deleteId deleted successfully.');
    window.location.href = 'index.php';
</script>";

} else {
    echo "Data file not found.";
}
?>
