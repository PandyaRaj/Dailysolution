<style>
#user{
  a:hover: color: black;
}
</style>
<?php
session_start();
// if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){

// }
echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">Dailysolution</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="Categories.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Top Categories
        </a>
        <div class="dropdown-menu mt-2" aria-labelledby="navbarDropdown" >';
        
        $sql = "SELECT id, name FROM `cate` LIMIT 3"; 
        $result = mysqli_query($conn, $sql); 
        while($row = mysqli_fetch_assoc($result)){
          echo '<a class="dropdown-item" href="thread.php?catid='.$row['id'].' ">' .$row['name']. '</a>';
        }
      echo '</div>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="contact.php" tabindex="-1" aria-disabled="true">Contact</a>
      </div>
      </li>
    </ul>';
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
      echo'<div class="">
    <div class="row ">
    <form class="form-inline  my-lg-0 mr-2 method="get" action="search.php">
    <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="search">Search</button>
    
    <div class="btn-group ml-2 ">
    
    <button  type="button" class="btn btn-dark dropdown-toggle btn btn-outline-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <img src="img/us.png" height="22" width="27 pr-2"> ' .$_SESSION['useremail']. '
    </button>
    <div id="user"  " class="mt-2 dropdown-menu dropdown-menu-right" >
      <button  class="dropdown-item" type="button"><a class="text-dark text-decoration-none" href="about.php">About Us</a></button>
      <button  class="dropdown-item" type="button"><a class="text-dark text-decoration-none" href="Contact.php">Contact Us</a></button>
      <button  class="dropdown-item" type="button"><a class="text-dark text-decoration-none" href="partial/logout.php">logout</a></button>
    </div>
  </div>
   
    </form>';
    }
    else{
    echo '<div class="mr-3">
    <button class="btn btn-success mr-2 " data-toggle="modal" data-target="#loginmodal">Login</button>
    <button class="btn btn-success "  data-toggle="modal" data-target="#signupmodal">Signup</button>
    </div>
    </div>
    </div>';
    }
  echo '</div>
</nav>';
?>
<?php
include 'partial/loginmodal.php';
include 'partial/signupmodal.php';
?>
<div>
    <?php
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true"){
echo '<div class="alert alert-success fade show my-0" role="alert">
<strong>Success!</strong> You can login now.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>';


}
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "false"){
  echo '<div class="alert alert-warning fade show my-0" role="alert">
  <strong>Not Signed up</strong> Please Check Your Username Or Password.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
  
  
  }
  
?>
    <?php
if(isset($_GET['loginsuccess']) && $_GET['loginsuccess'] == "true"){
echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
<strong>Success!</strong> You are Logged in!
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>';


}
if(isset($_GET['loginsuccess']) && $_GET['loginsuccess'] == "false"){
  echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
  <strong>Not Login! </strong>.please check your email or password.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
  
  
  }
  if(isset($_GET['contactelert']) && $_GET['contactelert'] == "true"){
    echo '<div class="alert alert-success fade show my-0" role="alert">
    <strong>Success!</strong> Thank you for contacting us!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
    
    
    }
    if(isset($_GET['contacterror']) && $_GET['contacterror'] == "true"){
      echo '<div class="alert alert-warning fade show my-0" role="alert">
      <strong>Warning!</strong> Please check your detailes.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
      
      
      }
?>
</div>