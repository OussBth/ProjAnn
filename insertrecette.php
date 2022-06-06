<?php
session_start();
require "functions.php";
// echo "testeurer";
// if(
// 	empty($_POST["recette"]) || 
// 	empty($_POST["recette_description"]) ||
// 	empty($_POST["fichier"])||
// 	count($_POST)!=3
// ){

// 	die("remplissez les champs requis");

// }else{
// 	echo "TEST";
// }

//création d'image
$final_file_name = "";
if (!empty($_POST['fichier'])){
    if(!empty($_FILES)){
        //enregistrement de l'image sur le serveur
        //nom du fichier
        $file_name = $_FILES['fichier']['name'];

        //emplacement du fichier
        $file_path = $_FILES['fichier']['tmp_name'];

        //destination que l'on souhaite pour fichier
        $destination = '/var/www/html/ProjAnn/ressources/images/images-recettes/';

        //extention du fichier
        $extension = strrchr($file_name, ".");
    
        //liste des extentions autorisées à être uploadées
        $extension_authorised = array('.png', '.PNG', '.jpg', '.jpeg', '.JPG', '.JPEG');



        //si le fichier est une image autorisé
        if(in_array($extension, $extension_authorised)){
            echo "test";
            // sert à bouger le fichier qui vient d'être upload dans la destination que l'on veut
            if(move_uploaded_file($_FILES['fichier']['tmp_name'], $destination.$file_name)){
                echo "Envoyé !";

                //création du filigranne
                $logo = imagecreatefrompng('ressource/images/Utilitaires/logo.png');

                //création de l'image de base
                $img = imagecreatefrompng($destination.$file_name);

                //création d'une canvas de mêmes dimensions que l'image
                $final_img = imagecreate(imagesx($img), imagesy($img));


                imagecopy($final_img, $img, 0, 0, 0, 0, imagesx($img), imagesy($img));
                imagecopy($final_img, $logo, 0, 0, 0, 0, 50, 50);

                //nom final du fichier (id de la recette et index de l'image) - A CHANGER
                $final_file_name = md5(sha1($_POST['recette'].$_POST['recette_description']).uniqid()."lavida").".png";

                //suppression de l'ancien fichier
                unlink($destination.$file_name);

                //création de l'image
                imagepng($final_img, $destination.$final_file_name);

                //libération de la mémoire
                imagedestroy($logo);
                imagedestroy($img);
                imagedestroy($final_img);
            }
            else{
                echo "Veuillez rentrer choisir une image au format PNG, JPG ou JPEG";
            }
                
        }
    
    }

}



//isertion reccette dans tables recipes
$recette = $_POST["recette"];
$recette_description = $_POST["recette_description"];
$fichier = $_POST["fichier"];

$pdo = connectDB();
$queryPrepared = $pdo->prepare("INSERT INTO RECIPES (        
ID_CREATOR, 
TITLE,      
DESCRIPTION,
PICTURE_PATH) 
VALUES (:idcreator, :title, :recettedesc, :path);");



$queryPrepared->execute([
						"idcreator"=>$_SESSION['id'],
						"title"=>$recette,
						"recettedesc"=>$recette_description,
						"path"=>$final_file_name
]);
// header("Location:recette.php");


$queryPrepared = $pdo->prepare("SELECT ID FROM RECIPES WHERE ID_CREATOR=:id AND TITLE=:title");
$queryPrepared->execute(["id"=>$_SESSION['id'], "title"=>$recette]);
$result = $queryPrepared->fetch();

//insertion ingrédient dans la table NEED
for ($i = 1; $i<6; $i++){
    $index = 'checkbox'.$i;
    if($_POST[$index]){
        $quantity = $_POST["quantity".$i];
        $queryPrepared = $pdo->prepare("INSERT INTO NEED VALUES (:quantity, :id_ingr, :id_recipe)");
        $queryPrepared->execute(["quantity"=>$quantity, "id_ingr"=>$i ,"id_recipe"=>$result['ID']]);
    }
}
?>