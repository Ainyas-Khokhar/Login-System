

<?php  
// require_once "showusers.inc.php";
session_start();

if( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true ){
    header("Location:login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Tasks</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

     <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="content.css">
    <link rel="stylesheet" href="todolist.css">

    <style>
      /* body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
} */

.task-container {
  margin-left: 150px;
    width:1000px;
    display: grid;
    grid-template-columns: 1fr 1fr 2fr 3fr 1fr 1fr;
    gap: 2px;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.task-header {
    display: contents;
    font-weight: bold;
    background-color: #ddd;
    border-bottom: 2px solid #ccc;
}

.task-row {
    display: contents;
    border-bottom: 1px solid #eee;
}

.task-cell {
    padding: 10px;
    border-right: 1px solid #ddd;
}

.task-cell:last-child {
    border-right: none;
}
.bi:hover{

color:red;
cursor: pointer;
}

.icon-btn{
    /* display:flex; */
    border-radius:10px;
    width:20px;
    height:20px;
    background-color: white;
    border: none;
    margin-left:10px;
    justify-content:center;
    aling-items:center;
}


    </style>


</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand text-light" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon bg-light"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active  text-light" aria-current="page" href="content.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  text-light" href="#">Link</a>
        </li>
       
            <?php 
            
            if($_SESSION['user_role'] == 'admin'){
              echo '<li class="nav-item dropdown">'.
                   '<a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">'.
                   ucfirst($_SESSION['user_role']).
                   '</a>'.
                   '<ul class="dropdown-menu text-light">'.
                   '<li><a class="dropdown-item" href="showusers.php">Show users</a></li>'.
                //    '<li><hr class="dropdown-divider"></li>'.
                //    '<li><a class="dropdown-item" href="deleteusers.php">Delete users</a></li>'.
                
                  //  '<li><a class="dropdown-item" href="#">Something else here</a></li>'.
                   '</ul>'.
                   '</li>';
          }
            ?>

<li>
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    ToDo List
  </button>
  <ul class="dropdown-menu">

    <li><a class="dropdown-item" href="addtask.php" id="addTas kLink">Add Task</a></li>
    <hr class="my-2">
    <li><a class="dropdown-item" href="showtask.php" id="trigger ModalLink">Show Tasks</a></li>
  </ul>
</div>

</li>
      </ul>
      

<!-- ============================================================================================================================ -->

        <!-- Button trigger modal -->
        <a href="profile.php" ><button type="button" target="_blank" class="btn  btn-outline-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  <?php
  $fullName = $_SESSION['username'];
  $nameParts = explode(' ', $fullName);
  $firstName = $nameParts[0];
   echo htmlspecialchars($firstName); 
   ?>
</button></a>

<form action="logut.inc.php"><button type="submit"  class="btn btn-outline-danger  ms-4">Log out</button></form>

</nav>


<h2 style="padding:20px;"><?php 
                            // echo htmlspecialchars();
                         ?></h2>

<div class="task-container">

        <div class="task-header">
            <div class="task-cell  border-end">userID <hr></div>
            <div class="task-cell  border-end">TaskID  <hr></div>
            <div class="task-cell  border-end">Title  <hr></div>
            <div class="task-cell  border-end">Description  <hr></div>
            <div class="task-cell  border-end">Status  <hr></div>
            <div class="task-cell  ">Action  <hr></div>
        </div>
        <?php

if( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true ){
  header("Location:login.php");
  exit();
}
        

        if($_SERVER['REQUEST_METHOD']  == 'POST'){
    
            $action  =  $_POST['action'];
            $id      =  $_POST['userid'];
    
               try {
                    require_once "dbh.inc.php";
    
                        if($action == 'show'){
                            $query  =  "SELECT taskId,userId,title,description,status FROM userActivity WHERE userId=?;";
                            $stmt   =  $pdo->prepare($query);
                            $stmt  ->  execute([$id]);
    
                            while($users = $stmt->fetch(PDO::FETCH_ASSOC)){
                             
                              
                              // print_r ($_SESSION);
                                echo <<<AINYAS
                            <div class="task-row">
                                <div class="task-cell">{$users['userId']}<hr></div>
                                <div class="task-cell">{$users['taskId']}<hr></div>
                                <div class="task-cell">{$users['title']}<hr></div>
                                <div class="task-cell">{$users['description']}<hr></div>
                                <div class="task-cell">{$users['status']}<hr></div>
                                <div class="task-cell">
                                <div style="margin-left:10px;display:flex;">


                                
                                 <button type="submit" class="icon-btn">
                                 <a href="edituserstask.php?taskid={$users['taskId']}" style="text-decoration:none;color:black;">
                                     <i class="bi bi-pencil-square" title="edit" ></i></a>
                                 </button>
                                 
                                     
                                <form action="deleteusertask.inc.php" method="post">
                                <button type="submit" name="action" value="delete" class="icon-btn">
                                        <i class="bi bi-trash3" title="delete"></i>
                                </button>
                                <input type="hidden"name="taskid" value="{$users['taskId']}">
                                </form>
                                     
                                </div><hr>
                                </div>
                            </div>
                            <!-- Repeat .task-row for additional tasks -->
                            AINYAS;
                            }
                            // header("Location:showuserstask.php");
                        }
                
               } catch (PDOException $e) {
                    die("Query Failed".$e->getMessage());
               }
        }


        ?>

<!-- <form id="editForm" action="editusertask.inc.php" method="post"></form> -->

      <!-- <script>
            function submitFormInNewTab() {
            const form = document.getElementById('editForm');
            const newWindow = window.open('', 'editusertask.inc.php');
            form.target = newWindow.name; // Set the target to the new tab
            form.submit(); // Submit the form
            }
      </script> -->
    </div>




<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- Your custom JavaScript -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>


