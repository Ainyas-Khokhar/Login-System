
<?php
// session_start();

//     if( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true ){
//         header("Location:login.php");
//         exit();
//     }

//     if($_SERVER['REQUEST_METHOD']  == 'POST'){

//         $action  =  $_POST['action'];
//         $id      =  $_POST['userid'];

//            try {
//                 require_once "dbh.inc.php";

//                     if($action == 'show'){
//                         $query  =  "SELECT taskId,userId,title,description,status FROM userActivity WHERE userId=?;";
//                         $stmt   =  $pdo->prepare($query);
//                         $stmt  ->  execute([$id]);

                        // while($users = $stmt->fetch(PDO::FETCH_ASSOC)){
                        //     echo <<<AINYAS
                        // <div class="task-row">
                        //     <div class="task-cell">{$users['userId']}<hr></div>
                        //     <div class="task-cell">{$users['taskId']}<hr></div>
                        //     <div class="task-cell">{$users['title']}<hr></div>
                        //     <div class="task-cell">{$users['description']}<hr></div>
                        //     <div class="task-cell">{$users['status']}<hr></div>
                        //     <div class="task-cell">
                        //     <div style="margin-left:10px;">
                        //          <i class="bi bi-pencil-square" title="edit" style="margin-left:10px;"></i>
                        //          <i class="bi bi-trash3"        title="delete" style="margin-left:10px;"></i><hr>
                        //     </div>
                        //     </div>
                        // </div>
                        // <!-- Repeat .task-row for additional tasks -->
                        // AINYAS;
                        // }
                        


    //                     header("Location:showuserstask.php");
    //                 }
            
    //        } catch (PDOException $e) {
    //             die("Query Failed".$e->getMessage());
    //        }
    // }