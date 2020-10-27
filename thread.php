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
    $id=$_GET['catid'];
    $sql = "SELECT * FROM `cate` WHERE id=$id"; 
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $catname=$row['name'];
        $catdes=$row['description'];
        $cattitle=$row['name'];
    }

    ?>
    <?php
    $showelert=false;
    $method=$_SERVER['REQUEST_METHOD'];
    if($method == 'POST'){
        //insert into thread into db
        $th_title=$_POST['title'];
        $th_desc=$_POST['desc'];
        
        $th_title = str_replace("<", "&lt;",  $th_title);
        $th_title= str_replace(">", "&gt;", $th_title);

        $th_desc =  str_replace("<", "&lt;", $th_desc);
        $th_desc= str_replace(">", "&gt;", $th_desc);
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql); 
        $showelert = true;
        if($showelert){
            echo '<div class="alert alert-success fade show my-0" role="alert">
            <strong>Success! </strong>Your Thread has been Added Please Wait for Community to respond.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
        }
    }


  
    echo '<div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php  echo $catname; ?> forms</h1>
            <p class="lead"><?php echo $catdes ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not allowed. Do not
                post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post
                questions. Remain respectful of other members at all times.</p>

            <a class="btn btn-success btn-lg"  href="https://en.wikipedia.org/wiki/' .$cattitle.'" role="button">Learn more</a>
        </div>
    </div>';
    ?>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    echo  '<div class="container">
    <h1>Start a Discussion</h1>
    <form name="myform" action="' .$_SERVER["REQUEST_URI"]. '"  onsubmit="return validateForm()" method="post" required>
    <div class="form-group">
        <label for="exampleInputEmail1">Problem Title</label>
        <input type="text" class="form-control" id="Title" name="title" aria-describedby="emailHelp">
        <small id="emailHelp" class="form-text text-muted">Keep your title as short and crip as
            possible</small>
    </div>
    <input type="hidden" name="sno" value="' .$_SESSION["sno"]. '">
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Ellabrote Your concern</label>
        <textarea type="text" class="form-control" id="desc" name="desc" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
    </form>

    </div>';
    }
    else{
        echo '<div class="container">
        <h1>Start a Discussion</h1>
            <div class="alert alert-secondary" role="alert">
            <p class="mb-0">You are not loggedin please login to be able to start a discussion</p>
            
          </div>
        
        </div>'; 
       
    }
    ?>
    
    <div class="container my-4" id="ques">
        <h2 class="text-center my-4">Browse Question</h2>
        <div class="row my-4 ">
          <!-- Fetch all the categories and use a loop to iterate through categories -->
          <?php 

         $id=$_GET['catid'];
         $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id "; 
         $page_id='';
         $result = mysqli_query($conn, $sql);
         $no_of_result=mysqli_num_rows($result);

         $noresult = true;
         while($row = mysqli_fetch_assoc($result)){
            $noresult=false;
            $tid=$row['thread_id'];
            $title=$row['thread_title'];
            $desc=$row['thread_desc'];
            $thread_user_id=$row['thread_user_id'];
            $sqll = "SELECT * FROM `users` WHERE sno=$thread_user_id "; 
            $resultt = mysqli_query($conn, $sqll);
            $roww = mysqli_fetch_assoc($resultt);
            $user_email = $roww['useremail'];
          echo '<div class="media my-4 col-sm-4 col-md-6 ">

          <img src="img/user.png" width="54px" class="mr-3" alt="...">
          <div class="media-body">
           <h5 class="mt-0 my-0 mx-0"><a class="text-dark" href="threadlist.php?threadid=' .$tid. '">'. $title.'</a></h5>
            '. $desc. ' <p class="font-weight-normal my-0">Asked By' .$user_email.'</p>
           
            </div>
        </div>';
      
         }        
        if($noresult){
        
           echo '<div class="jumbotron jumbotron-fluid col-sm-12 col-md-12">
        <div class="container">
            <p class="display-4">No Result Found</p>
                <p class="lead">Be The First Person To Ask a question</p>
            </div>
        </div>';
        }
           
    ?>
    </div>    
    </div>

  


    <!-- Opttaiional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

<script>
function validateForm() {
  var x = document.forms["myform"]["title"].value;
  if (x == "" || x == null) {
    alert("Name must be filled out");
    return false;
  }
}
</script>
<script>
function validateForm() {
  var x = document.forms["myform"]["desc"].value;
  if (x == "" || x == null) {
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
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="pagination.js"></script>

</body>

</html>