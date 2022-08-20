<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LETSTALK</title>
    <link rel="stylesheet" href="partials/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
    <?php include 'partials/header.php';?>
    <?php include 'partials/dbconnect.php';?>
    <?php
        $id=$_GET['threadid'];
        $sql="SELECT * FROM `threads` WHERE thread_id=$id";
        $result=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_assoc($result))
        {
            $title=$row['thread_title'];
            $desc=$row['thread_desc'];
            $thread_user_id=$row['thread_user_id'];
            $sql2="SELECT user_email FROM `users` where sno='$thread_user_id'";
            $result2=mysqli_query($conn,$sql2);
            $row2=mysqli_fetch_assoc($result2);
            $posted_by=$row2['user_email'];

        }
    ?>
    <?php
        $showAlert=false;
        $method=$_SERVER['REQUEST_METHOD'];
        if($method=='POST')
        {
            //Insert in comment db
            $comment=$_POST['comment'];
            $sno = $_POST['sno']; 
            $sql="INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_tiime`) VALUES ('$comment', '$id', '$sno', current_timestamp());";
            $result=mysqli_query($conn,$sql);
            $showAlert=true;
            if($showAlert)
            {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Your thread has been added! Please wait for community to respond
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                  </div>';
            }
        }

    ?>
    <!-- slider starts here -->
    <div class="container">
        <div class="jumbotron bg-secondary text-white">
            <h1 class="display-4 text-center"><?php echo  $title;?></h1>
            <p class="lead text-center"><?php echo "$desc"?></p>
            <hr class="my-4">
            <p class="text-center"><?php echo $desc;?></p>
            <div class="text-center">
                <p><b>POSTED BY:<?php echo $posted_by;?></b></p>
            </div>
        </div>
    </div>
    <?php
    
    if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true)
    {
        echo'<div class="container">
            <h1 class="text-center mt-3">GIVE YOUR PERSPECTIVE</h1>
            <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
    
                <div class="form-group">
                    <label for="exammpleInputdesc"><b>Post your reply here</b></label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    <input type="hidden" name="sno" value="'. $_SESSION["sno"]. '">
                </div>
                <button type="submit" class="btn btn-success my-2">Submit</button>
            </form>
        </div>';
    }
    else
    {
        echo'
        <h1 class="text-center mt-3">GIVE YOUR PERSPECTIVE</h1>
        <div class="alert alert-danger d-flex align-items-center lead mx-auto" style="width: 1000px;" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </svg>
        <div>
        <strong>YOU ARE NOT LOGGED IN!</strong>
          Please login to continue
        </div>
      </div>';
    }
    ?>
    <div class="container">
        <h1 class="text-center mt-3">Discussion</h1>
        <?php
            $id=$_GET['threadid'];
            $sql="SELECT * FROM `comments` WHERE thread_id=$id";
            $result=mysqli_query($conn,$sql);
            $noresult=true;
            while($row=mysqli_fetch_assoc($result))
            {
                $noresult=false;
                $id=$row['comment_id'];
                $content=$row['comment_content'];
                $comment_time=$row['comment_tiime'];
                $thread_user_id=$row['comment_by'];
                $sql2="SELECT user_email FROM `users` where sno='$thread_user_id'";
                $result2=mysqli_query($conn,$sql2);
                $row2=mysqli_fetch_assoc($result2);

                echo'<div class="media my-3">
                <img class="align-self-start mr-3" src="img/defaultuser.png" width="54px" alt="Generic placeholder image">
                <div class="media-body">
                <p class="fw-bold my-0">'.$row2['user_email'].' <br>At:'.$comment_time.'</p>
                    '.$content.'
                    
                    
                </div>
            </div>';
            
            }
            if($noresult)
            {
                echo'<div class="jumbotron jumbotron-fluid">
                <div class="container">
                  <h1 class="display-4">No Queries Found</h1>
                  <p class="lead">Be the first one!</p>
                </div>
              </div>';
            }
        ?>



    </div>
    <?php include 'partials/footer.php';?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
        integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js"
        integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous">
    </script>
</body>

</html>