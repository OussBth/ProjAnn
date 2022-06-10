<?php 
		session_start();
		require "functions.php";
	?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet"  href="./ressources/css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="ressources/style.css">

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	
	<link rel="icon" href="../../ressources/images/Utilitaires/logo.ico">
	<title>Cook'It</title>
</head>

<body class="h-auto bg-couleur">
	<header>
		<!-- Section menu haut -->
		<div class=" bg-color  p-2 row align-self-center" >
		<!-- <?php
			$_SESSION['pseudo'] = $pseudo;
		?> -->
		<?php 
			if (isConnected()){
				echo'<div class="col-lg-3 col-md-3    ">
							<img src="./ressources/images/avatars/default.png" height="100vh" width="100vw">
					</div>
					<div class="col-lg-2 col-md-2 align-self-center ">
									<a href="#" class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown">mon profil</a>
									<ul class="dropdown-menu">
										<li><a href="#" class="dropdown-item">Mes abonnements</a></li>
										<li><a href="#" class="dropdown-item">Mes recettes</a></li>
										<li><a href="./profil.php" class="dropdown-item">Modifier mon profil</a></li>
										<li><a href="./avatar.php" class="dropdown-item">Modifier mon Avatar</a></li>
										<li><a href="logout.php" class="dropdown-item">Se déconnecter</a></li>';
										
										if (isAdmin()) {
											echo'<li><a href="./admin.php" class="dropdown-item">Gérer les utilisateurs</a></li>
											</ul>';
										}
										else {
										echo "c pas bon chef";
										}
									echo'</ul>
							
					</div>';
				}else{
					echo'<div class="col-lg-1 col-md-1  align-self-center text-right">
								<a href="./SignUp.php" class="text-white">S\'inscrire</a>	
						</div>
                        
                        <div class="col-lg-1 col-md-1  align-self-center  ">
								<a href="./login.php" class=" text-white">Se connecter</a>
						</div>';
				}
				?>
			<div class="col-lg-5 col-md-5 col-sm-0 text-center align-self-center">
				<h1>Cook'It</h1>
			</div>
			<div class="col-lg-2 col-md-3 col-sm-5 text-right">
				<a href="index.php"><button type="button" class="btn text-white btn-lg"><img src="./ressources/images/Utilitaires/logo.png" height ="80vh" width="100vw" /></button></a>
			</div>
			
			<script src="./script.js"></script>
		</div>
		
	</header>