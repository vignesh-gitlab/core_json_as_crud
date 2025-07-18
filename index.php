<?php
$jsonData = file_get_contents("sample.txt");
$patients = json_decode($jsonData, true);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Table</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="col-sm-10">
<h2 style="text-align:center;">Patient Records</h2>
<button class="btn btn-primary" id="add">Add</button>
<button class="btn btn-secondary" id="view">View</button>

<table class="table table-bordered" style="margin-top: 20px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>DOB</th>
            <th>Gender</th>
            <th>Issues</th>
            <th>Entry Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($patients != null) {
            $i = 1;
         foreach ($patients as $patient){ ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= htmlspecialchars($patient['name']) ?></td>
                <td><?= htmlspecialchars($patient['mobile']) ?></td>
                <td><?= htmlspecialchars($patient['dob']) ?></td>
                <td><?= htmlspecialchars($patient['gender']) ?></td>
                <td><?= htmlspecialchars(implode(", ", $patient['issue'])) ?></td>
                <td><?= htmlspecialchars($patient['entry_date']) ?></td>
                <td class="action-btns">
                    <a href="edit.php?id=<?= $patient['id'] ?>" class="btn btn-warning">Edit</a>
                    <a href="delete.php?id=<?= $patient['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                </td>
            </tr>
        <?php 
        $i++;
        } 
        } else { ?>
        <tr><td colspan="8" style="text-align: center;">No Data Found in JSON</td>
            <?php 
        }
        ?>
    </tbody>
</table>

 </div>
</div>
<script>

$('#add').click(function(){
    window.location.href = "addPatient.php"
});

$('#view').click(function(){
    window.location.href = "view.php"
});

</script>
</body>
</html>
