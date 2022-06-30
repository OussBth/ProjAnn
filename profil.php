<?php
include "template/header.php";
?>
        <?php
        $pdo = connectDB();

        //récupération des informations du profil
        $queryPrepared = $pdo->prepare("SELECT * FROM USER WHERE  USER.ID = :id;");
        $queryPrepared->execute(["id" => $_GET["id"]]);
        $user = $queryPrepared->fetch();

        //récupération du nombre de recette créée par ce profil
        $queryPrepared = $pdo->prepare("SELECT COUNT(ID_RECIPE) FROM RECIPES WHERE ID_CREATOR = :id;");
        $queryPrepared->execute(['id' => $_GET["id"]]);
        $nbrecipe = $queryPrepared->fetch();

        //récupération du nombre d'abonnés à ce profil
        $queryPrepared = $pdo->prepare("SELECT COUNT(ID_SUBSCRIBER) FROM SUBSCRIPTION WHERE SUBSCRIPTION.ID_SUBSCRIPTION = :id AND STATUS = 1;");
        $queryPrepared->execute(["id" => $_GET["id"]]);
        $abonnes = $queryPrepared->fetch();

        //récupération du nombre d'abonnement de ce profil
        $queryPrepared = $pdo->prepare("SELECT COUNT(ID_SUBSCRIPTION) FROM SUBSCRIPTION WHERE SUBSCRIPTION.ID_SUBSCRIBER = :id AND STATUS = 1;");
        $queryPrepared->execute(["id" => $_GET["id"]]);
        $abonnement = $queryPrepared->fetch();


        //affichages des boutons sur le profil

        if($_SESSION['id'] != $_GET['id']){
            $ownpage = 0;

            //Verification que l'un est bien abonné à l'autre
            $queryPrepared = $pdo->prepare("SELECT STATUS FROM SUBSCRIPTION WHERE ID_SUBSCRIBER = :sender AND ID_SUBSCRIPTION = :receveur");
            $queryPrepared->execute(["sender"=>$_SESSION['id'], "receveur"=>$_GET['id']]);
            $state1 = $queryPrepared->fetch();
    
            //vérification que l'autre est bien abonné à l'un
            $queryPrepared = $pdo->prepare("SELECT STATUS FROM SUBSCRIPTION WHERE ID_SUBSCRIBER = :sender AND ID_SUBSCRIPTION = :receveur");
            $queryPrepared->execute(["receveur"=>$_SESSION['id'], "sender"=>$_GET['id']]);
            $state2 = $queryPrepared->fetch();

        }else{
            $ownpage = 1;
        }

        /*
        tous les états possibles :
        u = 1 p = 1     messages supprimer bloquer
        u = 1 p = 0     supprimer bloquer
        u = 1 p = -1    supprimer bloquer

        u = 0 p = 1     s'abonner bloquer
        u = 0 p = 0     s'abonner bloquer
        u = 0 p = -1    bloquer

        u = -1 p = 1    débloquer
        u = -1 p = 0    débloquer
        u = -1 p = -1   débloquer
        */


        ?>

<div class="row">
    <div class="container bg-color justify-content-center my-3 py-5 arrondie">
        <div class="col-lg-5">
            <img src=".<?= $user['PATH_AVATAR'] ?>" class="text-right cardh" alt="avatar.png">
        </div>
        <div class="col-lg-7 col-md-5">
                <div class="row">
                    <div class="col-lg-6 col-md-6 my-3">
                        <h4><?= $user['PSEUDO'] ?></h4>
                    </div>



                    
                    <?php
                        //s'il s'agit de la page d'un autre utilisateur
                        if($ownpage == 0){
                            if(isset($state1[0])){
                                if($state1[0] == 1){
                                    if($state2[0] == 1){
                                        //afficher le bouton message
                                        echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                            <a href="#" class=" btn btn-secondary" style="height : 30px"><p>Message</p></a>
                                        </div>';
    
                                    }
                                    //afficher le bouton supprimer
                                    echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                        <a href="#" class=" btn btn-secondary" style="height : 30px"><p>Désabonner</p></a>
                                    </div>';
    
                                }elseif ($state1[0] == -1) {
                                    //afficher le bouton pour débloquer
                                    echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                        <a href="#" class=" btn btn-secondary" style="height : 30px"><p>Débloquer</p></a>
                                    </div>';
    
                                }
    
                            }elseif(!isset($state2[0]) || $state2[0] == 1) {
                                //affichage du bouton s'abonner
                                echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                    <a href="#" class=" btn btn-secondary" style="height : 30px"><p>S\'abonner</p></a>
                                </div>';

                            }

                            echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                    <a href="#" class=" btn btn-secondary" style="height : 30px"><p>Bloquer</p></a>
                                </div>';
                        
                        //sinon, il s'agit de la propre page du user
                        }else{
                            echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                                    <a href="modif_profil.php" class=" btn btn-secondary" style="height : 30px"><p>Modifier mon profil</p></a>
                                </div>';
                        }
                        




                        // if ($user['ID'] == $_SESSION['id']){
                        //     echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                        //             <a href="modif_profil.php" class=" btn btn-secondary" style="height : 30px"><p>Modifier mon profil</p></a>
                        //         </div>';
                        // }else{
                        //     echo'<div class="col-lg-6 col-md-6 d-flex justify-content-end">
                        //             <a href="#" class=" btn btn-secondary" style="height : 30px"><p>S\'abonner</p></a>
                        //         </div>';
                        // }
                    ?>

                    </div>          
                    <div class="row my-5">
                        <div class="col-lg-4 ">
                            <h4>Recettes : <?= $nbrecipe[0]?></h4>
                        </div>
                        <div class="col-lg-4">
                            <a href="viewsub.php?id=<?php$_GET['id']?>"><h4>Abonnés : <?= $abonnes[0]?></h4>
                        </div>
                        <div class="col-lg-4">
                            <h4>Abonnement : <?= $abonnement[0]?></h4>
                        </div>
                    </div>
                </div>
        </div>         
    </div>







    



<!-- Affichage des recettes crée par l'utilisateur -->
        <?php 

        
        $queryPrepared = $pdo->prepare("SELECT * FROM RECIPES WHERE  RECIPES.ID_CREATOR = :id  ORDER BY RECIPES.ID_RECIPE DESC;");
        $queryPrepared->execute(["id" => $_GET["id"]]);
        $results = $queryPrepared->fetchAll();

        
        echo'
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">';
        foreach ($results as $result){
            echo '
                    <div class="col-lg-4 col-md-4 col-sm-1 py-3">
                        <div class="card mb-4 shadow-sm bg-color py-3 px-3 arrondie">
                            <a href="https://cookit.ovh/recette.php?id='.$result['ID_RECIPE'].'">
                            <img src="'.$result['PICTURE_PATH'].'" class="card-img-top cardh"> </img>
                            <div class="card-body text-center arrondie">
                                        <h4>'.$result['TITLE'].'</h4>   
                            </div>
                            </a>        
                        </div>
                    </div>';
        }
        echo '
            </div>
            <div class="col-lg-2"></div>
        </div>';


        ?>


    </body>
</html>
