<?php

require_once 'connectdb.php';

function getVisitors($from_date = null, $to_date = null, $name = null){
    $conn = Connect();

    $query = "SELECT id, last_name, first_name, address, contact, school_office, purpose, visit_date, visit_time 
              FROM visitors WHERE 1=1";
    $params = [];
    $types = '';

    
    if ($from_date && $to_date) {
        $query .= " AND visit_date BETWEEN ? AND ?";
        $types .= 'ss';
        $params[] = $from_date;
        $params[] = $to_date;
    }

    
    else if (!$name) {
        $today = date('Y-m-d');
        $query .= " AND visit_date = ?";
        $types .= 's';
        $params[] = $today;
    }

    
    if ($name) {
        $query .= " AND (last_name LIKE ? OR first_name LIKE ?)";
        $types .= 'ss';
        $like = "%$name%";
        $params[] = $like;
        $params[] = $like;
    }

    $query .= " ORDER BY visit_date DESC, visit_time DESC";

    $stmt = $conn->prepare($query);
    if ($types !== '') {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $res = $stmt->get_result();
    $rows = $res->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $conn->close();
    return $rows;
}


function addVisitor($data){
    $conn = Connect();
    $stmt = $conn->prepare("INSERT INTO visitors 
      (last_name, first_name, address, contact, school_office, purpose, visit_date, visit_time)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssssss',
        $data['last_name'],
        $data['first_name'],
        $data['address'],
        $data['contact'],
        $data['school_office'],
        $data['purpose'],
        $data['visit_date'],
        $data['visit_time']
    );
    $ok = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $ok;
}

function deleteVisitor($id){
    $conn = Connect();
    $stmt = $conn->prepare("DELETE FROM visitors WHERE id = ?");
    $stmt->bind_param('i', $id);
    $ok = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $ok;
}

function getStats($date = null){
    $conn = Connect();
    if(!$date) $date = date('Y-m-d');

    $stats = ['total' => 0, 'exam' => 0, 'others' => 0];

  
    $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM visitors WHERE visit_date = ?");
    $stmt->bind_param('s', $date);
    $stmt->execute();
    $stmt->bind_result($cnt);
    if($stmt->fetch()) $stats['total'] = $cnt;
    $stmt->close();

    
    $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM visitors WHERE visit_date = ? AND purpose = 'exam'");
    $stmt->bind_param('s', $date);
    $stmt->execute();
    $stmt->bind_result($cnt2);
    if($stmt->fetch()) $stats['exam'] = $cnt2;
    $stmt->close();

    
    $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM visitors WHERE visit_date = ? AND purpose != 'exam'");
    $stmt->bind_param('s', $date);
    $stmt->execute();
    $stmt->bind_result($cnt3);
    if($stmt->fetch()) $stats['others'] = $cnt3;
    $stmt->close();

    $conn->close();
    return $stats;
}
