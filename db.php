<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname ='todo_list_dbb';

// créer la connexion

$conn = new mysqli($servername,$username,$password,$dbname);

// vérifier la connexion

if($conn->connect_error){
    die("Connextion failed: " . $conn->connect_error);
}