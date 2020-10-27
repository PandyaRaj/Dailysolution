<?php
$contacterror="false";
$contactelert="false";
if($_SERVER["REQUEST_METHOD"] ==  "POST"){
        include 'dbconn.php';
        $cemail=$_POST['cemail'];
        $cname=$_POST['cname'];
        $cmsg=$_POST['cmsg'];
        //check whetther this username exist
                    $sql= "INSERT INTO `contact` (`email`, `msg`, `date`, `name`) VALUES ('$cemail', '$cmsg', current_timestamp(), '$cname')";
                    $result=mysqli_query($conn, $sql);
                    if($result){
                        $contactelert=true;
                         header("Location: /forms/contact.php?contactelert=true");
                        exit();
                    }else{
                        $contacterror=true;
                        header("Location: /forms/contact.php?contacterror=true");

                    }
                
               

}
?>