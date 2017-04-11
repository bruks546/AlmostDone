<?php
    require("password.php");
    $con = mysqli_connect("localhost:3306", "id1346251_franssen", "389881", "id1346251_login");
    
    
    $name = $_POST["name"];
    $unitNum = $_POST["unitNum"];
    $username = $_POST["username"];
    $password = $_POST["password"];
     function registerUser() {
        global $connect, $name, $unitNum, $username, $password;
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $statement = mysqli_prepare($connect, "INSERT INTO user (name, unitNum, username, password) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($statement, "siss", $name, $unitNum, $username, $passwordHash);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);     
    }
    function usernameAvailable() {
        global $connect, $username;
        $statement = mysqli_prepare($connect, "SELECT * FROM user WHERE username = ?"); 
        mysqli_stmt_bind_param($statement, "s", $username);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $count = mysqli_stmt_num_rows($statement);
        mysqli_stmt_close($statement); 
        if ($count < 1){
            return true; 
        }else {
            return false; 
        }
    }
    $response = array();
    $response["success"] = false;  
    if (usernameAvailable()){
        registerUser();
        $response["success"] = true;  
    }
    
    echo json_encode($response);
?>