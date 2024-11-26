<?php 
   session_start();

   include('phpqrcode/qrlib.php');
   include("php/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: index.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Home</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">Logo</a> </p>
        </div>

        <div class="right-links">

            <?php 
            
            $id = $_SESSION['id'];
            $query = mysqli_query($con,"SELECT * FROM users WHERE Id=$id");

            while($result = mysqli_fetch_assoc($query)){
                $res_Uname = $result['Username'];
                $res_Email = $result['Email'];
                $res_Age = $result['Age'];
                $res_id = $result['Id'];
            }
            
            echo "<a href='edit.php?Id=$res_id'>Change Profile</a>";
            ?>

            <a href="php/logout.php"> <button class="btn">Log Out</button> </a>

        </div>
    </div>
    <main>

       <div class="main-box top">
          <div class="top">
            <div class="box">
                <p>Hello <b><?php echo $res_Uname ?></b>, Welcome</p>
            </div>
            <div class="box">
                <p>Your email is <b><?php echo $res_Email ?></b>.</p>
            </div>
          </div>
          <div class="bottom">
            <div class="box">
                <p>And you are <b><?php echo $res_Age ?> years old</b>.</p> 
            </div>
          </div>
          <div class="bottom">
            <div class="box">
                <p>this is your qrcode</p>
                <?php

            require_once('phpqrcode/qrlib.php'); 

            $qrvalue = $res_Uname = $result['Username'];

            $tempDir = "/pdfqrcodes/";
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            if (!is_writable($tempDir)) {
                die("Error: Folder pdfqrcodes/ tidak dapat ditulisi.");
            }  
            $fileName = $qrvalue . '.png'; 
            $pngAbsoluteFilePath = $tempDir . $fileName; 
            $urlRelativeFilePath = $tempDir . $fileName; 
            if (!file_exists($pngAbsoluteFilePath)) { 
                QRcode::png($qrvalue, $pngAbsoluteFilePath); 
            }
            if (file_exists($pngAbsoluteFilePath)) {
                echo "<p>QR Code berhasil dibuat:</p>";
                echo "<img src='$urlRelativeFilePath' alt='QR Code'>";
            } else {
                echo "Gagal membuat QR Code.";    
                ?>    
            </div>
       </div>
       <?php }?>         
    </main>
</body>
</html>

