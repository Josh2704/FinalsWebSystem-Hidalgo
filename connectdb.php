<?php
// connectdb.php
const HOST = 'localhost';
const USER = 'root';
const PWD  = '';
const DBNAME = 'ccdidb';

function Connect(){
    $conn = new mysqli(HOST, USER, PWD,DBNAME);
    if($conn->connect_error){
        die('Error Connection: ' . $conn->connect_error);
    }
    $conn->set_charset('utf8mb4');
    return $conn;
}
