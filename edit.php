<?php
$file = "sample.txt";

// Validate ID from query
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid or missing ID.");
}

$editId = (int)$_GET['id'];
$patients = [];

if (file_exists($file)) {
    $jsonData = file_get_contents($file);
    $patients = json_decode($jsonData, true);

    if (!is_array($patients)) {
        die("Data is corrupt.");
    }
} else {
    die("Data file not found.");
}

// Find patient by ID
$found = false;
foreach ($patients as $index => $patient) {
    if ($patient['id'] == $editId) {
        $currentPatient = $patient;
        $patientIndex = $index;
        $found = true;
        break;
    }
}

if (!$found) {
    die("Patient with ID $editId not found.");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and get updated data
    $updatedPatient = [
        "id" => $editId,
        "name" => $_POST['name'] ?? '',
        "mobile" => $_POST['mobile'] ?? '',
        "dob" => $_POST['dob'] ?? '',
        "gender" => $_POST['gender'] ?? '',
        "issue" => $_POST['issue'] ?? [],
        "entry_date" => $_POST['entry_date'] ?? ''
    ];

    // Replace the old record
    $patients[$patientIndex] = $updatedPatient;

    // Save back to file
    file_put_contents($file, json_encode($patients, JSON_PRETTY_PRINT));

    echo "<script>alert('Patient updated successfully'); window.location.href = 'index.php';</script>";
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Patient</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">

<h2>Edit Patient ID: <?= htmlspecialchars($editId) ?></h2>

<form action="edit.php?id=<?= $editId ?>" method="POST">
    <div class="row">
    <div class="col-md-3">
    <label>Name:</label>
    </div>
    <div class="col-md-9">
    <input type="text" name="name" value="<?= htmlspecialchars($currentPatient['name']) ?>" required>
    </div>
    </div>
    <div style="height: 10px;"></div>

    <div class="row">
    <div class="col-md-3">
    <label>Mobile:</label>
    </div>
    <div class="col-md-9">
    <input type="text" name="mobile" value="<?= htmlspecialchars($currentPatient['mobile']) ?>" maxlength="10" required pattern="[1-9][0-9]{9}">
    </div>
    </div>
    <div style="height: 10px;"></div>

    <div class="row">
    <div class="col-md-3">
    <label>Date of Birth:</label>
    </div>
    <div class="col-md-9">
    <input type="date" name="dob" value="<?= htmlspecialchars($currentPatient['dob']) ?>" max="<?= date('Y-m-d') ?>" required max="">
    </div>
    </div>
    <div style="height: 10px;"></div>

    <div class="row">
    <div class="col-md-3">
    <label>Gender:</label>
    </div>
    <div class="col-md-9">
    <div class="gender">
        <label><input type="radio" name="gender" value="male" <?= $currentPatient['gender'] === 'male' ? 'checked' : '' ?>> Male</label>
        <label><input type="radio" name="gender" value="female" <?= $currentPatient['gender'] === 'female' ? 'checked' : '' ?>> Female</label>
    </div>
    </div>
    </div>
    <div style="height: 10px;"></div>

    <div class="row">
    <div class="col-md-3">
    <label>Issue:</label>
    </div>
    <div class="col-md-9">
    <div class="issue">
        <?php
        $issues = ["Fever", "Cold", "Heart", "Lung", "Kidney"];
        foreach ($issues as $issue) {
            $checked = in_array($issue, $currentPatient['issue']) ? 'checked' : '';
            echo "<label><input type='checkbox' name='issue[]' value='$issue' $checked> $issue</label>";
        }
        ?>
    </div>
    </div>
    </div>
    <div style="height: 10px;"></div>

    <div class="row">
    <div class="col-md-3">
    <label>Entry Date:</label>
    </div>
    <div class="col-md-9">
    <input type="date" name="entry_date" value="<?= htmlspecialchars($currentPatient['entry_date']) ?>" required>
    </div>
    </div>
    <div style="height: 10px;"></div>

    <button class="btn" type="submit">Update</button>
    <button class="btn btn-warning" id="home">Home</button>
</form>

    </div>

    <script>
        $('#home').click(function(e){
            e.preventDefault();
        window.location.href = "index.php";
    })
    </script>
</body>
</html>

