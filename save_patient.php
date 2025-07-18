<?php
// File path to store JSON
$file = "sample.txt";

// Read existing data from file
if (file_exists($file)) {
    $jsonData = file_get_contents($file);
    $patients = json_decode($jsonData, true);
    if (!is_array($patients)) {
        $patients = [];
    }
} else {
    $patients = [];
}

// 🔸 Find the highest existing ID
$lastId = 0;
foreach ($patients as $patient) {
    if (isset($patient['id']) && is_numeric($patient['id']) && $patient['id'] > $lastId) {
        $lastId = $patient['id'];
    }
}
$newId = $lastId + 1; // auto-increment ID

// 🔹 Get new patient data from POST
$newPatient = [
    "id" => $newId,
    "name" => $_POST['name'] ?? '',
    "mobile" => $_POST['mobile'] ?? '',
    "dob" => $_POST['dob'] ?? '',
    "gender" => $_POST['gender'] ?? '',
    "issue" => $_POST['issue'] ?? [],
    "entry_date" => $_POST['entry_date'] ?? ''
];

// 🔹 Add to existing list
$patients[] = $newPatient;

// 🔹 Save back to file
file_put_contents($file, json_encode($patients, JSON_PRETTY_PRINT));

// 🔹 Confirm
echo "Patient record saved successfully with ID: $newId<br>";
echo "<a href='addPatient.php'>Add another</a>";
