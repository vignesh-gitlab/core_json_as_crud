<?php
// File containing patient data
$file = "sample.txt";

// Load data
$patients = [];
if (file_exists($file)) {
    $jsonData = file_get_contents($file);
    $patients = json_decode($jsonData, true);
    if (!is_array($patients)) {
        $patients = [];
    }
}

// Search logic
$searchResults = [];
$searchQuery = $_GET['search'] ?? '';

if ($searchQuery !== '') {
    $searchResults = array_filter($patients, function ($patient) use ($searchQuery) {
        return strpos((string)$patient['mobile'], $searchQuery) !== false;
    });
} else {
    $searchResults = $patients; // show all if no search
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Patients</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="col-sm-10">

        

<h2>Search Patients</h2>

<form method="GET" action="view.php">
    <input type="text" name="search" placeholder="Enter mobile number..." value="<?= htmlspecialchars($searchQuery) ?>" />
    <button class="btn" type="submit" class="btn">Search</button> 
    <button class="btn btn-warning" id="home">Home</button>
</form>
 
<?php if (count($searchResults) > 0): ?>
    <table class="table table-bordered" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Issue</th>
                <th>Entry Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($searchResults as $patient): ?>
                <tr>
                    <td><?= htmlspecialchars($patient['id']) ?></td>
                    <td><?= htmlspecialchars($patient['name']) ?></td>
                    <td><?= htmlspecialchars($patient['mobile']) ?></td>
                    <td><?= htmlspecialchars($patient['dob']) ?></td>
                    <td><?= htmlspecialchars($patient['gender']) ?></td>
                    <td><?= htmlspecialchars(implode(", ", $patient['issue'])) ?></td>
                    <td><?= htmlspecialchars($patient['entry_date']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $patient['id'] ?>" class="btn btn-warning">Edit</a>
                        <a href="delete.php?id=<?= $patient['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No patients found.</p>
<?php endif; ?>

    </div>
</div>

<script>
        $('#home').click(function(e){
            e.preventDefault();
        window.location.href = "index.php";
    })
</script>

</body>
</html>
