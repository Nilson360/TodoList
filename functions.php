<?php
 include_once 'db.php';
function addTask($title, $description, $due_date){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO tasks (title, description, due_date) values (?,?,?)");
    $stmt->bind_param("sss", $title, $description, $due_date);
    $stmt->execute();
}
 function deleteTask($id){
    global $conn;
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
function getTask($id){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id= ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
function updateTask($id,$title,$description,$due_date){
    global $conn;
    $stmt= $conn->prepare("UPDATE tasks SET title = ?, description = ?, due_date = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $description, $due_date, $id);
    $stmt->execute();
}
function getAllTasks(){
    global $conn;
    return $conn->query("SELECT * FROM tasks ORDER BY id DESC");
}

function msgAlert($msg){
    return "<p class='msg-alert'>$msg</p>";
}
function msgError($msg){
    return "<p class='msg-error'>$msg</p>";
}
function msgSucess($msg){
    return "<p class='msg-sucess'>$msg</p>";
}
