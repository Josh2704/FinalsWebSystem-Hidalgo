<?php

session_start();
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'functions.php';

$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $last = trim($_POST['last_name'] ?? '');
    $first = trim($_POST['first_name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $contact = trim($_POST['contact'] ?? '');
    $school = trim($_POST['school_office'] ?? '');
    $purpose = in_array($_POST['purpose'] ?? '', ['inquiry','exam','visit','others']) ? $_POST['purpose'] : 'others';
    $visit_date = $_POST['visit_date'] ?? date('Y-m-d');
    $visit_time = $_POST['visit_time'] ?? date('H:i:s');

    if($last === '') $errors[] = "Last name is required.";
    if($first === '') $errors[] = "First name is required.";

    if(empty($errors)){
        $ok = addVisitor([
            'last_name'=>$last,
            'first_name'=>$first,
            'address'=>$address,
            'contact'=>$contact,
            'school_office'=>$school,
            'purpose'=>$purpose,
            'visit_date'=>$visit_date,
            'visit_time'=>$visit_time
        ]);
        if($ok){
            header('Location: dashboard.php?msg=added');
            exit;
        } else {
            $errors[] = "Unable to save. Try again.";
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>New Visitor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h4>New Visitor</h4>
    <?php if($errors): ?>
      <div class="alert alert-danger">
        <ul><?php foreach($errors as $e) echo "<li>".htmlspecialchars($e)."</li>"; ?></ul>
      </div>
    <?php endif; ?>
    <form method="post" novalidate>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label>Last Name</label>
          <input name="last_name" class="form-control" required value="<?= isset($last)?htmlspecialchars($last):'' ?>">
        </div>
        <div class="col-md-6 mb-3">
          <label>First Name</label>
          <input name="first_name" class="form-control" required value="<?= isset($first)?htmlspecialchars($first):'' ?>">
        </div>
      </div>

      <div class="mb-3">
        <label>Address</label>
        <input name="address" class="form-control" value="<?= isset($address)?htmlspecialchars($address):'' ?>">
      </div>

      <div class="row">
        <div class="col-md-4 mb-3">
          <label>Contact #</label>
          <input name="contact" class="form-control" value="<?= isset($contact)?htmlspecialchars($contact):'' ?>">
        </div>
        <div class="col-md-4 mb-3">
          <label>School / Office</label>
          <input name="school_office" class="form-control" value="<?= isset($school)?htmlspecialchars($school):'' ?>">
        </div>
        <div class="col-md-4 mb-3">
          <label>Purpose</label>
          <select name="purpose" class="form-select">
            <option value="inquiry">Inquiry</option>
            <option value="exam">Exam</option>
            <option value="visit">Visit</option>
            <option value="others" selected>Others</option>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 mb-3">
          <label>Visit Date</label>
          <input name="visit_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>">
        </div>
        <div class="col-md-4 mb-3">
          <label>Visit Time</label>
          <input name="visit_time" type="time" class="form-control" value="<?= date('H:i') ?>">
        </div>
      </div>

      <button class="btn btn-primary">Save</button>
      <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</body>
</html>
