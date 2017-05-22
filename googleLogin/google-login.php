<!DOCTYPE html>
<html>
<head>
    <title></title>

<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>

<?php
session_start();
require_once "connectDB.php";
include_once 'google-config.php';

if(isset($_GET['code'])){
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
}
if (isset($_SESSION['token'])) {
    $gClient->setAccessToken($_SESSION['token']);
}
if ($gClient->getAccessToken()) {
    $gUserProfile = $google_oauthV2->userinfo->get();

    if ($conn->connect_error) {
            die("connection failed : ".$conn -> connect_error);
        }else{
            //variable FB Data
            $gg_id = $gUserProfile["id"];
            $gg_fname = $gUserProfile["given_name"];
            $gg_lname = $gUserProfile["family_name"];
            $gg_email = $gUserProfile["email"];

            $sql = "SELECT * FROM gg_login WHERE id_user = ".$gg_id."";
            $result = $conn->query($sql);

            if ($result -> num_rows == 0){
                $sql_insert = "INSERT INTO gg_login(`id_user`, `first_name`, `last_name`, `email`, `link`, `gender`, `locale`, `fb_createtime`) VALUES ('".$gg_id."', '".$gg_fname."', '".$gg_lname."', '".$gg_email."', '".$gg_link."', '".$gg_gender."', '".$gg_local."',Now())";
                
                $conn->query($sql_insert);
                // echo $sql_insert;
                echo "INSERT COMPLETE";
                header('Location:'.filter_var($gRedirectURL,FILTER_SANITIZE_URL));
            }else{
                echo "<h1>Login Success</h1>";
                
                echo "<p>with Google login</p>";
                // echo $sql;
                echo "<br>";
                    while ($row = $result -> fetch_assoc()) {
                        echo "<b>ID USER</b> = ".$row['id_user'];
                        echo "<br>";
                        echo "<b>First name</b> = ".$row['first_name'];
                        echo "<br>";
                        echo "<b>Last name</b> = ".$row['last_name'];
                        echo "<br>";
                        echo "<b>Email</b> = ".$row['email'];
                        echo "<a href='logout.php' class='btn-logout'>Logout</a>";
                    }
                $conn->close();
            }
        } 
    // ข้อมูลมาแล้วทำตรงนี้
}else{
    echo '<a href="'.$gloginUrl.'" class="btn-login">Login with Google</a>';
    
}

?>

</body>
</html>