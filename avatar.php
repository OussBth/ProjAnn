<?php include "template/header.php";?>
<!-- <link href="style.css" rel="stylesheet"> -->

<div class="row">

	

			<div class="col-lg-12 col-md-12 col-sm-12 h-auto arrondie d-flex justify-content-center ">
					  <div class="container py-2  h-auto  ">
					    <div class="row d-flex justify-content-center align-items-center h-100">
					      
					        <div class="card bg-color text-white" style="border-radius: 1rem;">
					          <div class="card-body  text-center">

					            <div class="mb-md-5 mt-md-4 pb-5">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2">
                                        </div>
                                        <div class="col-lg-8 col-md-8 text-center" id="avatar-canva">
                                        </div>
                                        <div class="col-lg-2 col-md-2">
                                        </div>
                                    </div>
                                    <br>

                                    <!-- Peau -->
                                    <div class="row py-3">
                                        <div class= "col-lg-4 col-md-4 col-sm-4">
                                            <button type="button" class="btn btn-secondary btn-lg" id="button-prev-skin" onclick="change_part('prev-skin');"><</button>
                                        </div>
                                        <div class= "col-lg-4 col-md-4 col-sm-4 d-flex text-white text-center justify-content-center">
                                            <p> Couleur de Peau </p>
                                        </div>
                                        <div class= "col-lg-4 col-md-4 col-sm-4">
                                            <button type="button" class="btn btn-secondary btn-lg" id="button-next-skin" onclick="change_part('next-skin');">></button>
                                        </div>  
                                    </div>

                                    <!-- Yeux -->
                                    <div class="row py-3">
                                        <div class= "col-lg-4 col-md-4 col-sm-4">
                                            <button type="button" class="btn btn-secondary btn-lg" id="button-prev-eye" onclick="change_part('prev-eye');"><</button>
                                        </div>
                                        <div class= "col-lg-4 col-md-4 col-sm-4 text-white text-center">
                                            <p> Couleur des Yeux </p>
                                        </div>
                                        <div class= "col-lg-4 col-md-4 col-sm-4">
                                            <button type="button" class="btn btn-secondary btn-lg" id="button-next-eye" onclick="change_part('next-eye');">></button>
                                        </div>  
                                    </div>

                                    <!-- Bouche -->
                                    <div class="row py-3">
                                        <div class= "col-lg-4 col-md-4 col-sm-4">
                                            <button type="button" class="btn btn-secondary btn-lg" id="button-prev-mouth" onclick="change_part('prev-mouth');"><</button>
                                        </div>
                                        <div class= "col-lg-4 col-md-4 col-sm-4 text-white text-center">
                                            <p> Couleur de Bouche </p>
                                        </div>
                                        <div class= "col-lg-4 col-md-4 col-sm-4">
                                            <button type="button" class="btn btn-secondary btn-lg" id="button-next-mouth" onclick="change_part('next-mouth');">></button>
                                        </div>  
                                    </div>
                                    <div class="row">
                                        <a id="avatar-download-button" href="">Télécharger l'avatar</a>
                                    </div>
					            </div>
					           </div>
					        </div>
					    </div>
					  </div>
			</div>
</div>

<script src="ressources/js/avatar.js"></script>


