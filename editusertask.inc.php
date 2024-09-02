

<?php 
session_start();

if( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true ){

    header("Location:login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       
    $action  =  $_POST['action'];

                $userId      = $_POST['user_id'];
                $taskId      = $_POST['task_id'];
                $title       = $_POST['title'];
                $description = $_POST['description'];
                $status      = $_POST['status'];

            try {
                require_once "dbh.inc.php";
                if($action == 'edit'){
                $query = "UPDATE userActivity SET title = ?, description = ?, status = ? WHERE taskId = ? AND userId = ?;";
                $stmt = $pdo->prepare($query);
                // var_dump($query, [$title, $description, $status, $taskId, $userId]);

                $stmt->execute([$title, $description, $status, $taskId,$userId]);
            
                header("Location: showuserstask.php?update=success");
                exit();
                }
            } catch (PDOException $e) {
                die("Update Failed: " . $e->getMessage());
            }
}


