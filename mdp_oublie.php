<?php
include "template/header.php";
require "./test/TestConfirmMail/inscription.php";
?>

<div class="row">

	<div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center h-auto arrondie  ">
		<div class="container py-2  h-auto  ">
			<div class="row d-flex justify-content-center align-items-center h-100">

				<div class="card bg-color text-white" style="border-radius: 1rem;">
					<div class="card-body  text-center">
						<div class="mb-md-5 mt-md-4 pb-5">

							<h2 class="fw-bold mb-2 text-uppercase">Problèmes de connexion ?</h2>
							<p class="text-white-50 mb-5"> Entrez votre adresse mail et nous vous enverrons un lien pour récupérer votre compte.</p>

							<div class="row">

								<div class="col-lg-3 col-md-1 col-sm-0"></div>

								<div class="col-lg-6 col-md-12 col-sm-12">

									<form method="POST" action="">

										<input type="email" class="form-control" name="email" placeholder="Votre email" required="required"><br>

										<div class="row">

											<div class="col-lg-4 col-md-1 col-sm-0"></div>
											<div class="col-lg-4 col-md-12 col-sm-12">
												<input type="submit" class="btn btn-outline-light btn-lg py-2 " value="Envoyer">
											</div>

											<div class="col-lg-4 col-md-1 col-sm-0"></div>

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
	<?php

if(isset($_POST['email'])){
	// echo ("variable post ok");
	//si le mail n'est pas définit
	if (
		!isset($_POST["email"]) ||
		count($_POST) != 1
	) {
	
		die("remplissez le champ SVP !");
	}
	
	$email = $_POST["email"];
	//génération de la clé
	$cle = rand(1000000, 9000000);
	
	//Email OK
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Email incorrect";
		echo("email pas bon..");
	} else {
		//Vérification l'unicité de l'email
		$pdo = connectDB();
		$queryPrepared = $pdo->prepare("SELECT ID from USER WHERE MAIL = :email");
		$queryPrepared->execute(["email" => $email]);
		$result = $queryPrepared->fetch();
		// echo("récup du mail en bdd");
		if (isset($result['ID'])) {
			$_SESSION['cle'] = $cle;
			$_SESSION['email'] = $email;
			echo'<pre>';
			print_r($_SESSION);
			echo'</pre>';
			echo("envois mail");
			//envois du mail
			$from = 'support-cookit@cookit.com';
			$name = "Cookit-supportTeam";
			$subj = 'Mot de passe oublié';
			$msg = '<a href="http://51.255.172.36/mdpforget.php?id='.$result['ID'].'&cle='.$cle.'">Confirmer</a><h1>Confirmez le mail en cliquant sur le lien ci dessus</h1>';
			smtpmailer($email, $from, $name, $subj, $msg);
			//header("Location:login.php");
			print_r($_SESSION);
		}
		else {
			echo "l'email n'existe pas en bdd";
		}
	}
		//mise en session de la clé pour la vérification
	

}
	?>

	<?php include "template/footer.php"; ?>