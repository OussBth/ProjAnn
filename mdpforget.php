<?php
    require "header.php";
?>
<div class="col-lg-6 col-md-12 col-sm-12">

<form method="POST">

    <input type="email" class="form-control" name="password" placeholder="Votre Mot de passe" required="required"><br>
    <input type="email" class="form-control" name="passwordconfirm" placeholder="Confirmez votre Mot de passe" required="required"><br>
    
  </form>
</div>
<div class="row">

<div class="col-lg-4 col-md-1 col-sm-0"></div>
<div class="col-lg-4 col-md-12 col-sm-12">
    <input type="submit" class="btn btn-outline-light btn-lg py-2 " value="Envoyer">
</div>
<div class="col-lg-4 col-md-1 col-sm-0"></div>

</div>
    
<?php

if(
	empty($_POST["password"]) ||
	empty($_POST["passwordConfirm"]) ||
	count($_POST)!=2
){

	die("Remplissez les deux champs SVP !");

}

    $pdo = connectDB();
    
    $pwd = $_POST["password"];
    
    $pwd = password_hash($pwd, PASSWORD_DEFAULT);
    
    if($_POST['id']==$_SESSION['id']){
        if($_POST['cle']== $_SESSION['cle']){
            $queryPrepared = $pdo->prepare("UPDATE USER set HASHPWD =:pwd WHERE MAIL=:email AND ID =:id; ");
            $queryPrepared->execute(["pwd"=>$pwd,"email"=>$_SESSION['email'], "id"=>$_SESSION['id']]);

            echo "Vous avez bien changé votre mot de passe, cliquez sur le lien ci dessous pour vous connecter";
            echo "<br/><a href=http://51.255.172.36/ProjAnn/login.php>Se Connecter</a>";
            }
        else
            echo "votre lien n'est plus valide";
    }
?>