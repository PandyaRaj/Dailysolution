<?php
$showerror="false";
$showelert="false";
if($_SERVER["REQUEST_METHOD"] ==  "POST"){
        include 'dbconn.php';
        $loginemail=$_POST['loginemail'];
        $pass=$_POST['loginpass'];
        $loginemail = str_replace("<", "&lt;", $loginemail);
        $loginemail = str_replace(">", "&gt;", $loginemail);
        $pass = str_replace("<", "&lt;", $pass);
        $pass = str_replace(">", "&gt;", $pass );
        $existsql="SELECT * FROM `users` WHERE useremail='$loginemail'";
        $result = mysqli_query($conn, $existsql);
        $numrow=mysqli_num_rows($result);
        if($numrow==1){
           $row = mysqli_fetch_assoc($result);
          if(password_verify($pass, $row['user_pass'])){
            session_start();
            $_SESSION['loggedin']=true;
            $_SESSION['sno']= $row['sno'];
            $_SESSION['useremail']=$loginemail;
            $showelert=true;
            header("Location: /forms/index.php?loginsuccess=true");
          }
          else{
              $showerror=true;
              header("Location: /forms/index.php?loginsuccess=false");
          }
        }
        else{
            $showerror="true";
            header("Location: /forms/index.php?loginsuccess=false");
        }
}
?>