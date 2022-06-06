<?php   
		include "template/header.php";
?>
	
<div class="row">
	<div class="col-lg-2 col-md-1 col-sm-0"></div>
	<div class="col-lg-8 col-md-10 col-sm-12 h-auto arrondie  ">
		<div class="container py-2  h-auto  ">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="card bg-color text-white" style="border-radius: 1rem;">
					<div class="card-body  text-center">
						<div class="mb-md-5 mt-md-4 pb-5">
							<h2 class="fw-bold mb-2 text-uppercase">CREER UNE RECETTE</h2>
							<p class="text-white-50 mb-5">Partager vos recettes préférées</p>

							<div class="row">
								<div class="col-lg-12 col-md-12 bg-color arrondie py-5 ">
									<form method="POST" action="./insertrecette.php">

										<input type="text" class="form-control my-3" name="recette" placeholder="Nom de la recette" required="required"><br>
										<div class="row">
											<h3 class="text-center py-3">Ajouter une image à ma recette </h3>
												<input type="file" name="fichier" required="required"> <br>	
										</div>
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 input-group">
												<textarea class="form-control" aria-label="With textarea" placeholder="Votre Recette" name="recette_description" required="required"></textarea>
											</div>
										</div>
										<div class="row">
											<h3 class="text-center py-3">Ajouter les ingrédients </h3>
										</div>

										<?php
										$pdo = connectDB();

											$queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS;");
											$queryPrepared->execute();
											$results = $queryPrepared->fetchAll();

											foreach ($results as $key => $ingredient) { 
												echo '
													<div class="row">
														<div class="col-lg-2 col-md-1 col-sm-0"></div>
														<div class="col-lg-8 col-md-10 col-sm-12 background-body arrondie my-2">
															<div class="row align-items-center">
																	<div class="col-lg-1 col-md-1 col-sm-6">
																		<input  type="checkbox" name="checkbox'.$ingredient['ID'].'">
																	</div>
																	<div class="col-lg-3 col-md-3 col-sm-6">
																		<img src="'.$ingredient['PICTURE_PATH'].'" height ="70vh" width="70vw"/>
																	</div>
																	<div class="col-lg-3 col-md-3 col-sm-3">
																		<p>'.$ingredient['NAME'].'</p>
																	</div>
																	<div class="col-lg-3 col-md-2 col-sm-6 ">
																		<input class="input-width" type="text" name="quantity'.$ingredient['ID'].'" placeholder="quantité">
																	</div>
																	<div class="col-lg-2 col-md-3 col-sm-3">
																		'.$ingredient['UNIT'].'
																	</div>		
															</div>
														</div>
														<div class="col-lg-2 col-md-1 col-sm-0"></div>
													</div>';
											}?>
										
										<div class="row">
											<div class="col-lg-12 col-md-12">
												<input type="submit" value="Envoyer"></button>
											</div>
										</div>
									</form>
								</div>
							</div>
		    			</div>
					</div>
				</div>
			</div>
		</div>
	</div>		    	
	<div class="col-lg-2 col-md-1 col-sm-0"></div>
</div>

<?php

print '<pre>';
print_r($_POST);
print '</pre>';
if(!empty($_POST)){
	//création d'image
	$final_file_name = "";

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


	$queryPrepared = $pdo->prepare("SELECT ID FROM RECIPES WHERE ID_CREATOR=:id AND TITLE=:title");
	$queryPrepared->execute(["id"=>$_SESSION['id'], "title"=>$recette]);
	$result = $queryPrepared->fetch();

	//insertion ingrédient dans la table NEED
	for ($i = 1; $i<6; $i++){
		if(isset($_POST['checkbox'.$i])){
			$quantity = $_POST["quantity".$i];
			$queryPrepared = $pdo->prepare("INSERT INTO NEED VALUES (:quantity, :id_ingr, :id_recipe)");
			$queryPrepared->execute(["quantity"=>$quantity, "id_ingr"=>$i ,"id_recipe"=>$result['ID']]);
		}
	}

	if (!empty($_POST['fichier'])){
		print "<pre>";
		print_r($_FILES);
		print "</pre>";
		
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

			echo "test";

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
	// header("Location: recette.php?id=".$result['ID']);
	}

?>


<?php include "template/footer.php";?>



