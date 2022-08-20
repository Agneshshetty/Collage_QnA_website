<?php
    $showError="false";
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        include 'dbconnect.php';
        $user_email=$_POST['signupemail'];
        $pass=$_POST['signuppassword'];
        $cpass=$_POST['signupcpassword'];
        //check if this mail exist
        $existSql = "SELECT * FROM `users` WHERE user_email='$user_email'";
        $result = mysqli_query($conn, $existSql);
        $numRows = mysqli_num_rows($result);
        if($numRows>0){
            $showError="Email  alredy Exist";
        }
        else
        {
            if($pass==$cpass)
            {
                $hash=password_hash($pass,PASSWORD_DEFAULT);
                $sql="INSERT INTO `users`(`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email','$hash',current_timestamp())";
                $result=mysqli_query($conn,$sql);
                if($result)
                {
                    $showAlert=true;
                    header("Location: /forum/index.php?signupsuccess=true");
                    exit();
                }
            }
            else
            {
                $showError="Password and Confirm Password Must be similar";
                header("Location: /forum/index.php?signupsuccess=false&error=$showError");
            }
        }
        header("Location: /forum/index.php?signupsuccess=false&error=$showError");
    }
?>