<?php
session_start();
if(isset($_POST['username']) && isset($_POST['password']))
{
 // connexion à la base de données
 $db_username = 'tbeaudoin';
 $db_password = 'Projetweb2022';
 $db_name = 'projet_web';
 $db_host = 'db4free.net:3306';
 $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
 or die('could not connect to database');

 $username = mysqli_real_escape_string($db,htmlspecialchars($_POST['username'])); 
 $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));
 
 if($username !== "" && md5($password) !== ""){

    $requete = "SELECT count(*) FROM user where 
    username = '".$username."' and password = '".md5($password)."' ";
    $exec_requete = mysqli_query($db,$requete);
    $reponse = mysqli_fetch_array($exec_requete);
    $count = $reponse['count(*)'];

    if($count!=0){
        $_SESSION['username'] = $username;
        $_SESSION['logged-in'] = true;
        header('Location: ../pages/home_connected.php');
    }
    else{
        header('Location: ../pages/login_page.php?error=1'); // utilisateur ou mot de passe incorrect
    }
 }
 else{

    $msg = "<center><h4>Username or Password are not correct, try again.</center></h4>";
    header("Location: ../pages/login_page.php?msg=$msg");    
}   




}
mysqli_close($db); // fermer la connexion
?>