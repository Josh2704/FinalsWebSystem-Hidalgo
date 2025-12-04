<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

require_once 'functions.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    deleteVisitor($id);
}

header("Location: dashboard.php");
exit;
