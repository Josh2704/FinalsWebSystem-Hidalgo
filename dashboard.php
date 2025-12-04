


<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

require_once 'functions.php';


$from_date = $_GET['from_date'] ?? null;
$to_date   = $_GET['to_date'] ?? null;
$name      = $_GET['search_name'] ?? null;


if ($from_date || $to_date || $name) {
   
    if ($from_date && $to_date) {
        $today_visitors = getVisitors($from_date, $to_date, $name);
    } else {
        
        $today_visitors = getVisitors(null, null, $name);
    }
} else {
   
    $today_visitors = getVisitors();
}


$stats = getStats();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <style>
        body {
            background: #f4f1ea; 
            font-family: "Segoe UI", sans-serif;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .card-header {
            background: #3a3a3a !important; 
            color: #fff !important;
            font-weight: 600;
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
        }
        .btn-primary {
            background: #c5a880;   
            border-color: #b7936a;
        }
        .btn-primary:hover {
            background: #b7936a;
            border-color: #a7825c;
        }
        .btn-danger {
            background: #9e3a3a;
            border-color: #8e3333;
        }
        .btn-danger:hover {
            background: #8e3333;
        }
        .btn-secondary {
            background: #7a7a7a;
            border-color: #6a6a6a;
        }
        .table thead th {
            background: #3a3a3a;
            color: white;
            border: none;
        }
        .stats-box {
            background: white;
            border-radius: 12px;
            padding: 25px 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stats-title {
            font-weight: 600;
            color: #7a7a7a;
        }
        .stats-number {
            font-size: 2.4rem;
            font-weight: 700;
            color: #3a3a3a;
        }
        h3, h4 {
            color: #3a3a3a;
            font-weight: 700;
        }
    </style>
</head>

<body>
<div class="container mt-4">

   
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Welcome, <?= $_SESSION['fullname']; ?>!</h3>
        <a href="logout.php" class="btn btn-danger btn-sm px-4">Logout</a>
    </div>

    <a href="add.php" class="btn btn-primary mt-2 mb-3">+ New Visitor</a>

    
   
    <div class="card">
        <div class="card-header">
            <strong>Search & Filter Visitors</strong>
        </div>

        <div class="card-body">
            <form method="GET" class="row g-3">

                <div class="col-md-3">
                    <label class="form-label">From Date</label>
                    <input type="date" name="from_date"
                           class="form-control"
                           value="<?= htmlspecialchars($from_date); ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">To Date</label>
                    <input type="date" name="to_date"
                           class="form-control"
                           value="<?= htmlspecialchars($to_date); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Search Visitor Name</label>
                    <input type="text"
                           name="search_name"
                           class="form-control"
                           placeholder="Enter last name or first name"
                           value="<?= htmlspecialchars($name); ?>">
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-50">Filter</button>
                    <a href="dashboard.php" class="btn btn-secondary w-50">Reset</a>
                </div>

            </form>
        </div>
    </div>


  
    <h4 class="mt-4">
        Visitor List 
        <?php if ($from_date && $to_date): ?>
            <small class="text-muted">(<?= $from_date ?> to <?= $to_date ?>)</small>
        <?php endif; ?>
    </h4>

    
    
    <div class="table-responsive shadow-sm">
        <table class="table table-bordered table-hover bg-white">
            <thead>
            <tr>
                <th>Date</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Contact</th>
                <th>Address</th>
                <th>School/Office</th>
                <th>Purpose</th>
                <th>Time</th>
                <th width="90">Action</th>
            </tr>
            </thead>

            <tbody>
            <?php if (empty($today_visitors)): ?>
                <tr>
                    <td colspan="9" class="text-center text-muted py-3">
                        No visitors found.
                    </td>
                </tr>
            <?php endif; ?>

            <?php foreach ($today_visitors as $v): ?>
                <tr>
                    <td><?= date("d M Y", strtotime($v['visit_date'])); ?></td>
                    <td><?= $v['last_name']; ?></td>
                    <td><?= $v['first_name']; ?></td>
                    <td><?= $v['contact']; ?></td>
                    <td><?= $v['address']; ?></td>
                    <td><?= $v['school_office']; ?></td>
                    <td><?= ucfirst($v['purpose']); ?></td>
                    <td><?= date("h:i A", strtotime($v['visit_time'])); ?></td>
                    <td class="text-center">
                        <a href="delete.php?id=<?= $v['id']; ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Delete this visitor record?');">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>

    <div class="row text-center mt-4 g-3">

        <div class="col-md-4">
            <div class="stats-box">
                <div class="stats-title">TODAY</div>
                <div class="stats-number"><?= $stats['total']; ?></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stats-box">
                <div class="stats-title">EXAM</div>
                <div class="stats-number" style="color:#8e6f3e;"><?= $stats['exam']; ?></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stats-box">
                <div class="stats-title">OTHERS</div>
                <div class="stats-number" style="color:#9e3a3a;"><?= $stats['others']; ?></div>
            </div>
        </div>

    </div>

</div>
</body>
</html>
