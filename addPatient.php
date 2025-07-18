<!DOCTYPE html>
<html>
<head>
    <title>Add New Patient</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
    

<h2>Add New Patient</h2>

<form id="patientForm" action="save_patient.php" method="POST">
    <div class="row">
    <div class="col-md-3">
    <label for="name">Name:</label>
    </div>
    <div class="col-md-9">
    <input type="text" id="name" name="name" required />
    </div>
    </div>
    <div style="height: 10px;"></div>

    <div class="row">
    <div class="col-md-3">
    <label for="mobile">Mobile:</label>
    </div>
    <div class="col-md-9">
    <input type="text" id="mobile" name="mobile" required maxlength="10" pattern="[1-9][0-9]{9}" 
           title="Enter a valid 10-digit mobile number (cannot start with 0)" />
    </div>
    </div>
    <div style="height: 10px;"></div>

    <div class="row">
    <div class="col-md-3">
    <label for="dob">Date of Birth:</label>
    </div>
    <div class="col-md-9">
    <input type="date" id="dob" name="dob" required max="" />
    </div>
    </div>
    <div style="height: 10px;"></div>

    <div class="row">
    <div class="col-md-3">
    <label>Gender:</label>
    </div>
    <div class="col-md-9">
    <div class="gender">
        <label><input type="radio" name="gender" value="male" required /> Male</label>
        <label><input type="radio" name="gender" value="female" required /> Female</label>
    </div>
    </div>
    </div>
    <div style="height: 10px;"></div>

    <div class="row">
    <div class="col-md-3">
    <label>Issues:</label>
    </div>
    <div class="col-md-9">
    <div class="issues">
        <label><input type="checkbox" name="issue[]" value="Fever" /> Fever</label>
        <label><input type="checkbox" name="issue[]" value="Cold" /> Cold</label>
        <label><input type="checkbox" name="issue[]" value="Heart" /> Heart</label>
        <label><input type="checkbox" name="issue[]" value="Lung" /> Lung</label>
        <label><input type="checkbox" name="issue[]" value="Kidney" /> Kidney</label>
    </div>
    </div>
    </div>
    <div style="height: 10px;"></div>

    <div class="row">
    <div class="col-md-3">
    <label for="entry_date">Entry Date:</label>
    </div>
    <div class="col-md-9">
    <input type="date" id="entry_date" name="entry_date" required />
    </div>
    </div>
    <div style="height: 10px;"></div>

    <button class="btn btn-primary" type="submit">Submit</button>
    <button class="btn btn-warning" id="home">Home</button>
</form>

</div>
<script>
    // Set max date for DOB to today (no future date)
    const today = new Date().toISOString().split('T')[0];
    // document.getElementById('dob').setAttribute('max', today);
    $('#dob').attr('max',today);

    $('#patientForm').on('submit',function(e){
    // document.getElementById('patientForm').addEventListener('submit', function(e) {
        const mobile = document.getElementById('mobile').value;

        // Check for exactly 10 digits and not all zeros
        if (!/^[1-9][0-9]{9}$/.test(mobile)) {
            alert("Enter a valid 10-digit mobile number that doesn't start with 0.");
            e.preventDefault();
            return;
        }

        const checkboxes = document.querySelectorAll('input[name="issue[]"]:checked');
        if (checkboxes.length === 0) {
            alert("Please select at least one issue.");
            e.preventDefault();
            return;
        }
    });

    $('#home').click(function(){
        window.location.href = "index.php";
    })

</script>

</body>
</html>
