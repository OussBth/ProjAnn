<?php
session_start();
include "./functions.php"; ?>
<?php


if (isConnected() == $_SESSION['id'] || isAdmin()) {
	$pdo = connectDB();

	// //récupération de la recette
	// $queryPrepared = $pdo->prepare("SELECT * FROM RECIPES WHERE ID_CREATOR = :id  AND ID_RECIPE = :idr");
	// $queryPrepared->execute(["id" => $_SESSION["id"], "idr" => $_POST["idrecipe"]]);
	// $resultR = $queryPrepared->fetch();

	// //récupération des besoins
	// $queryPrepared = $pdo->prepare("SELECT * FROM NEED WHERE ID_RECIPE = :id;");
	// $queryPrepared->execute(["id" => $_POST["idrecipe"]]);
	// $resultN = $queryPrepared->fetchAll();

	// $queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS WHERE ID IN (SELECT ID_INGREDIENT FROM NEED WHERE ID_RECIPE = :id);");
	// $queryPrepared->execute(["id" => $_POST["idrecipe"]]);
	// $ingredients = $queryPrepared->fetchAll();


	//on supprime tout les inredients pour pouvoir le mettre a jour après
	$queryPrepared = $pdo->prepare("DELETE FROM NEED WHERE ID_RECIPE = :id");
	$queryPrepared->execute(["id" => $_POST["idrecipe"]]);



	if (!empty($_FILES)) {
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
		if (in_array($extension, $extension_authorised)) {
			// sert à bouger le fichier qui vient d'être upload dans la destination que l'on veut
			if (move_uploaded_file($_FILES['fichier']['tmp_name'], $destination . $file_name)) {
				echo "Envoyé !";

				//création du filigranne
				$logo = imagecreatefrompng('ressources/images/Utilitaires/logo.png');

				//création de l'image de base
				if ($extension == '.png' || $extension == '.PNG') {
					$img = imagecreatefrompng($destination . $file_name);
					//création du nom de l'image
					$final_file_name = md5(sha1($_POST['title'] . $_POST['recette_description']) . uniqid() . "lavida") . ".png";
				} elseif ($extension == '.jpeg' || $extension == '.JPEG') {
					$img = imagecreatefromjpeg($destination . $file_name);
					//création du nom de l'image
					$final_file_name = md5(sha1($_POST['title'] . $_POST['recette_description']) . uniqid() . "lavida") . ".jpeg";
				} elseif ($extension == '.jpg' || $extension == '.JPG') {
					$img = imagecreatefromjpeg($destination . $file_name);
					//création du nom de l'image
					$final_file_name = md5(sha1($_POST['title'] . $_POST['recette_description']) . uniqid() . "lavida") . ".jpg";
				} else {
					die("hack");
				}

				// Définit les marges pour le cachet et récupère la hauteur et la largeur de celui-ci
				$marge_right = 10;
				$marge_bottom = 10;

				//récupération de la taille de l'image
				$sx = imagesx($logo);
				$sy = imagesy($logo);

				// Copie le cachet sur la photo en utilisant les marges et la largeur de la
				// photo originale  afin de calculer la position du cachet 
				imagecopy($img, $logo, imagesx($img) - $sx - $marge_right, imagesy($img) - $sy - $marge_bottom, 0, 0, imagesx($logo), imagesy($logo));

				//suppression de l'ancien fichier
				unlink($destination.$file_name);

				//création de l'image
				if ($extension == '.png' || $extension == '.PNG') {
					imagepng($img, $destination . $final_file_name);
				} elseif ($extension == '.jpeg' || $extension == '.JPEG' || $extension == '.jpg' || $extension == '.JPG') {
					imagejpeg($img, $destination . $final_file_name);
				}


				//libération de la mémoire
				imagedestroy($img);
				imagedestroy($logo);

				//on inscrit le chemin de la nouvelle image dans la recette
				$queryPrepared = $pdo->prepare("UPDATE RECIPES set PICTURE_PATH = :imgp where ID_RECIPE= :id;");
				$queryPrepared->execute(["imgp" => "https://cookit.ovh/ressources/images/images-recettes/" . $final_file_name, "id" => $_POST["idrecipe"]]);
			} else {
				echo "Veuillez rentrer choisir une image au format PNG, JPG ou JPEG";
			}
		}
	}


	//on rentre le titre
	$queryPrepared = $pdo->prepare("UPDATE RECIPES set TITLE = :title WHERE ID_RECIPE = :id");
	$queryPrepared->execute(["title" => $_POST["title"], "id" => $_POST["idrecipe"]]);

	//on rentre la description
	$queryPrepared = $pdo->prepare("UPDATE RECIPES set DESCRIPTION = :desc WHERE ID_RECIPE = :id");
	$queryPrepared->execute(["desc" => $_POST["recette_description"] = nl2br($_POST["recette_description"]), "id" => $_POST["idrecipe"]]);

	//récupération du nombre d'ingrédients
	$queryPrepared = $pdo->prepare("SELECT count(ID) FROM INGREDIENTS;");
	$queryPrepared->execute();
	$nbingredients = $queryPrepared->fetch();

	//on inscrit les nouvelles valeurs des ingredients 1 à count id ingredient
	for ($i = 1; $i < $nbingredients[0]; $i++) {
		//vérification de la présence de chaque ingrédients dans la modif de recette
		if (isset($_POST['checkbox' . $i])) {
			if (!empty($_POST['quantity' . $i])) {
				//mise en bdd
				$quantity = $_POST["quantity" . $i];
				$queryPrepared = $pdo->prepare("INSERT INTO NEED VALUES (:quantity, :id_ingr, :id_recipe);");
				$queryPrepared->execute(["quantity" => $_POST['quantity' . $i], "id_ingr" => $i, "id_recipe" => $_POST["idrecipe"]]);
			}
		}
	}

	header("Location: https://cookit.ovh/recette.php?id=" . $_POST["idrecipe"]);
}
?>