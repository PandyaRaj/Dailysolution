<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
    #ques {
        min-height: 433px;
    }
    </style>
    <title>Welcome to iDiscuss - Coding Forums</title>
</head>

<body>
    <?php include 'partial/dbconn.php';?>
    <?php include 'partial/header.php';?>
    <?php
     $tid=$_GET['threadid'];
     $sql = "SELECT * FROM `threads` WHERE thread_id=$tid"; 
     $result = mysqli_query($conn, $sql);
     
     while($row = mysqli_fetch_assoc($result)){
         $tid=$row['thread_id'];
         $title=$row['thread_title'];
         $desc=$row['thread_desc'];
        $thread_user_id=$row['thread_user_id'];
        $sqll = "SELECT useremail FROM `users` WHERE sno=$thread_user_id"; 
        $resultt = mysqli_query($conn, $sqll);
        $roww = mysqli_fetch_assoc($resultt);
        $posted_by = $roww['useremail'];
     }
     
    ?>
    <?php
    $th_id=$_GET['threadid'];
    $showelert=false;
    $method=$_SERVER['REQUEST_METHOD'];
    if($method == 'POST'){
        //insert into thread into db
        $comment=$_POST['comment'];
        $comment = str_replace("<", "&lt;", $comment);
        $comment = str_replace(">", "&gt;", $comment );
        $sno=$_POST['sno'];
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_time`, `comment_by`) VALUES ('$comment', '$th_id', current_timestamp(), '$sno');";
        $result = mysqli_query($conn, $sql); 
        $showelert = true;
        if($showelert){
            echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success! </strong>Your Comment Has Been Added.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
        }
    }


    ?>
    <div class="container my-4">
        <div class="jumbotron">

            <h1 class="display-4"><?php  echo $title; ?></h1>
            <p class="lead"><?php  echo $desc; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not allowed. Do not
                post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post
                questions. Remain respectful of other members at all times.</p>
            <p><b>Posted By: <?php  echo $posted_by; ?></b></p>
        </div>


    </div>
    <?php
     if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    echo  '<div class="container">
        <form name="myform" action="' .$_SERVER["REQUEST_URI"]. '" onsubmit="return validateForm()" method="post" required>
            <h1>Post Your Comment</h1>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Type your Comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="' .$_SESSION["sno"]. '">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>';
     }else{
        echo '<div class="container">
        <h1>Post Your Comment</h1>
            <div class="alert alert-secondary" role="alert">
            <p class="mb-0">You are not loggedin please login to be able to Post a Comments.</p>            
          </div>
        
        </div>'; 
     }
    ?>
    <div class="container my-4" id="ques">
        <h2 class="text-center my-4">iDiscuss - Browse Categories</h2>
        <div class="row my-4">
          <!-- Fetch all the categories and use a loop to iterate through categories -->
          <?php 
         $tid=$_GET['threadid'];
         $sql = "SELECT * FROM `comments` WHERE thread_id=$tid"; 
         $result = mysqli_query($conn, $sql);
         $noresult = true;
         while($row = mysqli_fetch_assoc($result)){
             $noresult=false;
             $content=$row['comment_content'];
             $id=$row['comment_id'];
             $thread_user_id=$row['comment_by'];
             $sqll = "SELECT useremail FROM `users` WHERE sno=$thread_user_id"; 
             $resultt = mysqli_query($conn, $sqll);
             $roww = mysqli_fetch_assoc($resultt);
             $user_emaill = $roww['useremail'];
          echo '<div class="col-md-6 my-2">
          <div class="media my-4 ">
                <img src="img/user.png" width="54px" class="mr-3" alt="...">
                <div class="media-body">
                 
                  '. $content. '
                  <p class="font-weight-n my-normal">Asked By ' .$user_emaill .'</p>
                  </div>
              </div>
              </div>';
         } 
         if($noresult){
        
            echo '<div class="jumbotron jumbotron-fluid col-sm-12 col-md-12"">
         <div class="container col-sm-12 col-md-12 ">
             <p class="display-4">No Result Found</p>
                 <p class="lead">Be The First Person To Ask a question</p>
             </div>
         </div>';
         }
    
        ?>
      </div>    
    </div>
    
    



    </div>
    <!-- Opttaiional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
 <script>
    function validateForm() {
  var x = document.forms["myform"]["comment"].value;
  if (x == "") {
    alert("Name must be filled out");
    return false;
  }
}
</script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>

</html>