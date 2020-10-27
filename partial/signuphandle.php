<?php
$showerror="false";
$showelert="false";
if($_SERVER["REQUEST_METHOD"] ==  "POST"){
        include 'dbconn.php';
        $signupemail=$_POST['signupemail'];
        $pass=$_POST['signuppass'];
        $cpass=$_POST['signupcpass'];
        $existsql="SELECT * FROM `users` WHERE useremail='$signupemail'";
        //check whetther this username exist
        $result = mysqli_query($conn, $existsql);
        $numrow=mysqli_num_rows($result);
        echo $numrow;
        if(($numrow) > 0){
          $showerror="Email is Already in use";
          $showerror=true;
          header("Location: /forms/index.php?signupsuccess=false");
        }
        else{
                if(($pass == $cpass) && ($pass !== " ") && ($cpass !== " ") && ($usernam !== " ")){
                    $hash = password_hash($pass, PASSWORD_DEFAULT);
                    $sql= "INSERT INTO `users` (`useremail`, `user_pass`, `timestamp`) VALUES ('$signupemail', '$hash', current_timestamp())";
                    $result=mysqli_query($conn, $sql);
                    if($result){
                        $showelert=true;
                        echo "$showelert";
                        header("Location: /forms/index.php?signupsuccess=true");
                        exit();
                    }
                }
                else{
                    $showerror="password do not match or Username Aleready Exists";
                    header("Location: /forms/index.php?signupsuccess=false");
                    exit();
                }
        }

}
?>