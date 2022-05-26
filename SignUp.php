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
		              <h2 class="fw-bold mb-2 text-uppercase">S'inscrire</h2>
		              <p class="text-white-50 mb-5">Merci de rentrer vos informations</p>
		              <div class="row">
		                <div class="col-lg-6 col-md-12 col-sm-12">
		                    <form method="POST" action="addUser.php">

								<input type="email" class="form-control" name="email" placeholder="Votre email" required="required"><br>

								<input type="text" class="form-control" name="firstname" placeholder="Votre prénom"><br>
								<input type="text" class="form-control" name="lastname" placeholder="Votre nom"><br>
								<input type="text" class="form-control" name="pseudo" placeholder="Votre pseudo"  required="required"><br>
					    </div>
					    <div class="col-lg-6 col-md-12 col-sm-12">

							<input type="date" class="form-control" name="birthday" placeholder="Votre date de naissance"><br>
							<input type="password" class="form-control" name="password" placeholder="Votre mot de passe"  required="required"><br>
							<input type="password" class="form-control" name="passwordConfirm" placeholder="confirmation" required="required"><br>
							<input class="my-3" type="checkbox" name="cgu"  required="required"> CGU <br>
					    </div>
					  </div>

					  
					<div class="row">
							<div class="col-lg-12">
								<div id="captcha">
                                    <div id="puzzle"></div>
                                </div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-md-12 col-sm-12">
	  							<input type="submit" class="btn btn-outline-light btn-lg py-2 " value="S'inscrire">
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

	<div class="col-lg-2 col-md-1 col-sm-0"></div>

<script src="ressources/js/captcha.js"></script>

<?php include "template/footer.php";?>