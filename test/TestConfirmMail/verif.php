<?php
session_start();
require "../../functions.php";
//une fois qu'on se co on met à jour la bdd de
print_r($_SESSION);
print_r($_GET);
if($_GET['id']==$_SESSION['id']){
    if($_GET['cle']== $_SESSION['cle']){
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("UPDATE USER set role = 1 WHERE ID=:id ; ");
        $queryPrepared->execute(["id"=>$_SESSION['id']]);
        echo "Vous avez bien validé votre mail, cliquez sur le lien ci dessous pour vous connecter";
        echo "<br/><a href=http://51.255.172.36/login.php>Se Connecter</a>";
        }
    else
        echo "votre lien n'est plus valide";
}


?>